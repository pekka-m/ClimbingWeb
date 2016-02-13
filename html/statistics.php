<!DOCTYPE html>
<?php
include('initclasses.php');
?>
<html>
    <head>
	<title>Climbingtime - statistics</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        <link type="text/css" rel="stylesheet" href="styles/normalize.css">
        <link type="text/css" rel=stylesheet href="styles/statistics.css">
        <link type="text/css" rel="stylesheet" href="styles/nav_bar.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <script src="libraries/jquery-2.1.3.js"></script>
    </head>
    <body>
		<div id="container">
<?php include "navbar.php"; ?>
            <div id="content">
                <ul id='tabs'>
                    <li><a <?php if ($_GET['section'] == 'indoor') echo "class='active'"; ?>href="statistics.php?section=indoor">Sisä</a></li>
                    <li><a <?php if ($_GET['section'] == 'outdoor') echo "class='active'"; ?>href="statistics.php?section=outdoor">Ulko</a></li>
                </ul>
<?php
if (isset($_GET['id'])) {
    include "single-stat.php";
}
else include "stat-practices.php";
?>
            </div>
        </div>
        <script src="scripts/nav_bar.js"></script>
    </body>
</html>