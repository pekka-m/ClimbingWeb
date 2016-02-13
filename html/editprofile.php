<?php
session_start();
include('initclasses.php');

$data = [
    $_POST['nickname'],
    $_POST['firstname'],
    $_POST['lastname'],
    $_POST['phonenumber'],
    $_POST['address'],
    $_POST['country'],
    $_POST['sex'],
    $_POST['homepage'],
    $_POST['shoebrand'],
    $_POST['shoemodel'],
    $_POST['shoesize'],
    $_SESSION['logged_user']
];

$user = new User($_SESSION['logged_user_email']);
$user->edit($data);

header("Location: profile.php?user={$_SESSION['logged_user_email']}");
?>