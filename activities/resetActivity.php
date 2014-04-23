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

function __construct()
	{
			$this->model = new Model();
			$this->page = new Page("Forgot Password");
			
			if(isset($_GET['activate'])) {
	 			$this->context = "activating";
	 		} else {
		 		if(isset($_POST['submit'])) {
		 		if($_POST['email']!=""){
		 				$this->context = "submitting";
		 		} else {
		 				$this->context = "showingform";
		 				}
		 		} else {
		 			$this->context = "showingform";
				}
			}
		}
			
	
function getInput() {
	if($this->context == 'submitting'){
	 			$this->email = $_POST["email"];
	} else if($this->context == "activating") {
	 			$this->id = $_GET['id'];
	}			
}

function show() {
	
	$this->page->beginDoc();
	
	if($this->context == "showingform"){

	if($this->emptyFlag != "") {
			print("<div id='error'>$this->emptyFlag</font></center></div>");
			}

	print("
			<div id='forgot'>
			<h2>Reset Password</h2>
			<form name='input' action='reset.php' method='post' id='loginform'>
			Email: <input type='text' name='email'>
			<input type='submit' value='Submit'>
			</form>
			<a href='login.php'>Log In</a><br>
			<a href='register.php'>Create Account</a><br>
			</div>
			");
	}
	
	else if($this->context == "submitting")
	{
		print("An email containing a link to create a new password has been sent to you.");
	
	}
	
	else if($this->context == "activating")
	{

	if($this->emptyFlag != "") {

			print("<div id='error'>$this->emptyFlag</font></center></div>");
			}

	print("
			<div id='forgot'>
			
				<form name='input' action='reset.php' method='post' id='loginform'>
				Enter New Password: <input type='password' name='newpassword'><br>
				Confirm New Password: <input type='password' name='newpassword2'><br>
				<input type='submit' value='Submit'>
				</form>
				</div>
			");
	}
	$this->page->endDoc();
}


function process() {

if ($this->context == "showingform"){
	if (isset($_POST['email']))
		{	
			if ($this->model->checkEmail($_POST['email']))
				{
					$this->id = $this->model->storeEmail($this->email);
					$this->generateConfirmationEmail($this->id);
				}
				else
				{
				$this->emptyFlag = "Error: The email entered isn't registered.";
				}
		} 
		else
		{
		$this->emptyFlag = "";
		}
}

else if ($this->context == "submitting")
{
}

else if ($this->context == "activating") 
	{
	if (isset($_POST['email']))
	{
	if (($this->model->checkEmail($_POST['email']) && $model->isValidLoginName($_POST['email'])))
	{
		if (isset($_POST['newpassword']) && isset($_POST['newpassword2']))
		{
			if ($_POST['newpassword'] == $_POST['newpassword2'] && ($_POST['newpassword'] != "" ))
			{
				$this->model->resetPassword($this->id, $this->password1);
				
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
	else
	{
	$this->emptyFlag = "Error: The account isn't registered with Quartz.";
	}
	}
	print("NO!");
	}
	
}

function run() 
	{
	$this->process();
	$this->show();
	}
		
	
	function generateEmail()
		{
			$to = $_POST["email"];
    		$subject = "Quartz Forgot Password Information";
    		$message = "Please click ";
    		$message .= "<a href='http://localhost:8888/kamaji_quartz/reset.php?email=$to'>here</a>";
    		$message .= "to reset your password.";
    		$header = "From: webmaster@quartz.com";
    		
    		mail($to,$subject,$message, $header);
		
			print(
			"
			
			An email containing a link to create a new password has been sent to you.
			
			");
		}
}

?>
