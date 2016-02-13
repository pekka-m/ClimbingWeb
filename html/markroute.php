<!DOCTYPE html>
<?php
session_start();
include 'initclasses.php';

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1  user-scalable=no">
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="styles/normalize.css">
        <link rel="stylesheet" type="text/css" href="styles/markroute.css">
        <script src="libraries/jquery-2.1.3.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHM5-PHCencLLC0cgbV74whHNPoFDu0uE"></script>
        <script src="libraries/geolocationmarker-compiled.js"></script> 
        <link rel=stylesheet type="text/css" href="styles/profile.css">
       
        <title>add route</title>
    </head>
    <body>
        <div id="map-canvas"></div>
        <div id="container">
<?php include "navbar.php" ?>
            <div id="content">
                <p>Select crag where you want to add route</p>
                <form id="image_upload_form" enctype="multipart/form-data" action="addroutetodb.php" method="post">
                    <select name="crag"  id="crags">
                        <option value="">Crags</option>
<?php
$crag = new Crag();
$crag->getCragsFromDB();
$crag->printCragList();
?>
                    </select>
                    <div id="kortti">
                    </div>
                </form>
                <p> or add crag to your current location</p>
                <div id='cragikortti'>
                    <button id='nappula' name='buton' value='getlocation'>get location</button>
                    <form method="post" enctype="multipart/form-data" action="addcragtodb.php">
                <input type='text' name='cragname' placeholder='crag name'>
                    <div class='clear'></div>
                        <div class='upload'><input id='image_upload' name='filetti' type='file'><input type='hidden' name='datadir' value='/var/www/html/images/crag/'></div>
                    <input type='submit' name='cragupload' value='add crag'>
                        <input id="lat" type="hidden" name="lat" value=''>
                    <input id="long" type="hidden" name="long" value=''>
                    </form>
                </div>
            </div>
        </div>
        <script src="scripts/markroute_route_card.js"></script> 
        <script src="scripts/markroute.js"></script>
        <script src="scripts/nav_bar.js"></script>
    </body>
</html>