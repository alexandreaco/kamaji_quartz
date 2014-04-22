<?php

include_once "model/model.php";

class forgotPasswordActivity {
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
			<form name='input' action='forgotpassword.php' method='post' id='loginform'>
			Email: <input type='text' name='email'>
			<input type='submit' value='Submit'>
			</form>
			</div>
			");
			
	$this->page->endDoc();
	}
	else
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
			
				<form name='input' action='forgotpassword.php' method='post' id='loginform'>
				Email: <input type='text' name='email'><br>
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

if($this->context == "showingform"){
	if (isset($_POST['email']))
		{	
			if ($this->model->checkEmail($_POST['email']))
				{
					$this->generateEmail();
					$this->emptyFlag = "";
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
	else 
	{
	if (isset($_POST['email']))
	{
	if ($_POST['email'] == "JILL@gmail.com" && $model->isValidLoginName($_POST['email']))
	{
		if (isset($_POST['newpassword']) && isset($_POST['newpassword2']))
		{
			if ($_POST['newpassword'] == $_POST['newpassword2'] && ($_POST['newpassword'] != "" ))
			{
				if ($model->setNewPassword($_POST['email'],$_POST['newpassword']))
				{
					print(
					"
					<div id='confirmationEmail'>
					Your new password has been set.
					</div>
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
    		$message .= "<a href='http://localhost:8888/kamaji_quartz/forgotpassword.php'>here</a>";
    		$message .= "to reset your password.";
    		$header = "From: webmaster@quartz.com";
    		
    		mail($to,$subject,$message, $header);
		
			print(
			"
			<div id='confirmationEmail'>
			An email containing a link to create a new password has been sent to you.
			</div>
			");
		}
}

?>