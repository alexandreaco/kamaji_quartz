<?php

	/*	mysiteActivity.php
	 *
	 *	Author: Alex Defreitas	 
	 *	Date: 4/22/2014
	 * 
	 */

 
	 class MySiteActivity {
 
		// data members
		var $page;
		var $model;
		var $context;
		var $viewing;
		
		// Homepage View
		var $username;
		var $name;
		var $job_title;
		var $address;
		var $telephone;
		var $fax;
		var $email;
		var $office_hours;
		var $biography;
		var $photo;
		
		// Teaching View
		var $numCourses;
		var $courseTextArea;
		
		// Research View
		var $research;
		
		// Awards View
		var $awards;
		
		// Personal View
		var $personal;
		
 
		// constructor
		function __construct() {
	 		session_start();

	 		if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] + 10 < time()) {
	 			header('Location: http://localhost/kamaji_quartz/login.php');
		 	}

			$this->model = new Model();
		
			$this->page = new Page("My Site");
		
			$this->context = "User is logged in, site page is open";
		
// Decide which page to show
	 		if (isset ($_GET['home'])) {

				$this->viewing = 'mysite_home';
				
			} elseif (isset ($_GET['teaching'])) {
			
				$this->viewing = 'mysite_teaching';
			
			} elseif (isset ($_GET['research'])) {
				
				$this->viewing = 'mysite_research';
			
			} elseif (isset ($_GET['awards'])) {
			
				$this->viewing = 'mysite_awards';
			
			} elseif (isset ($_GET['personal'])) {
			
				$this->viewing = 'mysite_personal';
			
			} else {
			
				// default to homepage in this demo
				$this->viewing = 'mysite_home';
				
			}
		
		
		}
 
 
		// run
		function run() {
			$this->getInput();
			$this->process();
			$this->show();
		
		}
 
 
		// get input
		function getInput() {
			if($this->context = "User is logged in, site page is open") {
				$this->username = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $_SESSION["id"]);
			}
		}
	
	
		// process
		function process() {
	
			if ($this->context == "User is logged in, site page is open") {
		
				// Decide which page to load
			
				if ($this->viewing == 'mysite_home') {
				
					// get homepage data	
					$this->name = $this->model->		
 					$this->job_title = $this->model->getJobTitle($this->username);
					$this->address = $this->model->getAddress($this->username);
					$this->telephone = $this->model->getTelephone($this->username);
					$this->fax = $this->model->getFax($this->username);
					$this->email = $this->model->getEmail($this->username);
					$this->office_hours = $this->model->getOfficeHours($this->username);
					$this->biography = $this->model->getBiography($this->username);
					// $this->photo = $this->model->getPhoto(); // return a link to the photo

					// $this->username = "Username";
					// $this->job_title = "Job Title";
					// $this->address = "Address";
					// $this->telephone = "Telephone";
					// $this->fax = "Fax";
					// $this->email = "Email";
					// $this->office_hours = "Office Hours";
					// $this->biography = "Biography";
					$this->photo = "Photo"; // return a link to the photo


				
				} 
				elseif ($this->viewing == 'mysite_teaching') {
			
					// get teaching data
			
					// $this->numCourses = $this->model->getNumCourses();
// 			
// 					$i = 0;
// 			
// 					while ($i < $this->numCourses)
// 					{
// 			
// 						$url = $this->model->getCourseUrl($i);
// 						$course_name = $this->model->getCourseName($i);
// 						$description = $this->model->getCourseDescription($i);
// 				
// 						$this->courseTextArea = $this->courseTextArea . 
// 							"<p>					
// 								<a href='$url'>$course_name</a> - $description
// 							</p>";
// 					
// 						++$i;
// 				
// 					}
// 			
// 					$i = 1;
// 			
// 					while ($i < $this->numCourses)
// 					{
// 			
// 						$url = $this->model->getCourseUrl($i);
// 						$course_name = $this->model->getCourseName($i);
// 						$description = $this->model->getCourseDescription($i);
// 				
// 						$this->courseTextArea = $this->courseTextArea . 
// 							"<p>					
// 								<a href='$url'>$course_name</a> - $description
// 							</p>";
// 					
// 						++$i;
// 				
// 					}

						$this->courseTextArea = "Courses go here";
			
				}
				
				elseif ($this->viewing == 'mysite_research'){
					// get research data
				
// 					$this->research = $this->model->getResearch();
					$this->research = "research goes here";
				
				}
				elseif ($this->viewing == 'mysite_awards'){
					// get awards data
				
// 					$this->awards = $this->model->getAwards();
					$this->awards = "awards go here";
				
				}
				elseif ($this->viewing == 'mysite_personal'){
					// get personal data
				
// 					$this->personal = $this->model->getPersonal();
					$this->personal = "personal goes here";
				
				}
		
			} else {
				
				print ("incorrect context");
		
			}
	
		}
	
	
		// show
		function show() {
	
			$this->page->beginDoc();
			
			$this->printNavigation();
			
			print("<div id='view'>");
		
			// enter code here
		
			if ($this->context == "User is logged in, site page is open") {
		
				// Decide which page to load
			
				if ($this->viewing == 'mysite_home') {
				
					// get homepage data
					
					print "<h1>$this->username</h1>
								<em>$this->job_title</em> 
								<hr />
								<img src='$this->photo' alt='$this->username' id='photograph'>
								<h3>Contact Information:</h3>
								<br />
								$this->address <br />
								$this->telephone &nbsp;,&nbsp;$this->fax <br />
								<img src='$this->email' /> 
								<br />
								<h3>Office Hours:</h3>
								$this->office_hours <br />
				
								<h3>Short Biography</h3>
								$this->biography <br />
					
				";
			
				
				} 
				
				elseif ($this->viewing == 'mysite_teaching') {
			
					// get teaching data
					
					print "<h1>Course List</h1>
						<p>$this->courseTextArea</p>";
			
			
				}
				
				elseif ($this->viewing == 'mysite_research'){
					// get research data
					
					print "<h1>Research:</h1>
						<p>$this->research</p>";
				
				}
				elseif ($this->viewing == 'mysite_awards'){
					// get awards data
					
					print "<h1>Awards:</h1>
						<p>$this->awards</p>";
				
				}
				elseif ($this->viewing == 'mysite_personal'){
					// get personal data
					
					print "<h1>Personal:</h1>
						<p>$this->personal</p>";
				
				}
		
			} else {
				
				print ("incorrect context");
		
			}
			
			
			print("</div> <!-- /view -->");
			$this->page->endDoc();
		
	
		}
		
		private function printNavigation() {
		
			print("<div id='navigation'>
								<ul>
									<li><a href='mysite.php?home'>Home</a></li>
									<li><a href='mysite.php?teaching'>Teaching</a></li>
									<li><a href='mysite.php?research'>Research</a></li>
									<li><a href='mysite.php?awards'>Awards</a></li>
									<li><a href='mysite.php?personal'>Personal</a></li>
								</ul>
							</div>");
		}
 
 
	 }


?>