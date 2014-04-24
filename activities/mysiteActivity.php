<?php

	/*	mysiteActivity.php
	 *
	 *	Author: Alex Defreitas	 
	 *	Date: 4/22/2014
	 * 
	 */


	 include 'emailPhoto.php';

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
		var $courseNames;
		var $courseTextArea;
		
		// Research View
		var $research;
		
		// Awards View
		var $awards;
		
		// Personal View
		var $personal;

		var $server;
		var $subfolder;
		
 
		// constructor
		function __construct() {
			$this->model = new Model();
			$this->server = $this->model->getServer();
	 		$this->subfolder = $this->model->getSubfolder();

			$this->page = new Page("My Site");
		
	 		session_start();
	 		if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] + 10*60 < time()) {					//[MSA.001]
	 			header("Location: $this->server/$this->subfolder/login.php");
		 	}

			$this->context = "User is logged in, site page is open";


			// Decide which page to show
	 		if (isset ($_GET['home'])) {									//[MSA.002]

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
			
				// default to homepage
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
				
				$this->username = preg_replace("#\@[\d\w\.-]*?\.\w{2,4}#i", "", $_SESSION["id"]);			//[MSA.003]
			
			}
			
		}
	
	
		// process
		function process() {
	
			if ($this->context == "User is logged in, site page is open") {
		
				// Decide which page to load
			
				if ($this->viewing == 'mysite_home') {
				
					// get homepage data	
					$this->name = $this->model->getName($_SESSION["id"]);							//[MSA.004]
 					$this->job_title = $this->model->getJobTitle($_SESSION["id"]);
					$this->address = $this->model->getAddress($_SESSION["id"]);
					$this->telephone = $this->model->getTelephone($_SESSION["id"]);
					$this->fax = $this->model->getFax($_SESSION["id"]);
					
					$this->photo = "emailPhoto.php";
		
					$this->email = $_SESSION["id"];
					$this->office_hours = $this->model->getOfficeHours($_SESSION["id"]);
					$this->biography = $this->model->getBiography($_SESSION["id"]);
					 

					// If no photo has been uploaded, default to this image
					if ($this->photo == "") {
					
						$this->photo = "assets/images/default_img.jpg";
					}

				
				} 
				
				elseif ($this->viewing == 'mysite_teaching') {
			
					// get teaching data
					
 					$allCourses = $this->model->getCourses($_SESSION["id"]);
 					$this->courseNames = explode(";", $allCourses);						//[MSA.005]

 					$this->numCourses = count($this->courseNames);						//[MSA.006]
			
 			
 					$count = 0;
 			
 					while ($count < $this->numCourses)									//[MSA.007]
 					{
 			
 						$url = $this->model->getCourseUrl($_SESSION["id"], $this->courseNames[$count]);
 						$course_name = $this->model->getCourseTitle($_SESSION["id"], $this->courseNames[$count]);
 						$description = $this->model->getCourseDescription($_SESSION["id"], $this->courseNames[$count]);
 				
 						$this->courseTextArea .= 
 							"<p>					
 								<a href='$url'>$course_name</a> $description
 							</p>";
					
 						$count++;
 			
 					}


						$this->courseTextArea = "Courses go here";
			
				}
				
				elseif ($this->viewing == 'mysite_research'){
					// get research data
				
					$this->research = $this->model->getResearch($_SESSION["id"]);
				
				}
				
				elseif ($this->viewing == 'mysite_awards'){
					// get awards data
				
					$this->awards = $this->model->getPublications($_SESSION["id"]);
				
				}
				
				elseif ($this->viewing == 'mysite_personal'){
					// get personal data
				
					$this->personal = $this->model->getPersonal($_SESSION["id"]);
				
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
					
					print "<h1>$this->name</h1>
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
		
		private function printNavigation() {												//[MSA.008]
		
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