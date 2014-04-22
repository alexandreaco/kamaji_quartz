<?php

	/*	model.php
	 *
	 *	Author: Erik Geil
	 *	Date: 4/23/14
	 * 
	 */
	 
	 
	class Model{

		private function connect() {
			$mysqli = new mysqli("localhost", "root","","quartz");

			if ($mysqli->connect_error)
			{
				print("PHP unable to connect to MySQL server; error (" . $mysqli->connecterrno . "): "
						. $mysqli->connect_error);
					exit();
			}

			return $mysqli;
		}

		function getAdminStatus($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return '0';
			} else {
				$row = $result->fetch_assoc();
				$status = stripslashes($row["adminstatus"]);
				$mysqli->close();

				return $status;
			}
		}

		function createDatabase($databaseName,$server,$rootPass,$adminName,$adminPass){		
			// Checks to see if the root pass is an empty string
			if($rootPass=="0") {
				$mysqli = new mysqli($server, "root","");
			} else {
				$mysqli = new mysqli($server, "root",$rootPass);
			}

			if ($mysqli->connect_error)
			{
					exit();
			}

			// Create the new database.
			$query = "CREATE DATABASE IF NOT EXISTS $databaseName;";
			$mysqli->query($query);

			$query = "USE $databaseName;";
			$mysqli->query($query);

			$query = "CREATE TABLE IF NOT EXISTS `users`
				(`id` int NOT NULL auto_increment,
				`name` text NOT NULL,
				`accountname` text NOT NULL,
				`email` text NOT NULL,
				`password` text NOT NULL,
				`jobTitle` text,
				`address` text,
				`telephone` text,
				`fax` text,
				`officeHours` text,
				`biography` text,
				`research` text,
				`publications` text,
				`personal` text,
				`adminstatus` text,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);

			$query = "CREATE TABLE IF NOT EXISTS `emails`
				(`id` int NOT NULL auto_increment,
				`email` text NOT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);

			$query = "CREATE TABLE IF NOT EXISTS `courses`
				(`id` int NOT NULL auto_increment,
				`accountname` text NOT NULL,
				`course` text NOT NULL,
				`title` text NOT NULL,
				`description` text NOT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);				

			$query = "CREATE TABLE IF NOT EXISTS `images`
				(`id` int NOT NULL auto_increment,
				`accountname` text NOT NULL,
				`image` text,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$query = "CREATE TABLE IF NOT EXISTS `activity`
				(`id` int NOT NULL auto_increment,
				`accountname` text NOT NULL,
				`activity` text,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);

			$query = "GRANT ALL ON $databaseName.* TO '$adminName'@'$server';";
			$mysqli->query($query);

			$query = "SET PASSWORD FOR '$adminName'@'$server' = PASSWORD('$adminPass');";
			$mysqli->query($query);

			$mysqli->close();

			$this->addEmail($adminName."@bu.edu");
			$this->createUser("",$adminName."@bu.edu",$adminPass,'1');

			mkdir("./assets/profPics");
		}

		function deleteDatabase($databaseName){
			$mysqli = new mysqli("localhost", "root","");

			if ($mysqli->connect_error)
			{
				print("PHP unable to connect to MySQL server; error (" . $mysqli->connecterrno . "): "
						. $mysqli->connect_error);
					exit();
			}

			$query = "DROP DATABASE IF EXISTS $databaseName;";
			$mysqli->query($query);
			$mysqli->close();

			if(is_dir("assets/profPics")){
				rmdir("assets/profPics");
			}

			return "The following database has been deleted:<br><br><b>$databaseName</b>";
		}

		function addEmail($email){
			$mysqli = $this->connect();

			$query = "SELECT COUNT(*) FROM emails WHERE email='$email'";
			$result = $mysqli->query($query);
			$rows = $result->fetch_row();

			if($rows[0]==0){
				$query = "INSERT INTO emails SET email='$email';";

				$mysqli->query($query);

				$mysqli->close();
				return "The following email has been approved:<br><br>
					   <b>'$email'<br></b>";
			} else {
				return "Email Already Approved.";
			}				
		}

		function removeEmail($email){
			$mysqli = $this->connect();

			$query = "DELETE FROM emails WHERE email='$email';";
			$mysqli->query($query);
			$mysqli->close();

			return "The following email has been removed:<br><br>
				   <b>'$email'<br></b>";
		}

		function getEmails() {
			$mysqli = $this->connect();

			$query = "SELECT * FROM emails";
			$result = $mysqli->query($query);

			$res = "Approved emails:<br><br>";
			for($row = $result->fetch_assoc(); $row != FALSE; 
						$row = $result->fetch_assoc())
			{
				$email = stripslashes($row["email"]);
				$res .= "<b>'$email'</b><br>";
			}
			$mysqli->close();
			return $res;
		}

		function checkEmail($email) {
			$mysqli = $this->connect();

			$query = "SELECT COUNT(*) FROM emails WHERE email='$email';";
			$result = $mysqli->query($query);
			$rows = $result->fetch_row();
			$mysqli->close();

			if($rows[0]==0) {
				return FALSE;
			} else {
				return TRUE;
			}
		}

		function createUser($name,$email,$password,$adminStatus){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT COUNT(*) FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);
			$rows = $result->fetch_row();

			if($this->checkEmail($email)){
				if($rows[0]==0){
					$query = "INSERT INTO users SET name='$name', 
							  accountname='$accountname',
							  email='$email',
							  password=MD5('$password'),
							  adminstatus=$adminStatus;";

					$mysqli->query($query);

					$mysqli->close();
					return "Created the User:<br><br>
						   <b>Name: '$name'<br>
						   Email: '$email'<br></b>";
				} else {
					$mysqli->close();
					return "ERROR: Entry already Exists with that Account Name.";
				}
			} else {
				return "Email has not been approved<br>.";
			}
		}

		function deleteUser($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "DELETE FROM users WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();
			return "Deleted the following user from the database:<br><br><b>$accountname</b>";
		}

		function getUserByName($name){
			$mysqli = $this->connect();

			$query = "SELECT * FROM users WHERE name='$name'";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$name = stripslashes($row["name"]);

					$email = stripslashes($row["email"]);
					$res .= "<b>Name: '$name'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;
		}

		function getUserByEmail($email){
			$mysqli = $this->connect();

			$query = "SELECT * FROM users WHERE email='$email';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$name = stripslashes($row["name"]);
					$email = stripslashes($row["email"]);
					$res .= "<b>Name: '$name'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;
		}

		function getAllUsers(){
			$mysqli = $this->connect();

			$query = "SELECT * FROM users;";
			$result = $mysqli->query($query);

			$res = "Found the following Users:<br><br>";

			for($row = $result->fetch_assoc(); $row != FALSE; 
						$row = $result->fetch_assoc())
			{
				$name = stripslashes($row["name"]);
				$email = stripslashes($row["email"]);
				$res .= "<b>Name: '$name'<br>
					   email: '$email'</b><br><br>";
			}
			$mysqli->close();

			return $res;
		}

		function changeName($email, $newName){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET name='$newName' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();

			return "User has been Updated:<br><br>
				  <b>Name: '$newName'<br>
				  Email: '$email'</b>";
		}

		function changeEmail($oldEmail,$newEmail){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $oldEmail); 
			
			$query = "UPDATE users SET email='$newEmail', accountname='$accountname' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);

			$mysqli->close();
			return "User has been Updated:<br><br>
				  <b>Email: '$newEmail'</b>";		
		}

		function changePassword($email, $newPassword){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET password='$newPassword' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Password has been Updated.";
		}

		function addCourse($email,$name,$title,$description){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT COUNT(*) FROM courses WHERE course='$name' AND accountname='$accountname'";
			$result = $mysqli->query($query);
			$rows = $result->fetch_row();

			if($rows[0]==0){
				$query = "INSERT INTO courses SET course='$name',
						  accountname='$accountname',
						  title='$title',
						  description='$description';";

				$mysqli->query($query);

				$mysqli->close();
				return "The following Course has been Created:<br><br>
					   <b>Course: '$name'<br>
					   	Title: '$title'<br>
					   	Description: '$description'</b>";
			} else {
				return "Course Already Exists for the User.";
			}		
		}

		function deleteCourse($name){
			$mysqli = $this->connect();

			$query = "DELETE FROM courses WHERE course='$name';";

			$mysqli->query($query);

			$mysqli->close();
			return "The following course has been removed:<br><br>
				   <b>'$name'<br></b>";
		}

		function changeCourseTitle($email, $course, $newTitle){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE courses SET title='$newTitle' WHERE course='$course' AND accountname='$accountname'";
			$result = $mysqli->query($query);

			$mysqli->close();	
			return "Course has been Updated:<br><br>
				  <b>Course: '$course'<br>
				  Title: '$newTitle'<br></b>";
		}

		function changeCourseDescription($email, $course, $newDescription){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE courses SET description='$newDescription' WHERE course='$course' AND accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();
			return "Course has been Updated:<br><br>
				  <b>Course: '$course'<br>
				  Description: '$newDescription'<br></b>";
		}

		function setJobtitle($email, $title) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET jobTitle='$title' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Job Title has been set to '$title'";
		}

		function setAddress($email, $address) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET address='$address' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Address has been set to '$address'";
		}

		function setTelephone($email, $telephone) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET telephone='$telephone' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Telephone has been set to '$telephone'";			
		}

		function setFax($email, $fax) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET fax='$fax' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Fax has been set to '$fax'";			
		}

		function setOfficeHours($email, $officeHours) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET officeHours='$officeHours' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Office Hours have been set to '$officeHours'";
		}

		function setBiography($email, $biography){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET biography='$biography' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Biography has been set to: '$biography'";			
		}

		function setResearch($email, $research) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET research='$research' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Research has been set to: '$research'";				
		}

		function setPublications($email, $publications) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET publications='$publications' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Publications have been set to: '$publications'";
		}

		function setPersonal($email, $personal) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET personal='$personal' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
			return "Personal have been set to: '$personal'";
		}

		function getJobtitle($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$title = stripslashes($row["jobTitle"]);
					$email = stripslashes($row["email"]);
					$res .= "<b>Title: '$title'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;
		}

		function getAddress($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$address = stripslashes($row["address"]);
					$res .= "<b>Address: '$address'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;
		}

		function getTelephone($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$telephone = stripslashes($row["telephone"]);
					$res .= "<b>Telephone #: '$telephone'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;
		}

		function getFax($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$fax = stripslashes($row["fax"]);
					$res .= "<b>Fax #: '$fax'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;			
		}

		function getOfficeHours($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$officeHours = stripslashes($row["officeHours"]);
					$res .= "<b>Office Hours: '$officeHours'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();
			}

			return $res;			
		}

		function getBiography($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$biography = stripslashes($row["biography"]);
					$res .= "<b>Biography: '$biography'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();			
			}
			return $res;
		}

		function getResearch($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$research = stripslashes($row["research"]);
					$res .= "<b>Research: '$research'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();			
			}
			return $res;			
		}

		function getPublications($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$publications = stripslashes($row["publications"]);
					$res .= "<b>Publications: '$publications'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();			
			}
			return $res;
		}

		function getPersonal($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			$res = "";

			if($result->num_rows == 0){
				$mysqli->close();
				$res .= "No User Found<br>";
			} else {
				$res .= "Found the following User:<br><br>";
				for($row = $result->fetch_assoc(); $row != FALSE; $row = $result->fetch_assoc())
				{
					$email = stripslashes($row["email"]);
					$personal = stripslashes($row["personal"]);
					$res .= "<b>Personal: '$personal'<br>
						   email: '$email'</b><br><br>";
				}
				$mysqli->close();			
			}
			return $res;
		}

		function setImage($image,$email){
			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email);
		}

		function getImage($email) {

		}

		function checkCredentials($email, $pass)
		{
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "Invalid Username";
			} else {

				$row = $result->fetch_assoc();
				$password = stripslashes($row["password"]);
				$mysqli->close();

				if(md5($pass) == $password) {
					return "Valid Credentials";
				} else {
					return "Invalid Password";
				}
			}
		}
	}


?>