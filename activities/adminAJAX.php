<?php

	// model
	 include 'model/model.php';


	$model = new Model();
	
	$model->changeName($_POST["email"], $_POST["newName"])
	
	print (("Your new name is " . $_POST["newName"]));

?>