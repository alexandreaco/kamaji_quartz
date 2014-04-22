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
					$status = $this->model->getAdminStatus($this->name);

					if($status == '1'){
						header( 'Location: admin.php');
					} else {
						header( 'Location: mymanage.php' ) ;
					}
				} else {
					$this->error = $check;
				}
			}
		}
	 		 	
	 	// show
	 	function show() {
	 		$this->page->beginDoc();

	 		if($this->error != ""){
	 			print("<div id='error'>$this->error</font></center></div>");
	 		}
			print("
			<div class='login'>
			<h2>Login</h2>
			<form name='input' action='login.php' method='post' id='loginform'>
			<label>Email: </label><input type='text' name='name'>
			<br>
			<label>Password: </label><input type='password' name='password'>
			<br><br>
			<input type='submit' name='submit' value='Log In'>
			</form>
<<<<<<< HEAD
			<a href='reset.php'>Forgot Password?</a><br>
			<a href='register.php'>New to Quartz?</a><br>
=======
			<a href='forgotpassword.php'>Forgot Password</a><br>
			<a href='register.php'>Create Account</a><br>
>>>>>>> FETCH_HEAD
			</div>");
			
	 		$this->page->endDoc();
	 	}
	 
	 
	 }


?>