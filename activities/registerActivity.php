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
	 	var $server;

	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		$this->server = $this->model->getServer();
	 		$this->page = new Page("Register");

	 		if(isset($_GET['activate'])) {			//[RA.001]
	 		
	 			$this->context = "activating";
	 			
	 		} else {
	 		
		 		if(isset($_POST['submit'])) {
		 		
		 			if($_POST['givenName']!="") {
		 			
		 				if ($this->model->checkEmail($_POST["givenEmail"])) {
		 				
		 					if ($_POST['givenPassword'] == $_POST['givenPassword2'] && $_POST['givenPassword']!=""){
		 					
		 						$this->context = "submitting";
		 						$this->emptyFlag = "";
		 					
		 					} else {
		 					
		 						$this->context = "showingform";
		 						$this->emptyFlag = "Error: Please verify your password.";
		 					
		 					}
		 				} else {
		 					
		 					$this->context = "showingform";
		 					$this->emptyFlag = "Error: Please enter a valid email.";
		 				
		 				}
		 			} else {
		 				
		 				$this->context = "showingform";
		 				$this->emptyFlag = "Error: Please enter all fields.";
		 			
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
					
						$this->id = $this->model->storeRegistrationData($this->name,$this->email,$this->password1);			//[RA.002]		
// 						$model->addRecentActivity($this->email,"Registered User",date('n/j/Y'));					
						$this->generateConfirmationEmail($this->id);

					} else {
						$this->emptyFlag = "Error: Passwords do not Match.";
					}
				} else {
					$this->emptyFlag = "Error: Please Enter Valid Email.";
				}
			} else if($this->context == "activating"){

				$isValid = $this->model->activateAccount($this->id);		//[RA.003]

				if($isValid == 1) {
				} else if($isValid == 0){
				  header("Location: $this->server/kamaji_quartz/login.php");
				} 
			}
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
	 		if($this->context == "showingform") {
				if($this->emptyFlag != "") {			//[RA.004]
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
				  <br>
				  <label>Email: </label><input type='text' name='givenEmail'> 
				  <br>
				  <br>
	 			  <label>Password: </label><input type='password' name='givenPassword'>
				  <br>
				  <br>
				  <label>Retype Password: </label><input type='password' name='givenPassword2'>
				<input type='submit' name='submit' value='Submit'>
				</form>
				</div>
		 		");
			}  else if ($this->context == "submitting") {
				print("Thank you for registering for Quartz.  An email has been sent with the link to 
						complete the registration process");
			}	else if ($this->context == "activating") {
				print("Congratulations! You have succesfully registered for Quartz.  
						<a href='$this->server/kamaji_quartz/login.php'>Click Here</a> to log in.");
			} 		
	 		$this->page->endDoc();
	 	}
		
		
		function generateConfirmationEmail($id){
			$to = $_POST["givenEmail"];
    		$subject = "Quartz Registration Information";
    		$message = "Please click ";
    		$message .= "<a href='$this->server/kamaji_quartz/register.php?activate=1&id=$id'>here</a>";
    		$message .= " to login.";
    		$header = "From: webmaster@quartz.com";
    		$header .= 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    		
    		@mail($to,$subject,$message, $header);
		
			print(
			"
			<div id='confirmationEmail'>
			A confirmation email has been sent to your email address.  Please exit this page.
			</div>
			");
		}
	 }
?>
