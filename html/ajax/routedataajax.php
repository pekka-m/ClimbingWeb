<?php
//require('classes/GradeConverter.class.php');
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});
include('classes/testaus.html');
  $converter = new Auth();
echo "toimii";

/*$routeid = $_GET['route'];
if(!$routeid) {
	return false;
}
session_start();
require_once ('/var/www/db-init-climb.php');
$stmt = $db->prepare("SELECT RouteId, Name, Grade FROM Route WHERE RouteId=:routeid");
$stmt->execute(array(':routeid' => $routeid));
$data =$stmt->fetch(PDO::FETCH_ASSOC);
//echo "jotain";
//$converter = new Converter();


//$data['Grade']=$conv->unConvert($data['Grade']);
echo json_encode($data); */
?>

