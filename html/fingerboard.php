<?php
session_start();
include('initclasses.php');
$exercise = new Exercise();

//onko fingerboard käynnissä?
if (!isset($_SESSION['fingerboard_id'])) $exercise->startFingerboard();
else $exercise->endFingerboard();
$exercise = NULL;
header('Location: sisa.php');
?>