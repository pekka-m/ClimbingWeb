<?php
// this ajax file will get all the crags from the database that are inside the viewport
// of the current google maps view
// the given parameters are the bounds where to find 
// all the crags in that area


// maybe work in done, comment this section later 15.5.2015

// at least need  to make function later to check if the old and new list of crags contains same things in 
// order to delete the ones that aren't visible anymore and load new ones
// without loading every point again
// saves processing power I think.


spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});
$crag = new Crag();
$latupperbound     =  $_GET['latupperbound'];
$latlowerbound     =  $_GET['latlowerbound'];
$longupperbound    =  $_GET['longupperbound']; 
$longlowerbound    =  $_GET['longlowerbound'];

echo $crag->getCragsViewportJson($latupperbound, $latlowerbound, $longupperbound, $longlowerbound);
?>