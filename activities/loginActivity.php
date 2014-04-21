<?php

	/*	loginActivity.php
	 *
	 *	Author: Mike Bartlett
	 *	Date: 4/18/2014
	 * 
	 */

	 
	 class LoginActivity {
	 
	 	// data members
	 	var $page;
	 	var $model;
	 
	 
	 	// constructor
	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		
	 		$this->page = new Page("Login");
	 		
	 		
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
	 	
		if (!isset($_POST["submit"]))
		{
			if (isset($_POST["firstname"]))
			{
				$newName = $_POST["firstname"];
				if (!($newName == "JILL@gmail.com")) //THIS WILL EVENTUALLY TAKE MODEL VALUES
				{
					//FUTURE: CREATE MODEL FUNCTION checkValidLogin($newName,$newPass) to compare
					echo "<script>
						document.getElementById('loginerrormessage').style.border ='3px solid';
						document.getElementById('loginerrormessage').innerHTML = 'INVALID LOGIN';
						</script>";
				}
				else
				{
					if (isset($_POST["password"]))
					{
						$newPass = $_POST["password"];
						if (!($newPass == "JILLSPASSWORD")) //THIS WILL EVENTUALLY TAKE MODEL VALUES
						{
							echo "<script>
									document.getElementById('loginerrormessage').style.border ='3px solid';
									document.getElementById('loginerrormessage').innerHTML = 'INCORRECT PASSWORD';
									</script>";
						}
						else
						{
							
							echo "Valid Login.<br> Should change header location to the MyManage Page";
							//Should change header to MyManage
						}
					}
				}
			}
		}
		else
		{
			echo "<p>No data submitted.</p>";
		}
		
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
			echo "<head>";
			echo "<link rel='stylesheet' type='text/css/' href='css/style.css' />";
			echo "</head>";
	 		
			echo "<body>";
			echo "<div id='container'>
				<div id='header'></div>
		
				<div id='content'>";
				echo "<div id='loginerrormessage'></div>";
				
				echo "<form name='input' action='login.php' method='post' id='loginform'>";
				echo "Email: <input type='text' name='firstname'>
				<br>
				Password: <input type='password' name='password'>
				<br><br>";
				echo "<input type='submit' value='Submit'>";
				echo "</form>";
				echo "<div id='loginlinkbox'>
				<a href='forgotpassword.php'>Forgot Password?</a><br>
				<a href='register.php'>New to Quartz?</a><br>
				</div>";
				echo "</div>"; //Content Div
				
				echo "<div id='footer'></div>";
				echo "</body>";
			
	 		$this->page->endDoc();
	 		
	 	
	 	}
	 
	 
	 }


?>