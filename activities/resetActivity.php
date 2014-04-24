<?php

include_once "model/model.php";

class resetActivity {
		var $context;
		var $page;
		var $model;
		var $email;
		var $emptyFlag;
		var $password1;
	 	var $password2;
	 	var $id;
	 	var $server;

function __construct()
	{
			$this->model = new Model();
			$this->server = $this->model->getServer();

			$this->page = new Page("Forgot Password");
			
			if (isset($_GET['activate'])) {
	 			$this->context = "activating";														//[ReA.001]
	 		} else if (isset($_POST['submit'])) {													//[ReA.002]
		 		if ($this->model->checkEmail($_POST['email'])) {
		 			$this->context = "submitting";
		 		} else {
		 			$this->context = "showingform";
		 			$this->emptyFlag = "Error: The email entered isn't registered.";
		 		}
		 	} else if (isset($_POST['submiT'])) {													//[ReA.003]
		 		if (isset($_POST['newpassword']) && isset($_POST['newpassword2'])) {
		 			if ($_POST['newpassword'] == $_POST['newpassword2']) {
		 				if ($_POST['newpassword']!= "" && $_POST['newpassword2']!= "") {
		 					$this->context = "reset"; 												//[ReA.004]
		 				} else {
		 					$this->context = "activating";
		 					$this->emptyFlag = "Error: Please enter a password and confirm it.";
		 				}
		 			} else {
		 			$this->context = "activating";
		 			$this->emptyFlag = "Error: The passwords you entered do not match.";
		 			}
		 		} else {
		 			$this->context = "activating";
		 			$this->emptyFlag = "Error: The passwords you entered do not match.";
		 		}
		 	}	
		 	else {
		 		$this->context = "showingform";														//[ReA.005]
			}
	}
			
	
function getInput() {
	if($this->context == 'submitting'){
	 			$this->email = $_POST["email"];
	} else if($this->context == "activating") {
	 			$this->id = $_GET['id'];															//[ReA.006]
	}			
}

function show() {																					
	
	$this->page->beginDoc();
	
	if($this->context == "showingform"){															

		if($this->emptyFlag != "") {
			print("
			<div id='error'>
			$this->emptyFlag
			</div>
			");
		}

	print("
			<div id='forgot'>
			<h2>Reset Password</h2>
			<form name='input' action='reset.php' method='post' id='loginform'>
			Email: <input type='text' name='email'>
			<input type='submit' name='submit' value='Submit'>
			</form>
			<a href='login.php'>Log In</a><br>
			<a href='register.php'>Create Account</a><br>
			</div>
			");
	}
	
	else if($this->context == "submitting")															
	{
		if($this->emptyFlag != "") {
			print("
			<div id='error'>
			$this->emptyFlag
			</div>
			");
		}

		print("An email containing a link to create a new password has been sent to you.");
	
	}
	
	else if($this->context == "activating")															
	{

		if($this->emptyFlag != "") {
			print("
			<div id='error'>
			$this->emptyFlag
			</div>
			");
		}

	print("
			<div id='forgot'>
			
				<form name='input' action='reset.php' method='post' id='loginform'>
				Enter New Password: <input type='password' name='newpassword'><br>
				Confirm New Password: <input type='password' name='newpassword2'><br>
				<input type='submit' name='submiT' value='Submit'>
				</form>
				</div>
			");
	}
	else if ($this->context == "reset")																
	{
		if($this->emptyFlag != "") {
			print("
			<div id='error'>
			$this->emptyFlag
			</div>
			");
		}
		
	print("
	Congratulations! You have succesfully changed your password.  
		<a href='$this->server/kamaji_quartz/login.php'>Click Here</a> to log in.
	
	");
	}
	$this->page->endDoc();
}


function process() {

if ($this->context == "submitting")																//[ReA.007]
{
	if ($this->model->checkEmail($_POST['email']))
	{
	$this->id = $this->model->storeEmail($this->email);											
	$this->generateConfirmationEmail($this->id);
	} else
	{
	//$this->emptyFlag = "Error: The email entered isn't registered.";
	}
}

else if ($this->context == "reset") 
{
	if (isset($_POST['newpassword']) && isset($_POST['newpassword2']))
		{
			if ($_POST['newpassword'] == $_POST['newpassword2'] && ($_POST['newpassword'] != "" ))
			{
				$this->model->resetPassword($this->id, $this->password1);						//[ReA.008]
				
// 						$model->addRecentActivity($this->id,"Reset Password",date('n/j/Y'));		
				
			}
			else
			{
				$this->emptyFlag = "Error: The passwords you entered do not match.";
			}
		}
		else
		{
		$this->emptyFlag = "Error: Please enter a password and confirm it.";
		}
	}
}
	


function run() 
	{
	//$this->getInput();
	$this->process();
	$this->show();
	}
		
	
	function generateConfirmationEmail($id)
		{
			$to = $_POST["email"];
    		$subject = "Quartz Forgot Password Information";
    		$message = "Please click ";
    		$message .= "<a href='$this->server/kamaji_quartz/reset.php?activate=1&id=$id'>here</a>";
    		$message .= "to reset your password.";
    		$header = "From: webmaster@quartz.com";
    		
    		mail($to,$subject,$message, $header);
	}
}

?>
