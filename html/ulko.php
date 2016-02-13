<!DOCTYPE html>

<?php
session_start();
include('initclasses.php');
$crag = new Crag();
//jos ei ole aloitettu reeniä, niin aloitetaan
if (!isset($_SESSION['practice_start_time'])) {
    $practice = new Practice();
    $practice->start(1); //parametri: 1=ulkona, 0=sisällä
    $practice = NULL;
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1  user-scalable=no">
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="styles/normalize.css">
        <link rel="stylesheet" type="text/css" href="styles/ulko.css">
        <script src="libraries/jquery-2.1.3.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHM5-PHCencLLC0cgbV74whHNPoFDu0uE"></script>
        <script src="libraries/geolocationmarker-compiled.js"></script>    
        <script src="scripts/ulko.js"></script>
        
        <title>ulko</title>
    </head>
    <body>
        <div id="map-canvas"></div>
        <div id="container">
            <?php include "navbar.php";?>
            <div id="content">
                <select name="crag"  id="crags">
                    <option value="">Crags</option>
                    <?php
                    $crag->getCragsFromDB();
                    $crag->printCragList();
                      
                    ?>
                </select>
                <div id="route"  style="display:inline-block;">
                    <select name="route" id="reitti">
		              <option value="0">Routes</option>
	               </select>
                </div>
                <div id="kortti" ></div>
                <script src="scripts/addroutecard.js"></script>        
                <div id="lopeta"><h3>Lopeta</h3></div> 
            </div>
        </div>
        <script src="scripts/nav_bar.js"></script>
        <script src='scripts/stopbutton.js'></script>
    </body>
</html>