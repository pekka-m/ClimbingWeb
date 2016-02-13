<?php
include('initclasses.php');

if(isset($_POST['nappia'])){
    session_start();
    require_once("/var/www/db-init-climb.php");
    $name = $_POST['routename'];
    $lat = $_POST['lat'];
    $lon = $_POST['long'];
    $stmt = $db->prepare("INSERT INTO Crag(Name, Lat, Lon) values(:name, :lat, :lon)" );
    $stmt->execute(array(':name' => $name, ':lat' =>$lat, ':lon' =>$lon));
    header('Location: index.php');
}
?>