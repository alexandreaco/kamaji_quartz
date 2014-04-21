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
	 
	 
	 	// constructor
	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		
	 		$this->page = new Page("My Manage");
	 		
	 		
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
	 	
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();

				echo "<head>
					
					<script>
					
					function bodyLoad()
					{ ";
						$displayname = $model->getDisplayname();
						$jobtitle = $model->getJobtitle();
						$address = $model->getAddress();
						$telephone = $model->getTelephone();
						$fax = $model->getFax();
						$officehours = $model->getOfficehours();
						$biography =   $model->getBiography();
						$research = $model->getResearch();
						$publications = $model->getPublications();
						$personalinfo = $model->getPersonalInfo();
						
						echo "
							document.getElementById('welcome_title').innerHTML='Welcome, $displayname';";
							
						$websiteOn = false; //MODELSTUB
						if ($websiteOn)
						{
							echo "document.getElementById('website_on').checked=true;";
						}
						else
						{
							echo "document.getElementById('website_off').checked=true;";
						}
						
						//echo 'document.getElementById("profile_pic").src="Keklak.jpg"';
						
						echo "var generalInfoTable = document.getElementById('gen_info');";
						echo "generalInfoTable.rows[0].cells[1].innerHTML='$displayname';";
						echo "generalInfoTable.rows[1].cells[1].innerHTML='$jobtitle';";
						echo "generalInfoTable.rows[2].cells[1].innerHTML='$address';";
						echo "generalInfoTable.rows[3].cells[1].innerHTML='$telephone';";
						echo "generalInfoTable.rows[4].cells[1].innerHTML='$fax';";
						echo "generalInfoTable.rows[5].cells[1].innerHTML='$officehours';";
						echo "generalInfoTable.rows[8].innerHTML='$biography';";
						//KNOWN BUG: Can't make the Bio more than one line of text
						
						echo "document.getElementById('finalResearch').innerHTML='$research';";
						echo "document.getElementById('finalPublications').innerHTML='$publications';";
						echo "document.getElementById('finalPersonalInfo').innerHTML='$personalinfo';";
						
						echo "
					}
					
					function showCourseEdit()
					{
						document.getElementById('course1').style.display='inline';
						document.getElementById('course2').style.display='inline';
						document.getElementById('finalCourse1').style.display='none';
						document.getElementById('finalCourse2').style.display='none';
						
						var course3display = document.getElementById('course3').style.display;
						if (course3='none')
						{
						}
						else
						{
							document.getElementById('course3').style.display='inline';
							document.getElementById('finalCourse3').style.display='none';
						}
					}
					
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
					
					function addCourse()
					{
						document.getElementById('finalCourse3').style.display='block';
					}
					
					function saveChanges()
					{
						
						var research = document.getElementById('research').value;
						var publications = document.getElementById('publications').value;
						var personal = document.getElementById('personal_info').value;
						
						//SEND TO MODEL
						document.getElementById('finalResearch').innerHTML=research;
						document.getElementById('finalPublications').innerHTML=publications;
						document.getElementById('finalPersonalInfo').innerHTML=personal;
						
						//HIDE EDITORS
						document.getElementById('research').style.display='none'
						document.getElementById('publications').style.display='none'
						document.getElementById('personal_info').style.display='none'
						
						document.getElementById('course1').style.display='none';
						document.getElementById('course2').style.display='none';
						document.getElementById('finalCourse1').style.display='block';
						document.getElementById('finalCourse2').style.display='block';
						
					}
					
					</script>
				
				</head>";
	 		
			
			echo "<div id='content'>
		
				<!-- use php to generate user name in this h1 tag-->		
				
				<h1 class='page_title' id='welcome_title'>Welcome, Default User</h1>
				<p>This is your Website Management Portal.<br /> Here you can edit course content and your site's information.</p>";
				
			echo "<form onload='bodyLoad()'>
						
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
								<img src='Keklak.jpg' id='profile_pic' />
								<h6>Upload a new photo</h6>
							

							<form action='upload_file.php' method='post'
							enctype='multipart/form-data'>
							<input type='file' name='file' id='file'><br>
							<input type='submit' name='submit' value='Submit'>
							</form>
						
							</div> <!--/module-->
						
							<div class='module general_info'>
							
								<h2 class='mod_title'>General Information</h2> <button class='link_lookalike'>edit</button>
							
								<!-- use model code to populate this table -->
								<table class='no_background' id='gen_info'>
									<tr>
										<td class='label'>Display Name:</td>
										<td></td>
									</tr>			
									<tr>
										<td class='label'>Job Title:</td>
										<td></td>
									</tr>			
									<tr>
										<td class='label'>Address:</td>
										<td></td>
									</tr>			
									<tr>
										<td class='label'>Telephone:</td>
										<td></td>
									</tr>			
									<tr>
										<td class='label'>Fax:</td>
										<td></td>
									</tr>			
									<tr>
										<td class='label'>Office Hours:</td>
										<td></td>
									</tr>			
									<tr>
										<td class='label' colspan='2'>Biography:</td>
										<td></td>
									<tr>
									<tr>
										<td colspan='2'></td>
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
								
								<button type='button' onclick='addCourse()' id='add_course''>Add Course</button>
						
							</div> <!--/module-->
					
							<div class='module research'>
							
								<h2 class='mod_title'>Research</h2> <button type='button' class='link_lookalike' onclick='showResearchEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<p id='finalResearch'>research information will go here</p>
								

								<textarea rows='5' cols='115' id='research' style='display:none'>research information will go here</textarea>

						
							</div> <!--/module-->
						
							<div class='module publications'>
							
								<h2 class='mod_title'>Publications</h2> <button type='button' class='link_lookalike' onclick='showPublicationsEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<p id='finalPublications'>publications information will go here</p>
								

								<textarea rows='5' cols='115' id='publications' style='display:none'>publications will go here</textarea>

						
							</div> <!--/module-->
						
							<div class='module personal_information'>
							
								<h2 class='mod_title'>Personal Information</h2> 
								<button type='button' class='link_lookalike' onclick='showPersonalInfoEdit()'>edit</button>
							
								<!-- model code will generate these divs -->
								<p id='finalPersonalInfo'>personal information will go here</p>
								

								<textarea rows='5' cols='115' id='personal_info' style='display:none'>personal information will go here</textarea>

						
							</div> <!--/module-->
							
							<button type='button' onclick='saveChanges()'>Save All Changes</button>
							<button>Leave Without Saving</button>
							
							</form>";
							
							
			echo    "</div> <!-- content -->";
			
	 		
	 		$this->page->endDoc();
	 		
	 	
	 	}
	 
	 
	 }


?>