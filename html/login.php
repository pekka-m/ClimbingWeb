<?php
include('initclasses.php');

$email = $_POST['email'];
$passwd = $_POST['passwd'];
$auth = new Auth();
if ($auth->tryLogin($email, $passwd)) {
    $auth = NULL;
    header ('Location: main.php'); //tunnus salasana oikein
}
else {
    $auth = NULL;
    $_SESSION['error'] = "login_error";
    header ('Location: index.php'); //väärin
}
?>