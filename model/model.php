<?php

	/*	model.php
	 *
	 *	Author: Erik Geil
	 *	Date: 4/23/14
	 * 
	 */
	 
	 
	class Model{

		private function connect() {

			$pass = $this->dudeBro();

			if ($pass == '0'){
				$mysqli = new mysqli("localhost", "root","","dudebro");
			} else {
				$mysqli = new mysqli("localhost", "root",$pass,"dudebro");
			}
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

		function createDatabase($server,$rootPass,$adminName,$adminPass, $emails){		
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
			$query = "CREATE DATABASE IF NOT EXISTS dudebro;";
			$mysqli->query($query);

			$query = "USE dudebro;";
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
				`awards` text,
				`adminstatus` text,
				`image` text,
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
				`title` text,
				`description` text,
				`url` text,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);				

			$query = "CREATE TABLE IF NOT EXISTS `activity`
				(`id` int NOT NULL auto_increment,
				`accountname` text NOT NULL,
				`activity` text,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);

			$query = "CREATE TABLE IF NOT EXISTS `registration`
				(`id` int NOT NULL auto_increment,
				`name` text,
				`email` text,
				`password` text,
				`regid` text,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";
			$mysqli->query($query);

			$query = "GRANT ALL ON 'dudebro'.* TO '$adminName'@'$server';";
			$mysqli->query($query);

			$query = "SET PASSWORD FOR '$adminName'@'$server' = PASSWORD('$adminPass');";
			$mysqli->query($query);

			$mysqli->close();

			$this->addEmail($adminName."@bu.edu");
			$this->createUser("",$adminName."@bu.edu",$adminPass,'1');

			$emailArray = explode(';', $emails);

			foreach($emailArray as $email) {
				$this->addEmail($email);
			}

			mkdir("./assets/profPics");
		}

		function deleteDatabase(){
			$mysqli = $this->connect();

			$query = "DROP DATABASE IF EXISTS dudebro;";
			$mysqli->query($query);
			$mysqli->close();

			if(is_dir("assets/profPics")){
				rmdir("assets/profPics");
			}
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
			}			
		}

		function removeEmail($email){
			$mysqli = $this->connect();

			$query = "DELETE FROM emails WHERE email='$email';";
			$mysqli->query($query);
			$mysqli->close();
		}

		function getEmails() {
			$mysqli = $this->connect();

			$query = "SELECT * FROM emails";
			$result = $mysqli->query($query);

			$res = "";
			for($row = $result->fetch_assoc(); $row != FALSE; 
						$row = $result->fetch_assoc())
			{
				$email = stripslashes($row["email"]);
				$res .= $email.";";
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
							  jobTitle='Title',
							  address='Default Address',
							  telephone='(xxx)xxx-xxxx',
							  fax='(xxx)xxx-xxxx',
							  officeHours='Everyday',
							  biography='This is a short biography.',
							  research='This is my research.',
							  publications='Here are my publications.',
							  personal='About Me.',
							  adminstatus=$adminStatus;";

					$mysqli->query($query);
				}
			}
			$mysqli->close();
		}

		function deleteUser($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "DELETE FROM users WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();
		}

		function getName($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$name = stripslashes($row["name"]);
				return $name;
			}
		}

		function getAllUsers(){
			$mysqli = $this->connect();

			$query = "SELECT * FROM users;";
			$result = $mysqli->query($query);

			$res = "";

			for($row = $result->fetch_assoc(); $row != FALSE; 
						$row = $result->fetch_assoc())
			{
				$name = stripslashes($row["name"]);
				$email = stripslashes($row["email"]);
				$res .= $email.";";
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
		}

		function changeEmail($oldEmail,$newEmail){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $oldEmail); 
			
			$query = "UPDATE users SET email='$newEmail', accountname='$accountname' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);

			$mysqli->close();
		}

		function changePassword($email, $newPassword){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET password='$newPassword' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
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
				return TRUE;
			} else {
				return FALSE;
			}		
		}

		function deleteCourse($name){
			$mysqli = $this->connect();

			$query = "DELETE FROM courses WHERE course='$name';";

			$mysqli->query($query);

			$mysqli->close();
		}

		function changeCourseTitle($email, $course, $newTitle){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE courses SET title='$newTitle' WHERE course='$course' AND accountname='$accountname'";
			$result = $mysqli->query($query);

			$mysqli->close();	
		}

		function changeCourseDescription($email, $course, $newDescription){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE courses SET description='$newDescription' WHERE course='$course' AND accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();
		}

		function setJobtitle($email, $title) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET jobTitle='$title' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setAddress($email, $address) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET address='$address' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setTelephone($email, $telephone) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET telephone='$telephone' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

	    function dudeBro() {
	    	if(file_exists("assets/info.txt")) {
	    		$file = "assets/info.txt";
	    	} else {
	    		$file = "../assets/info.txt";
	    	}
				
			$fh = fopen($file, "r");

			$count = 0;
			$server = "";

		    while (($line = fgets($fh)) !== false) {
		       	if($count == 1) {
		       		$server = trim($line);
		       		break;
		       	}
		       	$count += 1;
		    }

		    return $server;
	    }

		function setFax($email, $fax) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET fax='$fax' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setOfficeHours($email, $officeHours) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET officeHours='$officeHours' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setBiography($email, $biography){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET biography='$biography' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setResearch($email, $research) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET research='$research' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setPublications($email, $publications) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET publications='$publications' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setPersonal($email, $personal) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET personal='$personal' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function setAwards($email, $awards) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 
			
			$query = "UPDATE users SET awards='$awards' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function getJobtitle($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$title = stripslashes($row["jobTitle"]);
				$mysqli->close();
				
				return $title;
			}
		}

		function getAddress($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$address = stripslashes($row["address"]);
				$mysqli->close();
				return $address;
			}
		}

		function getTelephone($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$telephone = stripslashes($row["telephone"]);
				$mysqli->close();

				return $telephone;
			}
		}

		function getFax($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$fax = stripslashes($row["fax"]);
				$mysqli->close();

				return $fax;
			}
		}

		function getOfficeHours($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$officeHours = stripslashes($row["officeHours"]);
				$mysqli->close();

				return $officeHours;
			}
		}

		function getBiography($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$biography = stripslashes($row["biography"]);
				$mysqli->close();			

				return $biography;
			}
		}

		function getResearch($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$research = stripslashes($row["research"]);
				$mysqli->close();			

				return $research;
			}
		}

		function getPublications($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$publications = stripslashes($row["publications"]);
				$mysqli->close();			

				return $publications;
			}
		}

		function getPersonal($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$personal = stripslashes($row["personal"]);
				$mysqli->close();			

				return $personal;
			}
		}

		function getAwards($email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$awards = stripslashes($row["awards"]);
				$mysqli->close();			

				return $awards;
			}
		}

		function setImage($image,$email){
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email);

			$path = "assets/profPics/".$accountname.".jpg";

			move_uploaded_file($image, $path);

			$query = "UPDATE images SET image='$path' WHERE accountname='$accountname'";
			$result = $mysqli->query($query);
			$mysqli->close();	
		}

		function getImage($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email);

			$query = "SELECT * FROM users WHERE accountname='$accountname';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$image = stripslashes($row["image"]);
				$mysqli->close();			

				return $image;
			}
		}

		function checkCredentials($email, $pass){
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

		function storeRegistrationData($name,$email,$password){
			$mysqli = $this->connect();

			$id = md5($name.$email.$password);

			$query = "INSERT INTO registration SET name='$name', 
					  email='$email',
					  password='$password',
					  regid ='$id';";

			$mysqli->query($query);
			$mysqli->close();

			return $id;
		}

		function activateAccount($id) {
			$mysqli = $this->connect();

			$query = "SELECT * FROM registration WHERE regid='$id';";
			$result = $mysqli->query($query);


			if($result->num_rows == 0){
				$mysqli->close();
				return 0;
			} else {
				$row = $result->fetch_assoc();
				$name = stripslashes($row["name"]);
				$email = stripslashes($row["email"]);
				$password = stripslashes($row["password"]);
				
				$this->createUser($name,$email,$password,'0');

				$mysqli->close();

				return 1;
			}			
		}

		function storeEmail($email){
			$mysqli = $this->connect();

			$id = md5($email);

			$query = "INSERT INTO registration SET name='', 
					  email='$email',
					  password='',
					  regid ='$id';";

			$mysqli->query($query);
			$mysqli->close();

			return $id;
		}

		function resetPassword($id, $password) {
			$mysqli = $this->connect();

			// $query = "SELECT * FROM registration WHERE regid='$id';";
			$query = "SELECT * FROM registration WHERE regid='$id';";
			$result = $mysqli->query($query);


			if($result->num_rows == 0){
				$mysqli->close();
				return 0;
			} else {
				$row = $result->fetch_assoc();
				$name = stripslashes($row["name"]);
				$email = stripslashes($row["email"]);
				
				$this->createPassword($email,md5($password));

				$mysqli->close();

				return 1;
			}			
		}

		function getCourses($email) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM courses WHERE accountname='$accountname'";
			$result = $mysqli->query($query);

			$res = "";
			for($row = $result->fetch_assoc(); $row != FALSE; 
						$row = $result->fetch_assoc())
			{
				$course = stripslashes($row["course"]);
				$res .= $course.";";
			}
			$mysqli->close();
			return $res;
		}

		function getCourseDescription($email, $course) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM courses WHERE accountname='$accountname' AND course='$course';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$description= stripslashes($row["description"]);
				$mysqli->close();			

				return $description;
			}
		}

		function getCourseURL($email, $course) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM courses WHERE accountname='$accountname' AND course='$course';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$url= stripslashes($row["url"]);
				$mysqli->close();			

				return $url;
			}
		}

		function getCourseTitle($email, $course) {
			$mysqli = $this->connect();

			$accountname = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $email); 

			$query = "SELECT * FROM courses WHERE accountname='$accountname' AND course='$course';";
			$result = $mysqli->query($query);

			if($result->num_rows == 0){
				$mysqli->close();
				return "";
			} else {
				$row = $result->fetch_assoc();
				$title= stripslashes($row["title"]);
				$mysqli->close();			

				return $title;
			}
		}

		function getServer(){
			$file = "assets/info.txt";
			$fh = fopen($file, "r");

			$count = 0;
			$server = "";

		    while (($line = fgets($fh)) !== false) {
		       	if($count == 4) {
		       		$server = trim($line);
		       		break;
		       	}
		       	$count += 1;
		    }

		    return $server;
	    }

		function getSubfolder(){
			$file = "assets/info.txt";
			$fh = fopen($file, "r");

			$count = 0;
			$subfolder = "";

		    while (($line = fgets($fh)) !== false) {
		       	if($count == 5) {
		       		$subfolder = trim($line);
		       		break;
		       	}
		       	$count += 1;
		    }

		    return $subfolder;
	    }


	}


?>