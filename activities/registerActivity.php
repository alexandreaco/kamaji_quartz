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
					$this->model->createUser($_POST["givenName"],
											 $_POST["givenEmail"],
											 $_POST["givenPassword"]);
											
					$this->generateConfirmationEmail();
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
