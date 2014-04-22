<?php

	/*	loginActivity.php
	 *
	 *	Author: Mike Bartlett
	 *	Date: 4/18/2014
	 * 
	 */

	 
	 class LoginActivity {
	 
	 	// data members
	 	var $context;
	 	var $page;
	 	var $model;
	 	var $name;
	 	var $password;
	 	var $error;
	 
	 	// constructor
	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		$this->page = new Page("Login");
	 		
	 		if(isset($_POST['submit'])){
	 			if($_POST['name']!="" && $_POST['password']!=""){
	 				$this->context = "submitting";
	 				$this->error = "";
	 			} else {
	 				$this->context = "showingform";
	 				$this->error = "ERROR: All fields required.";
	 			}
	 		} else {
	 			$this->context = "showingform";
	 			$this->error = "";
	 		}

	 	}
	 
	 
	 	// run
		function run() {
			$this->getInput();
			$this->process();
			$this->show();
			
		}
	 
	 
	 	// get input
	 	function getInput() {
	 		if($this->context == 'submitting'){
	 			$this->name = $_POST["name"];
	 			$this->password = $_POST["password"];
	 		}
	 	}
	 	
	 	
	 	// process
	 	function process() {
			//FUTURE: CREATE MODEL FUNCTION checkValidLogin($newName,$newPass) to compare
			if($this->context == "submitting"){
				$check = $this->model->checkCredentials($this->name,$this->password);



				if($check =="Valid Credentials"){
					header( 'Location: mymanage.php' ) ;
				} else {
					$this->error = $check;
				}
			}
		}
	 		 	
	 	// show
	 	function show() {
	 		$this->page->beginDoc();

	 			print("
				<br><br><br><center><font color='FF0000'>$this->error</font></center>
				<div class='login'>
				<form name='input' action='login.php' method='post' id='loginform'>
				Email: <input type='text' name='name'>
				<br>
				Password: <input type='password' name='password'>
				<br><br>
				<input type='submit' name='submit' value='Submit'>
				</form>
				<a href='forgotpassword.php'>Forgot Password?</a><br>
				<a href='register.php'>New to Quartz?</a><br>
				</div>");
			
	 		$this->page->endDoc();
	 	}
	 
	 
	 }


?>