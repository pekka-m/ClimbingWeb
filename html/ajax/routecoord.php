<?php
session_start();
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});
$crag = new Crag();
$cragid = $_GET['crag'];
if(!$cragid) {
	return false;
}
// haetaan cragin koordinaatit
$crag->getCragcoordJson($cragid);
?>