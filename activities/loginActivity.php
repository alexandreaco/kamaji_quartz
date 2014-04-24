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
	 	var $server;
	 	var $subfolder;
	 
	 	// constructor
	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		$this->server = $this->model->getServer();
	 		$this->subfolder = $this->model->getSubfolder();
	 		$this->page = new Page("Login");
	 		
	 		if(isset($_POST['submit'])){
	 		
	 			if($_POST['name']!="" && $_POST['password']!=""){
	 			
	 				$this->context = "submitting";							//[LA.001]
	 				$this->error = "";
	 				
	 			} else {
	 			
	 				$this->context = "showingform";
	 				$this->error = "ERROR: All fields required.";
	 				
	 			}
	 		} elseif(isset($_GET['logout'])) {

	 			if (session_status() == PHP_SESSION_NONE) {

					session_destroy();

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
	 	
			if($this->context == "submitting"){
			
				$check = $this->model->checkCredentials($this->name,$this->password);		//[LA.002]



				if($check =="Valid Credentials"){
				
					session_start();
					
					$_SESSION["timeout"] = time();
					$_SESSION["id"] = $this->name;											//[LA.003]

					$status = $this->model->getAdminStatus($this->name);					//[LA.004]

					if($status == '1'){
						header( 'Location: admin.php');
					} else {
						header( 'Location: mymanage.php' ) ;
					}

					exit();
				} else {
					$this->error = $check;
				}
			}
		}
	 		 	
	 	// show
	 	function show() {
	 		$this->page->beginDoc();

	 		if($this->error != ""){
	 		
	 			print("<div id='error'>$this->error</font></center></div>");				//[LA.005]
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
			<a href='$this->server/$this->subfolder/reset.php'>Forgot Password</a><br>
			<a href='$this->server/$this->subfolder/register.php'>Create Account</a><br>
			</div>");
			
	 		$this->page->endDoc();
	 	}
	 
	 
	 }


?>