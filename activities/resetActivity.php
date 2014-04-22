<?php

include_once "model/model.php";

class resetActivity {
		var $context;
		var $page;
		var $model;
		var $emptyFlag;

function __construct()
	{
			$this->model = new Model();
			$this->page = new Page("Forgot Password");
			
			
			if(isset($_POST['submit'])){
	 			if($_POST['email']!=""){
	 				$this->context = "submitting";
	 			} 
	 		}
	 		else {
	 			$this->context = "showingform";
	 		}
	}
	
function getInput() {

}

function show() {
	
	if($this->context == "showingform"){
	
	$this->page->beginDoc();

	if($this->emptyFlag != "") {
			print("
			<div id='forgotError'>
			$this->emptyFlag
			</div>
			");
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
			
	$this->page->endDoc();
	}
	
	if($this->context == "submitting")
	{
	$this->page->beginDoc();

	if($this->emptyFlag != "") {
			print("
			<div id='forgotError'>
			$this->emptyFlag
			</div>
			");
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
			
	$this->page->endDoc();
	}
}


function process() {

if ($this->context == "showingform"){
	if (isset($_POST['email']))
		{	
			if ($this->model->checkEmail($_POST['email']))
				{
					$this->generateEmail();
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

if ($this->context == "submitting") 
	{
	if (isset($_POST['email']))
	{
	if (($this->model->checkEmail($_POST['email']) && $model->isValidLoginName($_POST['email'])))
	{
		if (isset($_POST['newpassword']) && isset($_POST['newpassword2']))
		{
			if ($_POST['newpassword'] == $_POST['newpassword2'] && ($_POST['newpassword'] != "" ))
			{
				if ($model->setNewPassword($_POST['email'],$_POST['newpassword']))
				{
					print(
					"
					
					Your new password has been set.
					
					");
				}
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
