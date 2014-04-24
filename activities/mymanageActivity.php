<?php

	/*	mymanageActivity.php
	 *
	 *	Author: 
	 *	Date:
	 * 
	 */

	 
	 class MyManageActivity {
	 
	 	// data members
	 	var $page;
	 	var $model;
		var $context;
		
		var $displayname;
		var $name;
		var $jobtitle;
		var $address;
		var $telephone;
		var $fax;
		var $officehours;
		var $biography;
		var $research;
		var $publications;
		var $personalinfo;
		
		var $course1title;
		var $course2title;
		
		var $server;
		var $subfolder;
	 
	 
	 	// constructor
	 	function __construct() {

	 		$this->model = new Model();
	 		$this->server = $this->model->getServer();
	 		$this->subfolder = $this->model->getSubfolder();

	 		session_start();

	 		if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] + 10*60 < time()) {
	 			header("Location: $this->server/$this->subfolder/login.php");
		 	}		

	 		$this->page = new Page("My Manage");
			
			$this->context = "showingform";
	 	}
	 
	 
	 	// run
		function run() {
			
			$this->process();
			$this->show();
			
		}
	 
	 
	 	// get input
	 	function getInput() {
			
	 	}
	 	
	 	
	 	// process
	 	function process() {
	 	
			if ($this->context == "saving")
			{
				$this->getInput();
			}
			else //context == "showingform"
			{
				
				$this->displayname = $_SESSION['id'];
				$this->name = $this->model->getName($this->displayname);
				$this->jobtitle = $this->model->getJobtitle($this->displayname);
				$this->address = $this->model->getAddress($this->displayname);
				$this->telephone = $this->model->getTelephone($this->displayname);
				$this->fax = $this->model->getFax($this->displayname);
				$this->officehours = $this->model->getOfficehours($this->displayname);
				$this->biography =   $this->model->getBiography($this->displayname);
				$this->research = $this->model->getResearch($this->displayname);
				$this->publications = $this->model->getPublications($this->displayname);
				$this->personalinfo = $this->model->getPersonal($this->displayname);
				$this->photo = $this->model->getImage($this->displayname);
			}
		
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
	 		if ($this->context == "showingform")
			{
			echo "
				<div id='mymanage'>
				<h1 class='page_title' id='welcome_title'>Welcome, $this->name</h1>
				<p>This is your Website Management Portal.<br /> Here you can edit course content and your site's information.</p>
				<form id='mymanageform'>
							<div class='module website_settings'>
							
								<h2 class='mod_title clear'>Website Settings</h2>
							
								<!-- check the correct way to write radio button links-->

								<input type='radio' name='status' value='online' id='website_on'/>
								<label for='online'>Online</label>
								<br />
								<input type='radio' name='status' value='offline' id='website_off'/>
								<label for='offline'>Offline</label>

							
							
							</div> <!--/module-->
							
							<div class='module photo'>
							
								<h2 class='mod_title clear'>Photo</h2>
							
								<!-- use model code to get the user's photo (or a backup photo when they don't have one uploaded) -->
								<img src='$this->photo' id='profile_pic'/>
								<h6>Upload a new photo</h6>
							

							<form action='assets/upload.php' method='POST' enctype='multipart/form-data'>
							<input type='file' name='photo' id='myImage'>
							<input type='submit' name='submit' value='Submit'>
							</form>
						
							</div> <!--/module-->
						
							<div class='module general_info'>
							
								<h2 class='mod_title'>General Information</h2> <button class='link_lookalike'>edit</button>
							
								<!-- use model code to populate this table -->
								<table class='no_background' id='gen_info'>
									<tr>
										<td class='label'>Display Name:</td>
										<td><input type='text' value='$this->name' id='geninfo_displayname' class='name' /></td>
									</tr>			
									<tr>
										<td class='label'>Job Title:</td>
										<td><input type='text' value='$this->jobtitle' id='geninfo_jobtitle' class='name' /></td>
									</tr>			
									<tr>
										<td class='label'>Address:</td>
										<td><input type='text' value='$this->address' id='geninfo_address' class='name' /></td>
									</tr>			
									<tr>
										<td class='label'>Telephone:</td>
										<td><input type='text' value='$this->telephone' id='geninfo_telephone' class='name' /></td>
									</tr>			
									<tr>
										<td class='label'>Fax:</td>
										<td><input type='text' value='$this->fax' id='geninfo_fax' class='name' /></td>
									</tr>			
									<tr>
										<td class='label'>Office Hours:</td>
										<td><input type='text' value='$this->officehours' id='geninfo_officehours' class='name' /></td>
									</tr>			
									<tr>
										<td class='label' colspan='2'>Biography:</td>
										<td></td>
									<tr>
									<tr>
										<td colspan='2'><input type='text' value='$this->biography' id='geninfo_biography' class='name' /></td>
										<td></td>
									<tr>
								</table>
						
							</div> <!--/module-->
						
							<div class='module courses' id='totalCoursesDiv'>
							
								<h2 class='mod_title'>Courses</h2> <button type='button' class='link_lookalike' onclick='showCourseEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<div class='course' id='finalCourse1'>
									<div class='label inline'>CS112 Introduction to Computer Science II</div>
									<div class='url inline right'><a href='http://thiscoursesite.com' target='_blank'>http://thiscoursesite.com</a></div>
									<div class='description'>An introduction to algorithms, data structures, and programming techniques</div>
								</div>
						
								<div class='course' id='finalCourse2'>
									<div class='label inline'>CS411 Software Engineering</div>
									<div class='url inline right'><a href='http://thiscoursesite.com' target='_blank'>http://thiscoursesite.com</a></div>
									<div class='description'>An introduction to the fundamentals of software engineering</div>
								</div>
								
								<div class='course' id='finalCourse3' style='display:none'>
									<div class='label inline'>CS411 Software Engineering</div>
									<div class='url inline right'><a href='http://thiscoursesite.com' target='_blank'>http://thiscoursesite.com</a></div>
									<div class='description'>An introduction to the fundamentals of software engineering</div>
								</div>
								
								<!-- model code will generate these divs -->

								<div class='course' id='course1' style='display:none'>
									<br>
									<label for='course_name' class='label'>Course Name</label>
									<input type='text' value='CS112 Introduction to Computer Science II' name='course_name' class='name' /><br />
									<label for='course_site' class='label'>Course Website URL</label>
									<input type='text' value='http://thiscoursesite.com' name='course_name' class='url' /><br />
									<label for='course_description' class='description label'>Course Description</label><br />						
									<textarea rows='5' cols='115' name='course_description' class='description'>An introduction to algorithms, data structures, and programming techniques</textarea>
								</div>
					
								<div class='course' id='course2' style='display:none'>
									<label for='course_name' class='label'>Course Name</label>						
									<input type='text' class='name' value='CS411 Software Engineering' name='course_name'/><br />
									<label for='course_site' class='label'>Course Website URL</label>							
									<input type='text' class='url' value='http://thiscoursesite.com' name='course_site' /><br />
									<label for='course_description' class='description label' >Course Description</label><br />							
									<textarea rows='5'  cols='115' name='course_description' class='description'> An introduction to the fundamentals of software engineering</textarea>
								</div>
								
								<div class='course' id='course3' style='display:none'>
									<label for='course_name' class='label'>Course Name</label>						
									<input type='text' class='name' value='CS411 Software Engineering' name='course_name'/><br />
									<label for='course_site' class='label'>Course Website URL</label>							
									<input type='text' class='url' value='http://thiscoursesite.com' name='course_site' /><br />
									<label for='course_description' class='description label' >Course Description</label><br />							
									<textarea rows='5'  cols='115' name='course_description' class='description'> An introduction to the fundamentals of software engineering</textarea>
								</div>
								
								<!--button type='button' onclick='addCourse()' id='add_course''>Add Course</button-->
						
							</div> <!--/module-->
					
							<div class='module research'>
							
								<h2 class='mod_title'>Research</h2> <button type='button' class='link_lookalike' onclick='showResearchEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<p id='finalResearch'>$this->research</p>
								

								<textarea rows='5' cols='115' id='research' style='display:none'>$this->research</textarea>

						
							</div> <!--/module-->
						
							<div class='module publications'>
							
								<h2 class='mod_title'>Awards</h2> <button type='button' class='link_lookalike' onclick='showPublicationsEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<p id='finalPublications'>$this->publications</p>
								

								<textarea rows='5' cols='115' id='publications' style='display:none'>$this->publications</textarea>

						
							</div> <!--/module-->
						
							<div class='module personal_information'>
							
								<h2 class='mod_title'>Personal Information</h2> 
								<button type='button' class='link_lookalike' onclick='showPersonalInfoEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<p id='finalPersonalInfo'>$this->personalinfo</p>
								

								<textarea rows='5' cols='115' id='personal_info' style='display:none'>$this->personalinfo</textarea>

						
							</div> <!--/module-->
							
							<button type='button' onclick='saveChanges()' class='MM_redbtn'>Save All Changes</button>
							<button class='MM_greybtn'>Leave Without Saving</button>
							
							</form>
							</div>
			<script>			

			function showResearchEdit()
			{
				document.getElementById('research').style.display='inline';
			}
			
			function showPublicationsEdit()
			{
				document.getElementById('publications').style.display='inline';
			}
			
			function showPersonalInfoEdit()
			{
				document.getElementById('personal_info').style.display='inline';
			}
			
			function showCourseEdit()
			{
				document.getElementById('finalCourse1').style.display = 'none';
				document.getElementById('finalCourse2').style.display = 'none';
				document.getElementById('course1').style.display = 'inline';
				document.getElementById('course2').style.display = 'inline';
			}
			
			function saveChanges()
			{
				//[MMA.000]
				var research = document.getElementById('research').value;
				var publications = document.getElementById('publications').value;
				var personal = document.getElementById('personal_info').value;
				
				document.getElementById('finalResearch').innerHTML=research;
				document.getElementById('finalPublications').innerHTML=publications;
				document.getElementById('finalPersonalInfo').innerHTML=personal;
				
				//SEND TO MODEL
				var sender = 'user=' + '$this->name' + '&&research=' + research + '&&publications=' + publications + '&&personal=' + personal;
				
				var jobtitle = '&&jobtitle=' + document.getElementById('geninfo_jobtitle').value;
				var address = '&&address=' + document.getElementById('geninfo_address').value;
				var telephone = '&&telephone=' + document.getElementById('geninfo_telephone').value;
				var fax = '&&fax=' + document.getElementById('geninfo_fax').value;
				var officehours = '&&officehours=' + document.getElementById('geninfo_officehours').value;
				var biography = '&&biography=' + document.getElementById('geninfo_biography').value;
				var name = '&&name=' + document.getElementById('geninfo_displayname').value;
				
				var geninfo = name + jobtitle + address + telephone + fax + officehours + biography;
				
				sender = sender + geninfo;
				
				//[MMA.000]
				var xmlhttp;

				if (window.XMLHttpRequest)
				{
					xmlhttp=new XMLHttpRequest();
					
				}

				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						document.getElementById('welcome_title').innerHTML=xmlhttp.responseText;
					}
				}

				xmlhttp.open('POST','$this->server/$this->subfolder/activities/mymanageAJAXHelper.php',true);
				xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
				xmlhttp.send(sender);
				
				//HIDE EDITORS
				document.getElementById('research').style.display='none';
				document.getElementById('publications').style.display='none';
				document.getElementById('personal_info').style.display='none';
				
				document.getElementById('course1').style.display='none';
				document.getElementById('course2').style.display='none';
				document.getElementById('finalCourse1').style.display='block';
				document.getElementById('finalCourse2').style.display='block';
				
			}
			
			
			</script> ";
			}
			else //context == "saving"
			{
			
			}
	 		
	 		$this->page->endDoc();
	 		
	 	
	 	}
	 
	 
	 }


?>