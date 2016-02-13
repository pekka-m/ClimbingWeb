<?php

class User {
    /**
    * @var integer
    */
    private $userid;
    /**
    * @var string
    */
    private $email;
    private $nickName;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $address;
    private $country;
    private $sex;
    private $homePage;
    private $shoeBrand;
    private $shoeModel;
    private $shoeSize;
    
    /**
     * Tarkastetaan onko käyttäjä olemassa, jos on, alustetaan private-muuttujat tietokannasta saaduilla tiedoilla.
     * @param string $_user Email, jota etsitään tietokannasta.
     */
    function __construct($_user) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT *
            FROM User
            WHERE Email=:email"
        );
        $stmt->execute([
            ':email' => $_user
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) { //jos käyttäjää ei löydy
            throw new Exception();
        } else {
            $this->userid = $row['UserId'];
            $this->email = $row['Email'];
            $this->nickName = $row['NickName'];
            $this->firstName = $row['FirstName'];
            $this->lastName = $row['LastName'];
            $this->phoneNumber = $row['PhoneNumber'];
            $this->address = $row['Address'];
            $this->country = $row['Country'];
            $this->sex = $row['Sex'];
            $this->homePage = $row['HomePage'];
            $this->shoeBrand = $row['ShoeBrand'];
            $this->shoeModel = $row['ShoeModel'];
            $this->shoeSize = $row['ShoeSize'];
        }
        unset($db);
    }
    
    /**
     * Muokataan käyttäjän tietoja.
     * @param array $data Lomakkeelta saadut tiedot.
     */
    public function edit($data) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "UPDATE User 
            SET NickName=?, 
            FirstName=?, 
            LastName=?, 
            PhoneNumber=?, 
            Address=?, 
            Country=?, 
            Sex=?, 
            HomePage=?, 
            ShoeBrand=?, 
            ShoeModel=?, 
            ShoeSize=? 
            WHERE UserId=?"
        );
        $stmt->execute($data);
        unset($db);
    }
    
    /**
     * Haetaan profiilikuva tietokannasta ja tulostetaan se näytölle.
     * @param  string $_email Käyttäjän email, jonka kuva haetaan.
     * @return string img-tagi.
     */
    public function loadProfilePic($_email) {
        require('/var/www/db-init-climb.php');
          $stmt = $db->prepare(
              "SELECT FileName, ServerLocation 
              FROM Image 
              INNER JOIN UserProfileImage 
              ON Image.Imageid=UserProfileImage.ImageId
              WHERE UserId=(
                SELECT UserId
                FROM User
                WHERE Email=:email)"
          );
        $stmt->execute([
            ':email' => $_email
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return "<img id='profile_picture' src='{$row['ServerLocation']}{$row['FileName']}' alt='profile image'/>";
    }
    
    /**
     * Haetaan käyttäjän omalle profiililleen lisäämät kuvat ja tulostetaan ne näytölle.
     * @param string $_email Käyttäjän email, jonka kuvat haetaan.
     */
    public function loadGallery($_email) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT FileName, ServerLocation 
            FROM Image 
            INNER JOIN UserImageTarget 
            ON Image.Imageid=UserImageTarget.ImageId
            WHERE UserId=(
                SELECT UserId
                FROM User
                WHERE Email=:email
            )
            ORDER BY Image.ImageId DESC"
        );
        $stmt->execute([
            ':email' => $_email
        ]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<img src='" . $row['ServerLocation'] . $row['FileName'] . "' alt='gallery image' />";
        }
    }
    
    /**
     * Tulostaa 'profiilikortin' näytölle.
     * @return string Profiilikortti listana.
     */
    public function printCard() {
        return "<ul id='basic_info'>" .
            "<li>$this->email</li>" .
            "<li>$this->country</li>" .
            "<li>$this->shoeBrand</li>" .
            "<li>$this->shoeModel</li>" .
            "</ul>";
    }
    
    /**
     * Tulostaa kaikki profiilitiedot näytölle.
     * @return string Profiilitiedot taulukkona.
     */
    public function printTable() {
        return "<table>" .
            "<tr><td>Email</td><td>" . $this->email . "</td></tr>" .
            "<tr><td>Nickname</td><td>" . $this->nickName . "</td></tr>" .
            "<tr><td>Etunimi</td><td>" . $this->firstName . "</td></tr>" .
            "<tr><td>Sukunimi</td><td>" . $this->lastName . "</td></tr>" .
            "<tr><td>Puh</td><td>" . $this->phoneNumber . "</td></tr>" .
            "<tr><td>Osoite</td><td>" . $this->address . "</td></tr>" .
            "<tr><td>Maa</td><td>" . $this->country . "</td></tr>" .
            "<tr><td>Sukupuoli</td><td>" . $this->sex . "</td></tr>" .
            "<tr><td>Kotisivut</td><td>" . $this->homePage . "</td></tr>" .
            "<tr><td>Kenkien merkki</td><td>" . $this->shoeBrand . "</td></tr>" .
            "<tr><td>Kenkien malli</td><td>" . $this->shoeModel . "</td></tr>" .
            "<tr><td>Kengännumero</td><td>" . $this->shoeSize . "</td></tr>" .
            "</table>";
    }
    
    /**
     * Tulostetaan profiilinmuokkauslomake näytölle. Haetaan private-muuttujista tiedot jos on jo olemassa.
     * @return string Lomake taulukkona.
     */
    public function editForm() {
        return "<form id='editprofile' action='editprofile.php' method='POST'><table>" .
            "<tr><td>Email</td><td>" . $this->email . "</td></tr>" .
            "<tr><td>Nickname</td><td><input type='text' name='nickname' value='" . $this->nickName . "'></td></tr>" .
            "<tr><td>Etunimi</td><td><input type='text' name='firstname' value='" . $this->firstName . "'></td></tr>" .
            "<tr><td>Sukunimi</td><td><input type='text' name='lastname' value='" . $this->lastName . "'></td></tr>" .
            "<tr><td>Puh</td><td><input type='text' name='phonenumber' value='" . $this->phoneNumber . "'></td></tr>" .
            "<tr><td>Osoite</td><td><input type='text' name='address' value='" . $this->address . "'></td></tr>" .
            "<tr><td>Maa</td><td><input type='text' name='country' value='" . $this->country . "'></td></tr>" .
            "<tr><td>Sukupuoli</td><td><input type='text' name='sex' value='" . $this->sex . "'></td></tr>" .
            "<tr><td>Kotisivut</td><td><input type='text' name='homepage' value='" . $this->homePage . "'></td></tr>" .
            "<tr><td>Kenkien merkki</td><td><input type='text' name='shoebrand' value='" . $this->shoeBrand . "'></td></tr>" .
            "<tr><td>Kenkien malli</td><td><input type='text' name='shoemodel' value='" . $this->shoeModel . "'></td></tr>" .
            "<tr><td>Kengännumero</td><td><input type='text' name='shoesize' value='" . $this->shoeSize . "'></td></tr>" .
            "<tr><td><input type='submit' value='Tallenna'></td></tr>" .
            "</table></form>";
    }
}
?>