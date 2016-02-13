<?php
session_start();
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});
$converter = new Converter();
$routeobject = new Route();
$routeid = $_GET['route'];
if(!$routeid) {
	return false;
}
// haetaan reitin tiedot jsoni muodossa annetulal reitti id:llä
$routeobject->getRouteJson($routeid);
?>

