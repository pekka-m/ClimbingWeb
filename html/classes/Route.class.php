<?php

class Route extends Converter {
    
    private $data;
    private $cragId;
    private $routeName;
    private $routes;
    private $arrayCount;
    private $currentRoutes;
    /**
     * konstruktori hakee tietokannasta annetun reitin id:n mukaan reitin tiedot ja siihen liittyvän cragin tiedot tietokannasts
     * @param integer $_routeid halutun reitin id
     */
    function __construct($_routeid) {
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT Route.RouteId, Route.Name as RouteName, Route.Grade, Route.Description, 
            Crag.CragId, Crag.Name as CragName, Crag.Lat, Crag.Lon
            FROM Route
            INNER JOIN Crag
            ON Route.CragId=Crag.CragId
            WHERE RouteId=:routeid"
        );
        $stmt->execute(array(':routeid' => $_routeid));
        unset($db);
        $this->data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * hakee reitti datan
     * @return array palauttaa konstruktorin asettaman tiedon
     */
    public function getRoute() {
        return $this->data;
    }
    /**
     * lisää käyttäjän lisäämän reitin tietokantaan
     * @param  integer $_cragid     cragin id mihin reitti lisätään
     * @param  string  $_routename  lisättävän reitin nimi
     * @param  string  $_routegrade lisättävän reitin greidi
     * @param  string  $_routedesc  reitin selostus
     * @return integer palauttaa viimeisimmän tietokantaan laitetun rivin id:n
     */
    public function addRouteToDB($_cragid, $_routename, $_routegrade, $_routedesc){
        require("/var/www/db-init-climb.php");
        $_routegrade = parent::convert($_routegrade);
        $stmt = $db->prepare(
            "INSERT INTO Route(CragId, Name, Grade, Description) 
            VALUES(:cragid, :name, :grade, :description)"
        );
        $stmt->execute([
            ':cragid' => $_cragid, 
            ':name' =>$_routename, 
            ':grade' =>$_routegrade, 
            ':description' => $_routedesc
        ]);
        
        return $db->lastInsertId();
    }
    /**
     * palauttaa reitin kuvan tiedostopolun ja nimen
     * @param  integer $_id haettavan reitin id
     * @return string  palauttaa stringinä tiedoston polun
     */
    private function loadRoutePic($_id){
        require('/var/www/db-init-climb.php');
          $stmt = $db->prepare(
              "SELECT FileName, ServerLocation 
              FROM Image 
              INNER JOIN RouteImageTarget 
              ON Image.Imageid=RouteImageTarget.ImageId
              WHERE RouteId=:routeid
              ");
        $stmt->execute([
            ':routeid' => $_id
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row['ServerLocation']. $row['FileName'];
    }
    
    
    public function getRoutejson($_routeid){
        require('/var/www/db-init-climb.php');
        require('Comment.class.php');
        $comment = new Comment();
       $stmt = $db->prepare(
    "SELECT RouteId, Name, Grade, Description 
    FROM Route 
    WHERE RouteId=:routeid");
        $stmt->execute([':routeid' => $_routeid]);
        $data =$stmt->fetch(PDO::FETCH_ASSOC);
        $data['Grade'] =preg_replace('/-/', '', parent::unConvert($data['Grade']) );
        $muuttuja =$comment->getComments($_routeid, 'route');
        $muuttuja = $muuttuja->fetchAll();
        $data['Image'] = $this->loadRoutePic($_routeid);
        $data['Comments'] = $muuttuja;
        echo json_encode($data);
    }
    
    private function getRoutebyCragId(){
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT CragId, Name 
             FROM Route 
             ORDER BY CragId 
             ASC");
        $stmt->execute();
        $this->cragId = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $stmt->execute();
        $this->routeName = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    }
    
   
    

    
    public function printSelectRoutes($_crag){
        require('/var/www/db-init-climb.php');
        //haetaan reitin tiedot by cragid
        $stmt = $db->prepare(
                "SELECT RouteId, Name 
                 FROM Route 
                 WHERE CragId=:cragid 
                 ORDER BY RouteId ASC"
            );
         $stmt->execute([
                ':cragid' => $_crag
         ]);    
        //laitetaan reitin nimi omaan arrayy
         $routename = $stmt->fetchAll();
        // lopetetaan tietokanta yhteys
        unset($db); 
                ?>
        <select name="route" id="reitti">
            <option value="0">Routes</option>
            <?php
        // käydään foreachin avulla läpi reitit valitseman cragin perusteella
        // ja sijoitetaan ne select elementin sisälle
        foreach($routename as $route) {
            ?>
            <option value="<?php echo $route['RouteId']; ?>"><?php echo $route['Name']; ?></option>
            <?php 
        }
            ?>
        </select>
<?php
    }
}
?>