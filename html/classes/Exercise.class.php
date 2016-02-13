<?php
session_start();

class Exercise extends Converter {
	
	private $m;
	private $db;
	private $collection;
	private $cursor;
	
	/**
	 * Luodaan uusi MongoClient-olio, joka yhdistetään localhostiin.
	 * Otetaan yhteys climbmongo-tietokannan Exercise-collectioniin.
	 * Sijoitetaan cursoriin suurin Id.
	 */
	function __construct() {
		$this->m = new MongoClient();
		$this->db = $this->m->climbmongo;
		$this->collection = $this->db->Exercise;
		$this->cursor = $this->collection->find([], ['_id' => 1])->sort(['_id' => -1])->limit(1);
	}
    
    /**
     * Lisätään uusi ulkokiipeilysuoritus käyttämällä cursorissa olevaa suurinta Id:tä.
     * @param string  $_type    Suoritus (outdoor-top) tai yritys (outdoor-attempt).
     * @param integer $_routeid Reitin Id joka suoritettiin.
     */
    public function addOutdoorExercise($_type, $_routeid){
		foreach ($this->cursor as $largestExerciseId) {
			$largestExerciseId['_id']++;
			$this->collection->insert([
                '_id' => $largestExerciseId['_id'],
                'UserId' => $_SESSION['logged_user'],
                'Type' => $_type,
                'PracticeId' => $_SESSION['practice_id'],
                'RouteId' => $_routeid,
                'DateTime' => date("Y-m-d H:i:s")
            ]);
		}
        
    }
	
	/**
	 * Lisätään uusi sisäkiipeilysuoritus käyttämällä cursorissa olevaa suurinta Id:tä.
	 * @param string  $_type  Suoritus (indoor-top) tai yritys (indoor-attempt).
	 * @param integer $_grade Reitin grade.
	 */
	public function addIndoorExercise($_type, $_grade) {
		foreach ($this->cursor as $largestExerciseId) {
			$largestExerciseId['_id']++;
			$this->collection->insert([
                '_id' => $largestExerciseId['_id'],
                'UserId' => $_SESSION['logged_user'],
                'Type' => $_type,
                'PracticeId' => $_SESSION['practice_id'],
                'Grade' => $_grade,
                'DateTime' => date("Y-m-d H:i:s")
            ]);
		}
	}
	
	/**
	 * Lisätään campus-suoritus.
	 * @param integer $_steps Askelten määrä.
	 */
	public function addCampusExercise($_steps) {
		foreach ($this->cursor as $largestExerciseId) {
			$largestExerciseId['_id']++;
			$this->collection->insert([
                '_id' => $largestExerciseId['_id'],
                'UserId' => $_SESSION['logged_user'],
                'Type' => 'campus',
                'PracticeId' => $_SESSION['practice_id'],
                'Steps' => $_steps,
                'DateTime' => date("Y-m-d H:i:s")
            ]);
		}
	}
	
	/**
	 * Aloitetaan fingerboard-roikkuminen. Merkataan collectioniin alkamisaika. Otetaan Id talteen jotta tiedetään mikä lopetetaan.
	 */
	public function startFingerboard() {
		foreach ($this->cursor as $largestExerciseId) {
			$largestExerciseId['_id']++;
			$_SESSION['fingerboard_id'] = $largestExerciseId['_id'];
			$this->collection->insert(array(
                '_id' => $largestExerciseId['_id'],
                'UserId' => $_SESSION['logged_user'],
                'Type' => 'fingerboard',
                'PracticeId' => $_SESSION['practice_id'],
                'DateTime' => date("Y-m-d H:i:s")
            ));
		}
	}
	
	/**
	 * Lopetetaan fingerboard-roikkuminen merkkaamalla lopetusaika sessiossa olevan Id:n perusteella.
	 */
	public function endFingerboard() {
		$this->collection->update(array('_id' => $_SESSION['fingerboard_id']),
		array('$set' => array('EndTime' => date("Y-m-d H:i:s"))));
		unset($_SESSION['fingerboard_id']);
	}
	
	/**
	 * Haetaan käyttäjän kaikki tietyntyyppiset suoritukset tietyltä harjoituskerralta
	 * @param  integer $_practiceId Minkä harjoituksen suoritukset haetaan.
	 * @param  string  $_type       Minkä tyyppiset suoritukset haetaan.
	 * @return array   Suoritukset.
	 */
	public function getExercises($_practiceId, $_type) {
        return $this->collection->find(['UserId' => $_SESSION['logged_user'], 'PracticeId' => $_practiceId, 'Type' => $_type]);
    }
    
    /**
     * Lasketaan käyttäjän kaikkien tietyntyyppisten suoritusten lukumäärä tietyltä harjoituskerralta.
     * @param  integer $_practiceId Minkä harjoitukset suoritukset lasketaan.
     * @param  string  $_type       Minkä tyyppiset suoritukset lasketaan.
     * @return integer Suoritusten lukumäärä.
     */
    public function countExercises($_practiceId, $_type) {
        return $this->collection->find(['UserId' => $_SESSION['logged_user'], 'PracticeId' => $_practiceId, 'Type' => $_type])->count();
    }
    
    /**
     * Lasketaan käyttäjän kunkin suoritustyypin lukumäärä.
     * @param  string $_user Haettavan käyttäjän email.
     * @return array  Suoritustyyppien lukumäärät ([tyyppi] => lukumäärä).
     */
    public function getAllExercises($_user) {
        $cursor = $this->collection->find([
            'UserId' => $this->getUserId($_user)
        ]);
        foreach ($cursor as $object) {
            $types[$object['Type']]++;
        }
        arsort($types); //järjestetään lukumäärän mukaan suurimmasta pienimpään
        return $types;
    }
    
    /**
     * Lasketaan käyttäjän yksittäisen suoritustyypin suoritusten lukumäärä.
     * @param  string  $_user Haettavan käyttäjän email.
     * @param  string  $_type Laskettavien suoritusten tyyppi.
     * @return integer Suoritusten lukumäärä.
     */
    public function countExercisesType($_user, $_type) {
        return $this->collection->find(['UserId' => $this->getUserId($_user), 'Type' => $_type])->count();
    }
    
    /**
     * Laskee kaikkien kiipeilysuoritusten keskiarvograden (Sisä ja ulko).
     * @return string Keskiarvograde.
     */
    public function getAvgGrade() {
        $sum = 0;
        $count = 0;
        $cursor = $this->collection->find(['UserId' => $_SESSION['logged_user'], 'Type' => 'indoor-top']);
        foreach ($cursor as $object) {
            $sum += $object['Grade'];
            $count++;
        }
        $cursor = $this->collection->find(['UserId' => $_SESSION['logged_user'], 'Type' => 'outdoor-top']);
        foreach ($cursor as $object) {
            $sum += $this->getRouteGrade($object['RouteId']);
            $count++;
        }
        return parent::unConvert(round($sum / $count));
    }
    
    /**
     * Palauttaa reitin graden numeerisena.
     * @param  integer $_routeid Haettavan reitin Id.
     * @return integer Reitin grade.
     */
    public function getRouteGrade($_routeid) {
        require ('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
            "SELECT Grade
            FROM Route
            WHERE RouteId=:routeid"
        );
        $stmt->execute([
            ':routeid' => $_routeid
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        unset($db);
        return $row['Grade'];
    }
    
    /**
     * Palauttaa kunkin suoritetun graden lukumäärän käyttäjältä.
     * @param  string $_user Haettavan käyttäjän email.
     * @return array  Lukumäärät.
     */
    public function getExercisesGrouped($_user) {
        return $this->collection->aggregate(
            [
                '$match' => ['UserId' => $this->getUserId($_user)],
            ],
            [
                '$group' => [
                    '_id' => '$Grade',
                    'count' => ['$sum' => 1]
                ]
            ]
        );
        // Vertaa SQL:
        // SELECT Grade, COUNT(*) AS count
        // FROM Exercise
        // WHERE UserId=:userid
        // GROUP BY Grade
    }
    
    /**
     * Palauttaa käyttäjän fingerboard-roikkumisen kokonaisajan.
     * @param  string   $_user Haettavan käyttäjän email.
     * @return DateTime Kokonaisaika.
     */
    public function getTotalFingerboardTime($_user) {
        $cursor = $this->collection->find(array('UserId' => $this->getUserId($_user), 'Type' => 'fingerboard'));
        $totalTime = new DateTime('0000-00-00 00:00:00');
        foreach ($cursor as $object) {
            $startTime = new DateTime($object['DateTime']);
            $time = $startTime->diff(new DateTime($object['EndTime']));
            $time = $startTime->diff(new DateTime($object['EndTime']));
            $totalTime->add(new DateInterval('PT'.$time->format('%H').'H'.$time->format('%I').'M'.$time->format('%S').'S'));
        }
        return $totalTime;
    }
    
    /**
     * Palauttaa käyttäjän campus-suoritusten askelten kokonaismäärän.
     * @param  string  $_user Haettavan käyttäjän email.
     * @return integer Askelten kokonaismäärä.
     */
    public function getTotalCampusSteps($_user) {
        $cursor = $this->collection->find(array('UserId' => $this->getUserId($_user), 'Type' => 'campus'));
        $totalSteps = 0;
        foreach ($cursor as $object) {
            $totalSteps += $object['Steps'];
        }
        return $totalSteps;
    }
    
    /**
     * Palauttaa UserId:n emailin perusteella.
     * @param  string  $_user Haettavan käyttäjän email.
     * @return integer Käyttäjän UserId.
     */
    private function getUserId($_user) {
        require('/var/www/db-init-climb.php');
        $stmt = $db->prepare(
              "SELECT UserId
              FROM User
              WHERE Email=:email"
        );
        $stmt->execute([
            ':email' => $_user
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        unset($db);
        return $row['UserId'];
    }
}
?>