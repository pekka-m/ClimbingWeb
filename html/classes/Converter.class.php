<?php
class Converter {
    
    private $grades = [
        0 => ['4A-', '4--', '4-+', '4A+'],
        1 => ['4B-', '4B+'],
        2 => ['4C-', '4C+'], 
        3 => ['5A-', '5--', '5-+', '5A+'],
        4 => ['5B-', '5B+'],
        5 => ['5C-', '5C+'],
        6 => ['6A-', '6--', '6-+'],
        7 => '6A+',
        8 => '6B-',
        9 => '6B+',
        10 => '6C-',
        11 => '6C+',
        12 => ['7A-', '7--', '7-+'],
        13 => '7A+',
        14 => '7B-',
        15 => '7B+',
        16 => '7C-',
        17 => '7C+',
        18 => ['8A-', '8--', '8-+'],
        19 => '8A+',
        20 => '8B-',
        21 => '8B+',
        22 => '8C-',
        23 => '8C+',
        24 => ['9A-', '9--', '9-+'],
        25 => '9A+',
        26 => '9B-',
        27 => '9B+',
        28 => '9C-',
        29 => '9C+'
    ];
    
    function __construct() {
    }
    
    /**
     * muuntaa greidin numeroksi tietokantaan tallennusta varten
     * @param  string  $_grade annettu greidi string muodossa
     * @return integer palautetaan annettu greidin inttinä tietokantaan tallennusta varten
     */
    public function convert($_grade) {
        foreach ($this->grades as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $innerValue) {
                    if ($innerValue == $_grade) return $key;
                }
            } else {
                if ($value == $_grade) return $key;
            }
        }
    }
    
    //muuntaa numeron greidiksi
    /**
     * muuntaa numeron greidiksi käyttäjälle näytettävään muotoon
     * @param  integer $_grade greidi numeromuodossa
     * @return string  palauttaa annetun greidin string muodossa
     */
    public function unConvert($_grade) {
         foreach ($this->grades as $key => $value) {
            if ($key == $_grade) {
                if (is_array($value)) return $value[0];
                else return $value;
            }
        }
    }
    
}
?>