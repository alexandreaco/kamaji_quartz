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
		var $emptyFlag;
	 

	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		$this->page = new Page("Register");

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
	 		}
	 	}
	 	
	 	
	 	
	 	function process() {
	 		if($this->context == "submitting") {
				$validEmail = $this->model->checkEmail($_POST["givenEmail"]);

				if($validEmail){
					if($this->password1==$this->password2){
						$this->model->createUser($_POST["givenName"],
												 $_POST["givenEmail"],
												 $_POST["givenPassword"]);
												
						$this->generateConfirmationEmail();
					} else {
						$this->error = "Error: Passwords do not Match.";
					}
				} else {
					$this->error = "Error: Please Enter Valid Email.";
				}
			}
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
	 		
			if($this->emptyFlag != "") {
			print("
			<div id='error'>
			$this->emptyFlag
			</div>
			");
			}
			
			
			print("
			<div id='reg'>
			<h2>Create Account</h2>
			<form name='input' action='register.php' method='post'>
			  <label>Name: </label><input type='text' name='givenName'>
			  <br>
			  <label>Email: </label><input type='text' name='givenEmail'> 
			  <br>
 			  <label>Password: </label><input type='password' name='givenPassword'>
			  <br>
			  <label>Retype Password: </label><input type='password' name='givenPassword2'>
			  <br>
			<input type='submit' name='submit' value='Submit'>
			</form>
			<a href='forgotpassword.php'>Forgot Password</a><br>
			<a href='login.php'>Log In</a><br>
			</div>
	 		");
	 		
	 		$this->page->endDoc();
	 	}
		
		
		function generateConfirmationEmail(){
			$to = $_POST["givenEmail"];
    		$subject = "Quartz Registration Information";
    		$message = "Please click ";
    		$message .= "<a href='http://localhost:8888/kamaji_quartz/login.php'>here</a>";
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
