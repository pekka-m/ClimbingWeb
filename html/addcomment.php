<?php
session_start();
include('initclasses.php');
$comment = new Comment();
$comment->addComment($_SESSION['logged_user'], $_POST['target'], $_POST['comment'], $_POST['commenttable']);
header ("Location: profile.php?user={$_POST['target']}&page=feed");
?>