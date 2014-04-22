<?php

include_once "../model/model.php";
$model = new Model();

$model->setResearch($_POST["user"],$_POST["research"]);
$model->setPublications($_POST["user"],$_POST["publications"]);
$model->setPersonal($_POST["user"],$_POST["personal"]);


?>