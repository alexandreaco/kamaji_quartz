<?php

	// model
	 include 'model/model.php';


	$model = new Model();
	
// 	$model->addUser($_POST["email"], $_POST["status"])
// $model->addRecentActivity($_SESSION["id"],"Added new valid email",date('n/j/Y'));
	$model->addUser($_POST["email"])
	
	print (("Welcome to Quartz " . $_POST["email"]));

?>