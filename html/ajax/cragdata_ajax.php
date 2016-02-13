<?php
session_start();
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});
// tehdään uusi Crag luokan ilmentymä
$crag = new Crag();
$cragid = $_GET['crag'];
if(!$cragid) {
	return false;
}
// haetaa cragin tiedot antammalla haettavan cragin id, tulostuu jsonina
echo $crag->getCragJson($cragid); 

?>

