<?php

	include_once "model/model.php";

	class UninstallActivity {
		var $page;
		var $context;
		var $model;
		var $rootPass;
		var $emptyFlag;

		function __construct(){
			$this->model = new Model();
			$this->page = new Page("Uninstall Quartz");

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
			// $file = "assets/info.txt";
			// if(file_exists($file)){
			// 	$fh = fopen($file, 'r');

			// 	$string = fgets($fh);
			// 	$string = str_replace("\n", "", $string);
			// 	$string = str_replace("\r", "", $string);

			// 	$this->dbName = $string;

			// 	fclose($fh);
			// }
		}

		function show() {
			if($this->context=="showingform"){

				$this->page->beginDoc();

				print("
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
							</form>");
				$this->page->endDoc();
			} else if ($this->context = "submitting") {
				if ($_POST['uninstall'] =='yes') {
				
					$this->page->beginDoc();
					print("
								<br>
								<center>The Quartz database has successfully been deleted!<br><br>
								 You may now exit your browser. </center>");

					$this->page->endDoc();
				
				} else {
				header("Location: admin.php");
				die();
				}		
			}
		}

		function process(){
			if($this->context=="submitting"){
			if ($_POST['uninstall'] =='yes') {
				$this->model->deleteDatabase();

				if(file_exists("assets/info.txt")){
					unlink("assets/info.txt");			
				}
			}
			}
		}

		function run() {
			$this->getInput();
			$this->process();
			$this->show();
		}
	}
?>
