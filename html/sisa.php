<!DOCTYPE html>
<?php
include('initclasses.php');
$practice = new Practice();
if (!isset($_SESSION['practice_start_time'])) {
    $practice->start(0); //parametri: 1=ulkona, 0=sisällä
}
?>
<html>
    <head>
        <title>Climbingtime - sisäharjoittelu</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        <link type="text/css" rel="stylesheet" href="styles/normalize.css">
        <link type="text/css" rel="stylesheet" href="styles/main.css">
        <link type="text/css" rel="stylesheet" href="styles/sisa.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <script src="libraries/jquery-2.1.3.js"></script>
    </head>
    <body>
        <div id="container">
<?php include "navbar.php" ?>
            <div id="content">
                <div id="toppaus">
                    <h3>Toppaus</h3>
<?php echo $practice->printAddForm('top'); ?>
                </div>
                <div id="yritys">
                    <h3>Yritys</h3>
<?php echo $practice->printAddForm('attempt'); ?>
                </div>
                <div id="laatikot">
                    <div class="laatikko_vas" id="laatikkoVasYla">
                        <p>Otelauta</p>
                        <div id="aloita_otelauta">
<?php
if (isset($_SESSION['fingerboard_id'])) echo "lopeta";
else echo "aloita";
?>
                        </div>
						<div id="startTimer"><?php if(isset($_SESSION['fingerboard_id'])) echo 1; ?></div>
                    </div>
                    <div class="laatikko_oik" id="laatikkoOikYla">
                        <p>Campus</p>
                        <div id="merkkaa_campus">merkkaa</div>
                        <div id="campus_tiedot">
                            <form id="campus_form" method="POST" action="addcampusexercise.php">
                                <input type="text" name="steps" placeholder="askeleet">
                            </form>
                        </div>
                    </div>
                </div>
                <div id="lopeta"><h3>Lopeta</h3></div>
            </div>
        </div>
        <script src="scripts/sisa.js"></script>
        <script src="scripts/nav_bar.js"></script>
    </body>
</html>