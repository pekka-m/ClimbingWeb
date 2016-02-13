<?php 
include('initclasses.php');

if (is_numeric($steps = $_POST['steps'])) {

	//lisätään uusi campussuoritus mongoon
	$exercise = new Exercise();
	$exercise->addCampusExercise($steps);
	$exercise = NULL;
}
header('Location: sisa.php');
?>