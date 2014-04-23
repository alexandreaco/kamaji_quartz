<?php

	// model
	 include 'model/model.php';


	$model = new Model();
	
	$model->changeName($_POST["email"], $_POST["newName"]);
// $model->addRecentActivity($_SESSION["id"],"Changed display name",date('n/j/Y'));
	
	print (("Your new name is " . $_POST["newName"]));

?>