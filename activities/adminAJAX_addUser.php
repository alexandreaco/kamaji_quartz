<?php

	// model
	include_once '../model/model.php';

	session_start();

	$model = new Model();
	
// 	$model->addUser($_POST["email"], $_POST["status"])
// $model->addRecentActivity($_SESSION["id"],"Added new valid email",date('n/j/Y'));
	$model->addEmail($_POST["email"]);
?>