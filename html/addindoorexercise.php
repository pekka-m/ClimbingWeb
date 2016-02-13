<?php
include('initclasses.php');
$converter = new Converter();
$grade = $_POST['grade_number'] . $_POST['grade_letter'] . $_POST['grade_plus'];
$type = "indoor-" . $_POST['type'];

//lisätään uusi suoritus mongoon
$exercise = new Exercise();
$exercise->addIndoorExercise($type, $converter->convert($grade));
$exercise = NULL;
header('Location: sisa.php');
?>