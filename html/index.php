<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['logged_user'])) header ('Location: main.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:700' rel='stylesheet' type='text/css'>
        <link type="text/css" rel=stylesheet href="styles/normalize.css">
        <link type="text/css" rel=stylesheet href="styles/arrow_bounce.css">
        <link type="text/css" rel="stylesheet" href="styles/login.css">
        <script src="libraries/jquery-2.1.3.js"></script>
        <title>
            Climbingtime login
        </title>
    </head>
    <body>
        <div class="container">
            <div id="content">
                <div class="log_in_form">
                    <div id="title"><h1>Climbing time</h1></div>
                    <div id="logger"></div>
                    <div class="loggaus">
<?php
if ($_SESSION['error'] == "login_error") {
echo "<div id='error_msg'>Käyttäjätunnus ja/tai salasana väärin</div>";
unset($_SESSION['error']);
}
?>
                        <form id='form' method="post" action="login.php">
                            <div class="logbox">
                                <div class="emailcontent">
                                    <img id="mail" src="images/mail84.png" alt="email"/>
                                        <input class="email text_field" type="text" name="email" value=""  placeholder="email address" autocomplete="off" autofocus>
                                </div>
                                    <div class="passcontent">
                                        <img id="lock" src="images/lock26.png" alt="lock"/>
                                        <input  class="pwd text_field" type="password" name="passwd" value="" placeholder="password">
                                    </div>
                            </div>
                            <input class="login" type="submit" value="log in">
                            <input name='reg_button' id='register' class="login" type="submit" value="register">
                        </form>
                        <script src="scripts/collapse_div.js"></script>
                        <script src="scripts/expand_div.js"></script>
                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/index.js"></script>
    </body>
</html>