<?php
session_start();
include('initclasses.php');
if(isset($_POST['addroute'])){
    $cragid = $_POST['crag'];
    $name = $_POST['routename'];
    $routegrade  = $_POST['grade_number'] . $_POST['grade_letter'] . $_POST['grade_plus'];
    $description = $_POST['description'] ?: ' ';
    
    $route = new Route();
    $routeid = $route->addRouteToDB($cragid, $name, $routegrade, $description);
    $datapath =  $_POST['datadir']. $routeid ."/";    
    $image = new ImageUpload('route', $routeid);
    $temp = explode(".",$_FILES["filetto"]["name"]);
    $newfilename = md5(time());
    $newfilenameext = $newfilename. '.' .end($temp); 
    move_uploaded_file($_FILES["filetto"]["tmp_name"], $datapath . $newfilenameext);
    $images = new Image($datapath . $newfilenameext);
    $images->resize(175,150, 'crop');
    $images->save($newfilename, $datapath);        
    $image->addImageToSQL($newfilenameext);
    $image->linkImage('route', $routeid, $newfilenameext);
}
    header('Location: markroute.php');
?>