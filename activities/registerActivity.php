<?php

	/*	registerActivity.php
	 *
	 *	Author: Mike Bartlett
	 *	Date: 4/18/2014
	 * 
	 */

	 
	 class RegistrationActivity {
	 
	 	// data members
	 	var $page;
	 	var $model;
	 
	 
	 	// constructor
	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		
	 		$this->page = new Page("Register");
	 		
	 		
	 	}
	 
	 
	 	// run
		function run() {
			
			$this->process();
			$this->show();
			
		}
	 
	 
	 	// get input
	 	function getInput() {
	 	
	 	}
	 	
	 	
	 	// process
	 	function process() {
	 	
			if (isset($_POST["givenName"]) && $_POST["givenName"] != "")
			{
				if (isset($_POST["givenEmail"]) && $_POST["givenEmail"] != "")
				{
					$emailInUse = $this->model->checkEmail($_POST["givenEmail"]);
					if($emailInUse)
					{
						echo "<script>
								document.getElementById('errormessage').innerHTML = 'EMAIL IS ALREADY IN USE';
								</script>";
						//echo "EMAIL IS ALREADY IN USE";
						//CREATE ERROR, REDO
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
									//echo "VALID AND UNUSED ACCOUNT! WE'RE GOOD TO GO!<br>";
									echo "<script>
										document.getElementById('errormessage').innerHTML = 'VALID AND UNUSED ACCOUNT! GOOD TO GO!<br>';
										</script>";
									//HERE'S AN ACTUAL CALL TO THE MODEL API
									//$this->model->createUser($_POST["givenName"],
															//$_POST["givenEmail"],
															//$_POST["givenPassword"]);
									$this->generateConfirmationEmail();
								}
								else
								{
									echo "<script>
										document.getElementById('errormessage').innerHTML = 'PASSWORDS DONT MATCH';
										</script>";
									echo "PASSWORDS DON'T MATCH";
									//$this->showRegisterForm();
								}
							}
							else
							{
								echo "<script>
									document.getElementById('errormessage').innerHTML = 'PLEASE RETYPE THE PASSWORD';
									</script>";
								//echo "PLEASE RETYPE THE PASSWORD";
								//SEND ERROR, CONFIRM PASSWORD
							}
						}
						else
						{
							echo "<script>
								document.getElementById('errormessage').innerHTML = 'PLEASE ENTER A PASSWORD';
								</script>";
							//echo "PLEASE ENTER A PASSWORD";
							//SEND ERROR, ENTER PASSWORD
						}
					}
				}
				else
				{
					echo "<script>
					document.getElementById('errormessage').innerHTML = 'PLEASE ENTER AN EMAIL';
					</script>";
					//echo "PLEASE ENTER AN EMAIL";
					//SEND ERROR, NEED EMAIL
					
				}
			}
			else
			{
				if( isset($_POST['givenEmail']) || isset($_POST['givenPassword']) || isset($_POST['givenPassword2']))
				{
					echo "<script>
							document.getElementById('errormessage').innerHTML = 'PLEASE ENTER A VALID NAME';
							</script>";
					//echo "PLEASE ENTER A VALID NAME";
				//CREATE ERROR, NAME
				}
			}
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
	 		echo "<head>";
			echo "<link rel='stylesheet' type='text/css' href='customCSS.css'>";
			include 'header.php';
			echo "</head>";
			
			$name = isset($_POST['givenName'])?$_POST['givenName']:null;
			//$name = $_POST['givenName'];
			$email = isset($_POST['givenEmail'])?$_POST['givenEmail']:null;
			echo "<body>";
			echo "<div class='content'>";
			echo "<form id='reg' name='input' action='register.php' method='post'>";
			echo "
			  <label class='reg' for='givenName'>Name:</label>
			  <input type='text' name='givenName'>
			  <br>
			  <label class='reg' for='givenEmail'>Email:</label>
			  <input type='text' name='givenEmail' value=$email>
			  <br>
			  <label class='reg' for='givenPassword'>Pass:</label>
			  <input type='password' name='givenPassword'>
			  <br>
			  <label class='reg' for='givenPassword2'>Pass2:</label>
			  <input type='password' name='givenPassword2'>
			  <br>";
			echo "<input type='submit' value='Submit'>";
			echo "</form>";
			echo "<div id='errormessage'></div>";
			echo "</div>";
			echo "</body>";
			include 'footer.php';
	 		
	 		$this->page->endDoc();
	 		
	 	
	 	}
		
		function generateConfirmationEmail()
		{
			echo "<br>
			Hooray! You've reached the confirmation email! <br>
			<a href='ghostLogin.php'>Click Here to confirm your account and go to your MyManage Page!</a>
			<br>
			<a href='login.php'>You can also use this link at any time to Log-In normally</a>";
		}
	 
	 
	 }


?>