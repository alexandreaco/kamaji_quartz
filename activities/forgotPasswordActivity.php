<?php

include_once "model/model.php";

class forgotPasswordActivity {
		var $model;
		var $emptyFlag;

function __construct()
	{
			$this->model = new Model();
			$this->page = new Page("Forgot Password");
			
	}
	
function getInput() {

}

function show() {
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


function process() {
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

function run() 
	{
	$this->process();
	$this->show();
	}
		
	
	function generateEmail()
		{
			$to = $_POST["givenEmail"];
    		$subject = "Quartz Forgot Password Information";
    		$message = "Please click ";
    		$message .= "<a href='reset.php'>here</a>";
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