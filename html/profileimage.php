<?php
$pu= new ImageUpload('profile', $_SESSION['logged_user']);
if (isset($_POST['datadir'])){
    $uploadfile = $_POST['datadir'] . $_FILES['filetto']['name'];
    $temp = explode(".",$_FILES["filetto"]["name"]);
    $newfilename = md5(time());
    $newfilenameext = $newfilename. '.' .end($temp); 
    move_uploaded_file($_FILES["filetto"]["tmp_name"], $_POST['datadir'] . $newfilenameext);
    $images = new Image($_POST['datadir'] . $newfilenameext);
    $images->resize(136,136, 'crop');
    $images->save($newfilename, $_POST['datadir']);        
    $pu->addImageToSQL($newfilenameext);    
    $pu->changeProfileImage($newfilenameext);
}
echo $user->loadProfilePic($_GET['user']);
echo $user->printCard();
if ($_GET['user'] == $_SESSION['logged_user_email']) $pu->lomake();
?>