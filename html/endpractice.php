<?php
session_start();
include('initclasses.php');
if (isset($_SESSION['practice_start_time'])) {
    $practice = new Practice();
    $practice->endp();
    $practice = NULL;
}
header ('Location: main.php');
?>