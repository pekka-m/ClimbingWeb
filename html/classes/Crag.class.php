<?php

class Crag{
    
    private $cragId;
    private $cragName;
    private $latlon;
    
    function __construct() {
    }
    
    /**
     * hakee kaikki cragit tietokannasta ja asettaa ne kahteen luokan private muuttujaan
     */
    public function getCragsFromDB(){
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT CragId, Name 
             FROM Crag 
             ORDER BY CragId ASC"
        );
        $stmt->execute();
        $this->cragId =$stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $stmt->execute();
        $this->cragName = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
        unset($db);
    }
    
        /**
         * lisää käyttäjän lisäämän cragin tietokantaan
         * @param  string  $_name käyttäjän antama ragin nimi joka tallennetaan tietokantaan
         * @param  string  $_lat  cragin sijainnin latitude arvo
         * @param  string  $_long cragin sijainnin longitude arvo
         * @return integer palauttaa viimeisimmän tietokantaan syötetyn rivin id:n
         */
        public function addCragToDB($_name, $_lat, $_long){
        require("/var/www/db-init-climb.php");
        $stmt = $db->prepare(
            "INSERT INTO Crag(Name, Lat, Lon) 
            VALUES(:name, :lat, :lon)"
        );
        $stmt->execute([':name' => $_name, ':lat' => $_lat, ':lon' => $_long
        ]);        
        return $db->lastInsertId();
    }
        /**
         * lataa cragin kuvan sijainnin sekä tiedostonimen tietokannasta
         * @param  integer $_id cragin id jonka kuvan polku halutaan ladata
         * @return string  palauttaa kuvan polun ja tiedostonimen stringinä
         */
        private function loadCragPic($_id){
        require('/var/www/db-init-climb.php');
          $stmt = $db->prepare(
              "SELECT FileName, ServerLocation 
              FROM Image 
              INNER JOIN CragImageTarget 
              ON Image.Imageid=CragImageTarget.ImageId
              WHERE CragId=:cragid
              ");
        $stmt->execute([
            ':cragid' => $_id
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row['ServerLocation']. $row['FileName'];
    }
    /**
     * hakee tietokannasta kaikki cragit mitä nykyisen viewportin sisällä näkyy
     * parametreina annetaan metodille google mapsin viewportin koordinaatti bounds
     * @param string $_latupperbound  lat ylempi raja
     * @param string $_latlowerbound  lat alempi raja
     * @param string $_longupperbound longitude ylempi raja
     * @param string $_longlowerbound longitude alempi raja
     */
    public function getCragsViewportJson($_latupperbound, $_latlowerbound, $_longupperbound, $_longlowerbound){
        require('/var/www/db-init-climb.php');
        $stmt= $db->prepare(
            "SELECT CragId, Name , Lat, Lon
             FROM Crag
             WHERE
             (Lat BETWEEN :latlowerbound AND :latupperbound)
             AND
             (Lon BETWEEN :longlowerbound AND :longupperbound)
             ");
        $stmt->execute([
            ':latlowerbound' => $_latlowerbound,
            ':latupperbound' => $_latupperbound,
            ':longlowerbound' => $_longlowerbound,
            ':longupperbound' => $_longupperbound
        ]);
        $result = $stmt->fetchAll();
        return json_encode($result);
    }
    
    
    
    
    /**
     * hakee haettavan cragin cragId:n crag taulusta sekä cragiin liittyvät kommentit annetun cragid:n mukaan
     * @param  integer $_cragid haettavan cragin cragId
     * @return array   palauttaa kaiken datan json enkoodattuna ajax kutsua varten
     */
    public function getCragJson($_cragid){
        require('/var/www/db-init-climb.php');
        require('Comment.class.php');
        $comment = new Comment();
        $stmt = $db->prepare(
            "SELECT CragId, Name 
             FROM Crag
             WHERE CragId=:cragid"
        );
        $stmt->execute([
            ':cragid' => $_cragid
        ]);
        $data =$stmt->fetch(PDO::FETCH_ASSOC);
        $muuttuja =$comment->getComments($_cragid, 'crag');
        $muuttuja = $muuttuja->fetchAll();
        $data['Image'] = $this->loadCragPic($_cragid);
        $data['Comments'] = $muuttuja;
        return json_encode($data);
    }
    /**
     * hakee haettavan cragin sijainnin sekä cragid:n crag taulusta
     * @param integer $_cragId haettavan cragin cragid
     */
    public function getCragcoordJson($_cragId){
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT CragId, Lat, Lon 
             FROM Crag 
             WHERE CragId=:cragid"
        );
        $stmt->execute([
            ':cragid' => $_cragId
        ]);
        $this->latlon =$stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($this->latlon);
    }
               
    /**
     * tulostaa select-listan kaikista crageista jossa value=cragid ja nimi on cragin nimi
     */
    public function printCragList(){
        $ArrayCount = count($this->cragName);
        for ($i = 0; $i < $ArrayCount; $i++) {
            echo "<option value='{$this->cragId[$i]}'>{$this->cragName[$i]}</option>";
        }
    }   
}
?>