<!DOCTYPE html>
<?php
session_start();
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});
if (!isset($_GET['user']) && isset($_SESSION['user_is_logged'])) $_GET['user'] = $_SESSION['logged_user_email'];
if (!isset($_GET['page'])) $_GET['page'] = 'profile';

//kokeillaan onko käyttäjä olemassa
try {
    $user = new User($_GET['user']);
} catch (Exception $e) {
    header ('Location: main.php');
}
?>
<html>
    <head>
        <title>Climbingtime</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        
        <link type="text/css" rel="stylesheet" href="styles/normalize.css">
        <link type="text/css" rel="stylesheet" href="styles/main.css">
        <link type="text/css" rel=stylesheet href="styles/profile.css">
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        
        <script src="libraries/jquery-2.1.3.js"></script>
        <script src="libraries/Chart.js"></script>
    </head>
    <body>
        <div id="container">
<?php include "navbar.php"?>
            <div id="content">
                
<?php include 'profileimage.php'?>
                <ul id="links">
                    <li><a <?php if ($_GET['page'] == 'feed') echo "class='active'"; ?>href="profile.php?user=<?php echo $_GET['user']; ?>&page=feed">Kommentit</a></li>
                    <li><a <?php if ($_GET['page'] == 'profile') echo "class='active'"; ?>href="profile.php?user=<?php echo $_GET['user']; ?>&page=profile">Profiili</a></li> <!-- profiilin alle muokkaa -->
                    <li><a <?php if ($_GET['page'] == 'stats') echo "class='active'"; ?>href="profile.php?user=<?php echo $_GET['user']; ?>&page=stats">Tilasto</a></li>
                    <li><a <?php if ($_GET['page'] == 'pictures') echo "class='active'"; ?>href="profile.php?user=<?php echo $_GET['user']; ?>&page=pictures">Kuvat</a></li>
                </ul>
<?php
if (isset($_GET['user'])) {
    $practice = new Practice();
    $exercise = new Exercise();
    $converter = new Converter();
    switch($_GET['page']) {
        case "feed": {
    
            $comments = new Comment();
            if (isset($_SESSION['user_is_logged'])) echo $comments->printCommentBox($_GET['user']);
            
            //tulostetaan kaikki kommentit
            $result = $comments->getComments($_GET['user']);
            while($row = $result->fetch(PDO::FETCH_ASSOC)) { 
                $date = strtotime($row['DateTime']);
                echo "<div class='comment'>" .
                    "<a href='profile.php?user=". $comments->getCommenter($row['CommenterId']) . "'><span class='commenter'>" . $comments->getCommenter($row['CommenterId']) . ":</span></a>" .
                    "<span class='comment_text'>" . $row['Comment'] . "</span>" .
                    "<span class='comment_date'>" . date("d.m.Y", $date) . "<br>" . date("H:i:s", $date) . "</span>" .
                    "</div>";
            }
            
            //jos ollaan kirjauduttu sisään, näkyy kommentointiboxi
            break;
        }
        case "profile": {
            if (isset($_GET['edit']) && isset($_SESSION['user_is_logged'])) {
                echo $user->editForm();
            }
            else {
                echo $user->printTable();
                if ($_GET['user'] == $_SESSION['logged_user_email'])
                    echo "<a href='profile.php?user={$_SESSION["logged_user_email"]}&edit=1'>Muokkaa</a>";
            }
            $user = NULL;
            break;
        }
        case "stats": {
            include('includes/profile-stats.php');
            break;
        }
        case "pictures": {
?>
                <div class='profile_pictures'>
                    <p>Täällä on ylieeppisesti kaikki kuvat...</p>
<?php
            if ($_SESSION['logged_user_email'] == $_GET['user']) {
?>
                    <form id="gallery_image_upload_form" enctype="multipart/form-data" action="galleryimageupload.php" method="post">
                        <div class="upload">
                            <input id="gallery_image_upload" name="filetto" type="file">
                        </div>
                    </form>
<?php
            }
            $user->loadGallery($_GET['user']);
?>
                </div>
<?php
                break;
        }
        
    }
} else header ('Location: index.php');
?>
            </div>
        </div>

        <script src="scripts/main.js"></script>
        <script src="scripts/nav_bar.js"></script>
        <script src="scripts/profile.js"></script>
        
    </body>
</html>