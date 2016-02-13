<?php
class ImageUpload {
    
    /**
    * @var string
    */
    private $serverpath;
    /**
    * @var string
    */
    private $urlpath;
    /**
    * @var string
    */
    private $datapath;
    /**
    * @var string
    */
    private $datadir;
    /**
    * @var string
    */
    private $urldir;
    
    /**
     * Määritetään minkä tyyppinen kuva ja mihin kohteeseen.
     * @param string  $_type Minkä tyyppistä kuvaa ollaan uppimassa.
     * @param integer $_id   Kohteen Id.
     */
    function __construct($_type, $_id){
        $this->serverpath = dirname($_SERVER['SCRIPT_FILENAME']);
        $this->urlpath    = dirname($_SERVER['SCRIPT_NAME']);
        switch($_type) {
            case "profile": {
                $this->datapath   = "/images/profile/". $_id ."/";
                break;
            }
            case "route": {
                $this->datapath   = "/images/route/" .$_id ."/";
                break;
            }
            case "crag": {
                $this->datapath   = "/images/crag/" .$_id ."/";
                break;
            }
        }
        $this->datadir = "$this->serverpath" . "$this->datapath";
        $this->urldir = "$this->urlpath" . "$this->datapath";
        $this->createDir();
    }
    
    /**
     * Palauttaa kuvan sijainnin polun.
     * @return string Polku.
     */
    public function getDatadir() {
        return $this->datadir;
    }
    
    
    /**
     * Tulostetaan kuvan upload-lomake jossa mukana kuvan polku.
     */
    public function lomake() {
        ?>
        <form id="image_upload_form" enctype="multipart/form-data" action="<?php echo ($_SERVER['PHP_SELF'])?>" method="post">
            <div class="upload"><input id="image_upload" name="filetto" type="file"></div>
            <input type="hidden" name="datadir" value="<?php echo $this->datadir;?>">
        </form>
        <?php
    }
    
    /**
     * Lisätään kuvan lataaja ja kuvan nimi ja polku Image-tauluun.
     * @param string $_filename Kuvan nimi (hashatty).
     */
    public function addImageToSQL($_filename) {
         require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "INSERT INTO Image (UploaderId, ServerLocation, FileName, Width, Height)
            VALUES (:uploaderid, :serverlocation, :filename, :width, :height)"
        );
        $stmt->execute([
            ':uploaderid' =>$_SESSION['logged_user'],
            ':serverlocation' => $this->datapath,
            ':filename' => $_filename,
            ':width' => 0,
            ':height' => 0
        ]);
        unset($db);
    }
    
    /**
     * Vaihdetaan käyttäjän profiilikuva muuttamalla liitostaulun (UserProfileImage) arvoa.
     * @param string $_filename Kuvan nimi (hashatty).
     */
    public function changeProfileImage($_filename){
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT ImageId
            FROM Image
            WHERE FileName=:filename"
        );
        $stmt->execute([
            ':filename' => $_filename
        ]);
        $imageid = $stmt->fetchColumn(0);
        $stmt = $db->prepare(
            "INSERT INTO UserProfileImage(UserId, ImageId)
            VALUES (:userid, :imageid)
            ON DUPLICATE KEY UPDATE ImageId=:imageid2"
        );
        $stmt->execute([
            ':userid' =>$_SESSION['logged_user'],
            ':imageid' =>$imageid,
            ':imageid2' =>$imageid
        ]);
        unset($db);
    }
    
    /**
     * Linkitetään ladattu kuva tietokannassa oikeaan kohteeseen.
     * Haetaan kuvan Id sen hashatyn nimen perusteella.
     * @param string  $_target   Kohteen tyyppi (user, route tai crag).
     * @param integer $_targetid Kohteen Id, jos route tai crag.
     * @param string  $_filename Kuvan nimi (hashatty).
     */
    public function linkImage($_target, $_targetid, $_filename) {
        require('/var/www/db-init-climb.php');
        $imageid= $this->getImageId($_filename);
        switch($_target){
            case 'user':{
                $stmt = $db->prepare(
                    "INSERT INTO UserImageTarget(UserId, ImageId)
                    VALUES (:userid, :imageid)"
                );
                $stmt->execute([
                    ':userid' =>$_SESSION['logged_user'],
                    ':imageid' =>$imageid
                ]);
                break;
            }
            case 'route':{
                 $stmt = $db->prepare(
                     "INSERT INTO RouteImageTarget(RouteId, ImageId)
                     VALUES (:routeid, :imageid)"
                 );
                $stmt->execute([
                    ':routeid' =>$_targetid,
                    ':imageid' =>$imageid
                ]);
                break;
            }
            case 'crag':{
                 $stmt = $db->prepare(
                     "INSERT INTO CragImageTarget(CragId, ImageId)
                     VALUES (:cragid, :imageid)"
                 );
                $stmt->execute([
                    ':cragid' =>$_targetid,
                    ':imageid' =>$imageid
                ]);
                break;
            }
        }
        unset($db);
    }    
    
    /**
     * Haetaan kuvan Id nimen perusteella.
     * @param  string  $_filename Kuvan nimi (hashatty).
     * @return integer Kuvan Id.
     */
    private function getImageId($_filename) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT ImageId
            FROM Image
            WHERE FileName=:filename"
        );
        $stmt->execute([
            ':filename' => $_filename
        ]);
        return $stmt->fetchColumn(0);
    }
    
    /**
     * Mikäli kohteella ei ole vielä kansiota, tehdään se ja määritetään oikeudet.
     */
    private function createDir() {
        if(!file_exists ($this->datadir)){
            mkdir($this->datadir, 0775);
            chown($this->datadir, 'www-data');
        }
    }
}
?>