<?php

include_once "../model/model.php";

session_start();

$model = new Model();

$model->setResearch($_SESSION["id"],$_POST["research"]);			//[MMAH.001]
$model->setPublications($_SESSION["id"],$_POST["publications"]);
$model->setPersonal($_SESSION["id"],$_POST["personal"]);

$model->changeName($_SESSION["id"],$_POST["name"]);
$model->setJobtitle($_SESSION["id"],$_POST["jobtitle"]);
$model->setAddress($_SESSION["id"],$_POST["address"]);
$model->setTelephone($_SESSION["id"],$_POST["telephone"]);
$model->setFax($_SESSION["id"],$_POST["fax"]);
$model->setOfficeHours($_SESSION["id"],$_POST["officehours"]);
$model->setBiography($_SESSION["id"],$_POST["biography"]);

// $model->addRecentActivity($_SESSION["id"],"Edited site content",date('n/j/Y'));

print (("Welcome, " . $_POST["user"]));		//[MMAH.002]
?>