<?php

include_once "../model/model.php";
$model = new Model();

$model->setResearch($_POST["user"],$_POST["research"]);
$model->setPublications($_POST["user"],$_POST["publications"]);
$model->setPersonal($_POST["user"],$_POST["personal"]);

$model->setJobtitle($_POST["user"],$_POST["jobtitle"]);
$model->setAddress($_POST["user"],$_POST["address"]);
$model->setTelephone($_POST["user"],$_POST["telephone"]);
$model->setFax($_POST["user"],$_POST["fax"]);
$model->setOfficeHours($_POST["user"],$_POST["officehours"]);
$model->setBiography($_POST["user"],$_POST["biography"]);

?>