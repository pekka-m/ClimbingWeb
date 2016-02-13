<?php
session_start();

class Practice {
    
    function __construct() {
    }
    
    /**
     * Aloittaa harjoituksen joko sisällä tai ulkona merkkaamalla tauluun kaiken muun paitsi lopetusajan.
     * Ottaa PracticeId:n talteen sessioon jotta myöhemmin tiedetään mikä harjoitus lopetetaan.
     * @param integer $_outside 1 = ulkona, 0 = sisällä.
     */
    public function start($_outside) {
        $_SESSION['practice_start_time'] = date("Y-m-d H:i:s");
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "INSERT INTO Practice (UserId, StartTime, IsOutside)
            VALUES (:uid, :starttime, :isoutside)"
        );
        $stmt->execute([
            ':uid' => $_SESSION['logged_user'],
            ':starttime' => $_SESSION['practice_start_time'],
            ':isoutside' => $_outside
        ]);
        $stmt = $db->prepare(
            "SELECT PracticeId
            FROM Practice
            WHERE StartTime=:starttime"
        );
        $stmt->execute([
            ':starttime' => $_SESSION['practice_start_time']
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['practice_id'] = $row['PracticeId'];
        unset($db); 
    }
    
    /**
     * Lopettaa harjoituksen sessiossa olevan PracticeId:n mukaan. Merkkaa riville lopetusajan.
     * Tyhjentää PracticeId:n ja aloitusajan.
     */
    public function endp() {
        $endtime = date("Y-m-d H:i:s");
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "UPDATE Practice
            SET EndTime=:endtime
            WHERE PracticeId=:practiceid"
        );
        $stmt->execute([
            ':endtime' => $endtime,
            ':practiceid' => $_SESSION['practice_id']
        ]);
        unset($db);
        unset($_SESSION['practice_start_time']);
        unset($_SESSION['practice_id']);
    }
    
    /**
     * Palauttaa kirjautuneen käyttäjän kaikki harjoitukset.
     * @param  integer $_isOutside 1 = ulkoharjoitukset, 0 = sisäharjoitukset.
     * @return array   Käyttäjän kaikki harjoitukset annetun parametrin mukaan.
     */
    public function getPractices($_isOutside) {
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT *
            FROM Practice
            WHERE UserId=:userid AND IsOutside=:isoutside
            ORDER BY StartTime DESC");
        $stmt->execute([
            ':userid' => $_SESSION['logged_user'],
            ':isoutside' => $_isOutside
        ]);
        unset($db);
        return $stmt->fetchAll();
    }
    
    /**
     * Palauttaa yksittäisen harjoituksen tiedot Id:n perusteella.
     * @param  integer $_id Haettavan harjoituksen Id.
     * @return array   Yksittäisen harjoituksen tiedot.
     */
    public function getPractice($_id) {
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT *
            FROM Practice
            WHERE PracticeId=:id"
        );
        $stmt->execute([
            ':id' => $_id
        ]);
        unset($db);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Palauttaa käyttäjän harjoitusten lukumäärän emailin perusteella.
     * @param  string  $_user Haettavan käyttäjän email.
     * @return integer Harjoitusten lukumäärä.
     */
    public function getSummary($_user) {
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT COUNT(*)
            FROM Practice
            WHERE UserId=(
                SELECT UserId
                FROM User
                WHERE Email=:email
            )"
        );
        $stmt->execute([
            ':email' => $_user
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        unset($db);
        return $row['COUNT(*)'];
    }
    
    /**
     * Palauttaa käyttäjän viimeisimmän harjoituksen tiedot.
     * @param  string $_user Haettavan käyttäjän email.
     * @return array  Viimeisimmän harjoituksen kaikki tiedot.
     */
    public function getLastPractice($_user) {
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT *
            FROM Practice
            WHERE UserId=(
                SELECT UserId
                FROM User
                WHERE Email=:email
            )
            ORDER BY StartTime DESC
            LIMIT 1");
        $stmt->execute([
            ':email' => $_user
        ]);
        unset($db);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Tulostaa kiipeilysuorituksen lisäämislomakkeen.
     * @param  string $_type Joko 'top' = suoritus tai 'attempt' = yritys.
     * @return string Lisäämislomake.
     */
    public function printAddForm($_type) {
        if ($_type == "top") $topbutton = "Lisää toppaus";
        else $topbutton ="Lisää yritys";
           return "<form method='POST' action='addindoorexercise.php'>".
               "<select name='grade_number'>" .
               "<option value='4'>4</option>" .
               "<option value='5'>5</option>" .
               "<option value='6'>6</option>" .
               "<option value='7'>7</option>" .
               "<option value='8'>8</option>" .
               "<option value='9'>9</option>" .
               "</select>" .
               "<select name='grade_letter'>" .
               "<option value='-'></option>" .
               "<option value='A'>A</option>" .
               "<option value='B'>B</option>" .
               "<option value='C'>C</option>" .
               "</select>" .
               "<div id='".$_type."-plus'>+</div>" .
               "<input class='grade-plus' type='hidden' name='grade_plus' value='-'>" .
               "<input type='hidden' name='type' value='" . $_type . "'>" .
               "<p><input type='submit' name='nappi' value='". $topbutton ."'></p>" .
               "</form>"; 
    }
}
?>