<!DOCTYPE html>

<?php

session_start();

if (isset($_SESSION['logged_user'])) header ('Location: main.php');

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});

if (isset($_POST['nappi']) && $_POST['email'] != null && $_POST['passwd'] != null) {
    require_once("/var/www/db-init-climb.php");
    $email = $_POST['email'];
    $passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
    $fn = $_POST['fn'] ?: '';
    $ln = $_POST['ln'] ?: '';
    $country = $_POST['country'] ?: '';
    $shoebrand = $_POST['shoebrand'] ?: '';
    $shoemodel = $_POST['shoemodel'] ?: '';
    $stmt = $db->prepare(
        "INSERT INTO User(Email, Pwd, FirstName, LastName, Country, ShoeBrand, ShoeModel) 
         VALUES(:email, :pwd, :fn, :ln, :country, :shoebrand, :shoemodel)"
    );
    if ($stmt->execute([
        ':email' => $email, 
        ':pwd' => $passwd, 
        ':fn' =>$fn, 
        ':ln' =>$ln, 
        ':country' =>$country, 
        ':shoebrand' =>$shoebrand, 
        ':shoemodel' =>$shoemodel
    ])) {
        $auth = new Auth();
        if ($auth->tryLogin($email, $_POST['passwd'])) {
            unset($auth);
            header ('Location: main.php'); //tunnus salasana oikein
        }
    }

 }
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
        <link type="text/css" rel="stylesheet" href="styles/register.css">
        <script src="libraries/jquery-2.1.3.js"></script>
        <title>
            Climbingtime register
        </title>
    </head>
    <body>
        <div class="container">
            <div id="content">
                <div class="log_in_form">
                    <div id="title"><a href='index.php'><h1>Climbing time</h1></a></div>
                    <div class="loggaus">
                        
                        <form action="register.php" method="post">
                            <ul>
                                <li><input type="text" name="email" value="<?php echo $_POST['email'] ?>" placeholder="Tunnus"></li>
                                <li><input type="password" name="passwd" placeholder="Salasana"></li>
                                <li><input type="text" name="fn" placeholder="Etunimi"></li>
                                <li><input type="text" name="ln" placeholder="Sukunimi"></li>
                                <li><input type="text" name="country" placeholder="Maa"></li>
                                <li><input type="text" name="shoebrand" placeholder="Kenkien merkki"></li>
                                <li><input type="text" name="shoemodel" placeholder="malli"></li>
                                <li><input type="submit" name="nappi" value="register"></li>
                            </ul>
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


