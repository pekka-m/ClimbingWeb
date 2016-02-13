<?php
session_start();
$crag = $_POST['crag'];
if(!$crag) {
	return false;
}
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});
$route = new Route();
$route->printSelectRoutes($crag);
?>