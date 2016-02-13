<?php
require_once ('classes/Auth.class.php');

$auth = new Auth();
$auth->logout();
$auth = NULL;
header('Location: index.php');
?>