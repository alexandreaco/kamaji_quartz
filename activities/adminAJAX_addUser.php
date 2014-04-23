<?php

	// model
	 include 'model/model.php';


	$model = new Model();
	
// 	$model->addUser($_POST["email"], $_POST["status"])
	$model->addUser($_POST["email"])
	
	print (("Welcome to Quartz " . $_POST["email"]));

?>