<?php
	$usestub = false;

	if( $usestub ) {
		include_once "modelstub.php";
	} else {
		include_once "model/model.php";
	}

	class UninstallActivity {
		var $context;
		var $model;
		var $rootPass;
		var $dbName = "quartz";
		var $emptyFlag;

		function __construct(){
			$this->model = new Model();

			if (isset($_POST['submit'])) {
				if ($_POST['uninstall']!="")
				{
					$this->context = 'submitting';
					$this->emptyFlag = "";
				} else {
					$this->emptyFlag = "Error: Are you sure you want to uninstall Quartz?";
					$this->context = "showingform";

				}
			} else {
				$this->context = 'showingform';
				$this->emptyFlag = "";
			}
		}
		
		
		function getInput() {
		}

		function show() {
			if($this->context=="showingform"){
				print("<html>
					<head>
						<title>Uninstall Quartz</title>
						<link rel='stylesheet' type='text/css' href='assets/css/layout.css'>
						<link rel='stylesheet' type='text/css' href='assets/css/style.css'>
					</head>
					
					
					<div id='container'>
					<body>
						<div id='header'></div>
					
						<div class ='content'>
							<br><font color='FF0000'>$this->emptyFlag</font>
							<h1>Thanks for using Quartz!</h1>
							
								 Thank you for choosing the Quartz system to manage your professor and course information online. 
								  We're sad to see you go.  This page will walk you through uninstalling Quartz.<br><br>
								

							<u>Have you backed up your data?</u> If you plan on reinstalling Quartz, you can create a backup of your professors' data 
							in the Admin Panel and install from that backup later.  Please back up your data before uninstalling Quartz.  Once you uninstall,
							 you will not be able to access your data again.<br><br> <br><br>
							<u> Uninstalling will remove all professor data.</u>
							
							<br><br>

								<!--creating the uninstall form-->

							<form method='post' action= 'uninstall.php' >
								Are you sure you want to uninstall Quartz? <br>
								<input type='radio' name='uninstall' value='yes'>	Yes<br>
								<input type='radio' name='uninstall' value='no'>	No<br>
								<p><input type='submit' name='submit'/></p>
							</form>
						</div>

						<div id='footer'> </div>
					</body>
					</div>
				</html>");
			} else if ($this->context = "submitting") {
				if ($_POST['uninstall'] =='yes') {
				
				print("<html>
					<head>
						<title>Uninstall Quartz</title>
						<link rel='stylesheet' type='text/css' href='assets/css/layout.css'>
						<link rel='stylesheet' type='text/css' href='assets/css/style.css'>
					</head>
					
					<div id='container'>
					<body>
						<div id='header'></div>
						<div class='content'>
							<br>
							<center>The Quartz database has successfully been deleted!<br><br> You may now exit your browser. </center>
						</div>

						<div id='footer'> </div>
					</body>
					</div>
				</html>");
				
				} else {
				header("Location: admin.php");
				die();
				}		
			}
		}

		function process(){
			if($this->context=="submitting"){
			if ($_POST['uninstall'] =='yes') {
				//$model->deleteDatabase($this->dbname, "localhost://quartz");
				
				print("suCCess");
			
			}
			}
		}

		function run() {
			$this->show();
			$this->process();
			
		}
	}
?>
