<?php

	/*	installActivity.php
	 *
	 *	Author: Erik Geil
	 *	Date: 4/23/14
	 * 
	 */

	include_once 'model/model.php';

	class InstallActivity {
		var $page;
		var $context;
		var $model;
		var $serverName;
		var $rootPass;
		var $adminName;
		var $adminPass;
		var $url;
		var $subfolder;
		var $emails;
		var $emptyFlag;

		function getInput() {
			if ($this->context == "submitting") {
				$this->serverName = $_POST['serverurl'];
				$this->rootPass = $_POST['rootpass'];
				$this->adminName = $_POST['admin'];
				$this->adminPass = $_POST['adminpass'];
				$this->url = $_POST['serverhost'];
				$this->subfolder = $_POST['rootpath'];
				$this->emails = $_POST['emails'];
			}
		}

		function show() {
			if($this->context=="showingform"){
				$this->page->beginDoc();

				print("
						<br><center><font color='FF0000'>$this->emptyFlag</font></center>
						<h1><center>Welcome to Quartz!</center></h1>
						<p style:'margin-left: auto; margin-right: auto;'>
							 <center>Thank you for choosing the Quartz system to manage your professor and course information online. 
							 This page will instruct you on the Quartz installation process. The form below takes in all the
							 information your system will need to provide a smooth installation of Quartz.<br><br>
							</center>


							 Here we will provide a brief explination of what each field is asking for so that 
							 your set up is as easy as possible:<br><br>


						<u>MySQL Server Name:</u> The servername that Quartz databases will be kept on. If you are running on WAMP/MAMP/LAMP 
						this will be localhost.<br><br>
						<u>MySQL Root User Password:</u> The password to the server. If your server password is different from the default, 
						enter your password. If your password is the default password enter 0.
						If you are unsure of the password, contact your server adminstrator.<br><br>
						<u>Quartz Admin Name:</u> The username of the Quartz admin. If you are the admin, please input your desired admin name. 
						This should be the same as the name portion of your BU email. (EX: If your email is 'john@bu.edu' the username 
						should be 'john') If you are a professor installing Quartz, please contact your administrator for this information.
						<br><br>
						<u>Quartz Admin Password:</u> The password of the Quartz admin. If you are the admin, please input your desired 
						password. If you are a professor installing Quartz, please contact your administrator for this information.<br><br>
						<u>URL of your Webserver:</u> This requires the URL of the webserver on which Quartz runs. In the case you are 
						running on WAMP/MAMP/LAMP and you Apache server runs on a different port than the default, write the server URL 
						with the name of the different port number. (EX: If your server URL is http://localhost/ and it must run on 
						port 81, write http://localhost:81/). If you are unsure of this information, contact your Quartz administrator.<br><br> 
						<u>Name of Quartz's subfolder:</u> The subfolder where Quartz can be found.(EX: Quartz2012).
						If you are unsure of this information ask your Quartz administrator.<br><br>
						<u>Approved Emails:</u> A list of emails approved for the use of Quartz.  Include the full address for the email and
						separate emails with ';'.<br><br>

						<u>Does your server have the ability to send mail?</u> Field asks if your server has the capability to send an email 
						directly. If you have LAMP/MAMP/WAMP select no. If you are unsure of this, ask your Quartz administrator. <br><br>

						Please do not leave any field blank, the form is not prepared to handle that situation and will give an error. 
						In the case of that situation, or any such issue, simply come back to this page and fill out this form again.<br><br>
				
						If for some reason you must re-fill the form, you must fill out the entire form again, not just the part you wish
						 to change.<br><br>

						If you are an admin, you are able to use Quartz right after the installation. Simply use your BU email and 
						the password you provided.<br><br>
						If you are a professor, you still have to apply for a new account to use Quartz after the installation process. 
						There will be more instructions after the form as been submitted correctly.<br><br>
							<!--creating the form below that takes in user info-->

						<form method='post' action= 'install.php' >
							MySQL Server Name: <input type= 'text' name = 'serverurl'><br>
							<br>
							MySQL Root User Password: <input type='text' name = 'rootpass'><br>
							<br>
							Quartz Admin Name: <input type = 'text' name = 'admin'><br>
							<br>
							Quartz Admin Password: <input type = 'text' name = 'adminpass'><br>
							<br>
							URL Of your Webserver: <input type= 'text' name = 'serverhost'><br>
							<br>
							Name of Quartz's subfolder: <input type='text' name='rootpath'><br>
							<br>
							Approved Emails: <input type='text' name='emails'><br>
							<br>
							Does your server have the ability to send mail?: <br>
							<input type='radio' name='canmail' value='yes'>	Yes<br>
							<input type='radio' name='canmail' value='no'>	No<br>

							<p><input type='submit' name='submit'/></p>
						</form>
						</p>");

				$this->page->endDoc();
			} else if ($this->context = "submitting") {
				
				$this->page->beginDoc();

				print("
						<br>
						<center>Quartz is all set up!<br><br> If you are an admin, you are ready to begin using Quartz.
						Simply follow the link below to the login page and log in.<br><br>
						If you are a professor, follow the link below to the Quartz login page. 
						On that page, there is an option to create a new account.
						Choose that option and follow the instructions provided.<br><br>

						<a href='login.php'>Go to Quartz now!</a>
						</center>");

				$this->page->endDoc();				
			}
		}

		function process(){
			if($this->context=="submitting"){
				$this->model->createDatabase($this->serverName,$this->rootPass,$this->adminName,$this->adminPass, $this->emails);

				$file = "assets/info.txt";
				$fh = fopen($file, 'w');
				fwrite($fh,$this->serverName."\r\n");
				fwrite($fh,$this->rootPass."\r\n");
				fwrite($fh,$this->adminName."\r\n");
				fwrite($fh,$this->adminPass."\r\n");
				fwrite($fh,$this->url."\r\n");
				fwrite($fh,$this->subfolder."\r\n");
				fclose($fh);
			}
		}

		function run() {
			$this->getInput();
			$this->process();
			$this->show();
		}

		function __construct(){
			$this->model = new Model();
			$this->page = new Page("Welcome to Quartz");

			if (isset($_POST['submit'])) {
				if ($_POST['serverurl']!="" && $_POST['rootpass']!="" && $_POST['admin']!="" && $_POST['adminpass']!=""
					&& $_POST['serverhost']!="" && $_POST['rootpath']!="")
				{
					$this->context = 'submitting';
					$this->emptyFlag = "";
				} else {
					$this->emptyFlag = "Error: All fields are required";
					$this->context = "showingform";

				}
			} else {
				$this->context = 'showingform';
				$this->emptyFlag = "";
			}
		}
	}

?>