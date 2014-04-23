<?php
 
 include_once "model/model.php";
 
	 class RegistrationActivity {
	 	var $context;
	 	var $page;
	 	var $model;
	 	var $name;
	 	var $email;
	 	var $password1;
	 	var $password2;
	 	var $id;
		var $emptyFlag;
	 

	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		$this->page = new Page("Register");

	 		if(isset($_GET['activate'])) {
	 			$this->context = "activating";
	 		} else {
		 		if(isset($_POST['submit'])) {
		 			if($_POST['givenName']!="" && $_POST['givenEmail']!="" && $_POST['givenPassword']!="" && $_POST['givenPassword2']!=""){
		 				$this->context = "submitting";
		 				$this->emptyFlag = "";
		 			} else {
		 				$this->context = "showingform";
		 				$this->emptyFlag = "Error: All fields required.";
		 			}
		 		} else {
		 			$this->context = "showingform";
		 			$this->emptyFlag = "";
		 		}
			}
	 	}
	 
	 
		function run() {
			$this->getInput();	
			$this->process();
			$this->show();
			
		}
	 
	 
	 	function getInput() {
	 		if($this->context == 'submitting'){
	 			$this->name = $_POST["givenName"];
	 			$this->email = $_POST["givenEmail"];
	 			$this->password1 = $_POST["givenPassword"];
	 			$this->password2 = $_POST["givenPassword2"];
	 		} else if($this->context == "activating") {
	 			$this->id = $_GET['id'];
	 		}
	 	}
	 	
	 	
	 	
	 	function process() {
	 		if($this->context == "submitting") {
				$validEmail = $this->model->checkEmail($_POST["givenEmail"]);

				if($validEmail){
					if($this->password1==$this->password2){
						$this->id = $this->model->storeRegistrationData($this->name,$this->email,$this->password1);												
						$this->generateConfirmationEmail($this->id);

					} else {
						$this->emptyFlag = "Error: Passwords do not Match.";
					}
				} else {
					$this->emptyFlag = "Error: Please Enter Valid Email.";
				}
			} else if($this->context == "activating"){

				$isValid = $this->model->activateAccount($this->id);

				if($isValid == 1) {
				} else if($isValid == 0){
				  print("FAILED.");
				} else {
					print("SUPER FAILLLLLED");
				}
			}
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
	 		if($this->context == "showingform") {
				if($this->emptyFlag != "") {
				print("
				<div id='error'>
				$this->emptyFlag
				</div>
				");
				}
				
				print("
				<div id='reg'>
				<br> <br>
				<form name='input' action='register.php' method='post'>
				  Name: <input type='text' name='givenName'>
				  <br>
				  <br>
				  Email: <input type='text' name='givenEmail'> 
				  <br>
				  <br>
	 			  Password: <input type='password' name='givenPassword'>
				  <br>
				  <br>
				  Retype Password: <input type='password' name='givenPassword2'>
				  <br>
				  <br>
				<input type='submit' name='submit' value='Submit'>
				</form>
				</div>
		 		");
			}  else if ($this->context == "submitting") {
				print("Thank you for registering for Quartz.  An email has been sent with the link to 
						complete the registration process");
			}	else if ($this->context == "activating") {
				print("Congratulations Dude!!! You have succesfully registered for Quartz.  
						<a href='Location: 'http://localhost/kamaji_quartz/login.php'>Click Here</a> to log in.");
			} 		
	 		$this->page->endDoc();
	 	}
		
		
		function generateConfirmationEmail($id){
			$to = $_POST["givenEmail"];
    		$subject = "Quartz Registration Information";
    		$message = "Please click ";
    		$message .= "<a href='http://localhost:8888/kamaji_quartz/register.php?activate=1&id=$id'>here</a>";
    		$message .= " to login.";
    		$header = "From: webmaster@quartz.com";
    		$header .= 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    		
    		mail($to,$subject,$message, $header);
		
			print(
			"
			<div id='confirmationEmail'>
			A confirmation email has been sent to your email address.  Please exit this page.
			</div>
			");
		}
	 }
?>
