<?php
include('initclasses.php');
$converter = new Converter();
$type = $_POST['type'];
$routeId = $_POST['routeId'];

//lisätään uusi suoritus mongoon
$exercise = new Exercise();
$exercise->addOutdoorExercise($type,$routeId);
$exercise = NULL;
header('Location: ulko.php');
?>

