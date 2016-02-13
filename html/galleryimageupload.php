<?php
session_start();
include('initclasses.php');
echo "MITITIAITAII";
$iu = new ImageUpload('profile', $_SESSION['logged_user']);

if (isset($_FILES['filetto'])) {
    $uploadfile = $iu->getDatadir() . $_FILES['filetto']['name'];
    $temp = explode(".",$_FILES["filetto"]["name"]);
    $newfilename = md5(time());
    $newfilenameext = $newfilename. '.' .end($temp); 
    move_uploaded_file($_FILES["filetto"]["tmp_name"], $iu->getDatadir() . $newfilenameext);
    $images = new Image($iu->getDatadir() . $newfilenameext);
    $images->resize(256,256, 'crop');
    $images->save($newfilename, $iu->getDatadir());        
    $iu->addImageToSQL($newfilenameext);    
    $iu->linkImage('user', null, $newfilenameext);
}
header('Location: profile.php?page=pictures');

?>