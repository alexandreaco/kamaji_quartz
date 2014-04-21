<?php
 
	 class RegistrationActivity {
	 	var $page;
	 	var $model;
		var $emptyFlag;
	 

	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		$this->page = new Page("Register");
	 		
	 	}
	 
	 
		function run() {
			
			$this->process();
			$this->show();
			
		}
	 
	 
	 	function getInput() {
	 	
	 	}
	 	
	 	
	 	
	 	function process() {
	 	
			if (isset($_POST["givenName"]) && $_POST["givenName"] != "")
			{
				if (isset($_POST["givenEmail"]) && $_POST["givenEmail"] != "")
				{
					$emailInUse = $this->model->checkEmail($_POST["givenEmail"]);
					if($emailInUse)
					{
						$this->emptyFlag = "Error: Email already in use";
					}
					else
					{
						$pass1;
						$pass2;
						if(isset($_POST["givenPassword"]) && $_POST["givenPassword"] != "")
						{
							$pass1 = $_POST["givenPassword"];
							if(isset($_POST["givenPassword2"]) && $_POST["givenPassword2"] != "")
							{
								$pass2 = $_POST["givenPassword2"];
								$stringsEqual = ($pass1 == $pass2);
								if($stringsEqual)
								{
									
									$this->emptyFlag = "";
									
									
									$this->model->createUser($_POST["givenName"],
															 $_POST["givenEmail"],
															 $_POST["givenPassword"]);
									
									$this->generateConfirmationEmail();
								}
								else
								{
									$this->emptyFlag = "Error: Passwords don't match";
								}
							}
							else
							{
								$this->emptyFlag = "Error: Please retype your password";
							}
						}
						else
						{
							$this->emptyFlag = "Error: Please enter a password";
						}
					}
				}
				else
				{
					$this->emptyFlag = "Error: Please enter an email";
				}
			}
			else
			{
				if( isset($_POST['givenEmail']) || isset($_POST['givenPassword']) || isset($_POST['givenPassword2']))
				{
					$this->emptyFlag = "Error: Please enter a valid name";
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
			  Email: <input type='text' name='givenEmail' value=$email> 
			  <br>
			  <br>
 			  Password: <input type='password' name='givenPassword'>
			  <br>
			  <br>
			  Retype Password: <input type='password' name='givenPassword2'>
			  <br>
			  <br>
			<input type='submit' value='Submit'>
			</form>
			</div>
	 		");
	 		
	 		$this->page->endDoc();
	 	}
		
		
		function generateConfirmationEmail()
		{
			$to = $_POST["givenEmail"];
    		$subject = "Quartz Registration Information";
    		$message = "Please click ";
    		$message .= "<a href='login.php'>here</a>";
    		$message .= "to login.";
    		$header = "From: webmaster@quartz.com";
    		
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
