<?php
session_start();
include('initclasses.php');
if(isset($_POST['cragupload'])){
    $name = $_POST['cragname'];
    $lat = $_POST['lat'];
    $long = $_POST['long'];
    
    $crag = new Crag();
    $cragid = $crag->addCragToDB($name, $lat, $long);
    $datapath =  $_POST['datadir']. $cragid ."/";
    $image = new ImageUpload('crag', $cragid);
    $uploadfile = $datapath . $_FILES['filetti']['name'];
    $temp = explode(".",$_FILES["filetti"]["name"]);
    $newfilename = md5(time());
    $newfilenameext = $newfilename. '.' .end($temp); 
    move_uploaded_file($_FILES["filetti"]["tmp_name"], $datapath . $newfilenameext);
    $images = new Image($datapath. $newfilenameext);
    $images->resize(175,150, 'crop');
    $images->save($newfilename, $datapath);        
    $image->addImageToSQL($newfilenameext);
    $image->linkImage('crag', $cragid, $newfilenameext);
}
    header('Location: markroute.php');
?>