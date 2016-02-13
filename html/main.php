<!DOCTYPE html>
<?php
include('initclasses.php');
?>

<html>
    <head>
        <title>Climbingtime - main</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        <link type="text/css" rel="stylesheet" href="styles/normalize.css">
        <link type="text/css" rel="stylesheet" href="styles/main.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <script src="libraries/jquery-2.1.3.js"></script>
    </head>
    <body>
        <div id="container">
<?php include "navbar.php" ?>           
            <div id="content">
                <div id="tervehdys_teksti">Hei <?php echo $_SESSION['logged_user_email'] ?>, tervetuloa takaisin!</div>
                <div id="laatikot">
                    <div class="laatikko_vas" id="laatikkoVasYla">
                        <!-- Tähän appendoiaan nappulat / tekstit sisällä ja ulkona -->
                        <div class="climb_kuva"><img src="images/climbing.png" alt="climbing" /></div>
                        <p class="kuvateksti">
                            Aloita treeni
                        </p>
                    </div>
                    <div class="laatikko_oik" id="laatikkoOikYla">
                        <div class="climb_kuva"><img src="images/climbing.png" alt="climbing" /></div>
                        <p class="kuvateksti">
                            Merkitse reitti
                        </p>
                    </div>
                    <div class="laatikko_vas" id="laatikkoVasAla">
                    <a href="statistics.php?section=indoor">    <div class="climb_kuva"><img src="images/climbing.png" alt="climbing" /></div> </a>
                        <p class="kuvateksti">
                            Harjoitukset
                        </p>
                       </div>
                    <div class="laatikko_oik" id="laatikkoOikAla">
                        <div class="climb_kuva"><img src="images/climbing.png" alt="climbing" /></div>
                        <p class="kuvateksti">
                            selaa reittejä
                        </p>
                    </div>
                </div>
                <div id="statistiikka"></div>
            </div>
        </div>
        <script src="scripts/main.js"></script>
        <script src="scripts/nav_bar.js"></script>
    </body>
</html>