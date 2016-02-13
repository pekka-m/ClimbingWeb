<?php
$user = strtolower($_POST['search']);
header ("Location: profile.php?user=$user&page=profile");
?>