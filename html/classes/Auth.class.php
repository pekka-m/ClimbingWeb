<?php
session_start();

class Auth {
    
    function __construct() {
    }
    /**
     * Metodi hakee tietokannasta annetun sähköpostin sekä salasanan mukaan käyttäjän id:n, salasanan ja sähköpostin.
     * Tarkistaa onko salasana oikein, jos on niin muuttaa session user_is_logged ykköseksi(true)
     * Lataa käyttäjän userID:n sekä sähköpostin sessioneihin
     * @param  string  $_email  käyttäjän sähköposti jota yritetään kirjata sisään
     * @param  string  $_passwd käyttäjän salasana hashattuna bcryptilla jolla yritetään kirjautua sisään
     * @return integer joko yksi tai nolla; 1=käyttäjä löytyy sekä salasana oikein, kirjaudutaan sisään, 0=käyttäjää ei ole/väärä salasana ei kirjauduta sisään
     */
    public function tryLogin($_email, $_passwd) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare("SELECT UserId, Pwd, Email FROM User WHERE Email=:email");
        $stmt->execute(array(':email' => $_email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $db = NULL;
        if (password_verify($_passwd, $row['Pwd'])) {
            $_SESSION['user_is_logged'] = 1;
            $_SESSION['logged_user'] = $row['UserId'];
			$_SESSION['logged_user_email'] = $row['Email'];
            return 1;
        }
        else return 0;
    }
    /**
     * kirjaa käyttäjän ulos palvelusta. Poistaa user_islogged, logged_user, logged_user_email sessiot käytöstä.
     * Ja jos harjoittelu on käynnissä niin lopetetaan harjoittelu
     */
    public function logout() {
        unset($_SESSION['user_is_logged']);
        unset($_SESSION['logged_user']);
        unset($_SESSION['logged_user_email']);
        
		//jos harjoitus ollut käynnissä, päätetään se
		if (isset($_SESSION['practice_id'])) {
			require_once ('classes/Practice.class.php');
			$practice = new Practice();
			$practice->endp();
			$practice = NULL;
		}
    }
    /**
     * katsotaan onko käyttäjä vielä kirjautunut sisään jotta käyttäjä pääsee käyttämään palvelua/rekisteröitymättömät
     * ihmiset eivät pääse käyttämään palvelua
     * @return integer palauttaa joko 1 tai 0; 1=käyttäjä on kirjautunut sisään, jatketaan palvelun käyttöä, 0=käyttäjä ei ole kirjautunut sisään
     */
    public function requireAuth() {
        if (isset($_SESSION['user_is_logged'])) return 1;
        else return 0;
    }
}

?>