<?php
include('initclasses.php');

$id = $_GET['id']; //mistä harjoituksesta näytetään
$pstat = new Practice();
$estats = new Exercise();
$converter = new Converter();
$pstat = $pstat->getPractice($id);

echo "<h3>";
$startTime = strtotime($pstat['StartTime']);
$endTime = strtotime($pstat['EndTime']);
echo date("d.m.Y", $startTime) . " klo " . date("H:i", $startTime) . " - " . date("H:i", $endTime);
echo "</h3>";
echo "<h3>Toppaukset</h3>";

//ollaan valittu ulkoharjoitus
if ($pstat['IsOutside']) {
    $cursor = $estats->getExercises($id, "outdoor-top");
    foreach ($cursor as $object) {
        $route = new Route($object['RouteId']);
        $routeRow = $route->getRoute();
        echo "<div class='practice'>";
        echo "Crag: <a href='showcrag.php?cid={$routeRow['CragId']}'>" . $routeRow['CragName'] . "</a><br>";
        echo "Reitti: " . $routeRow['RouteName'] . "<br>";
        echo "Grade: " . preg_replace('/-/', '', $converter->unConvert($estats->getRouteGrade($object['RouteId'])));
        echo "</div>";
    }
    unset($route);
    unset($routeRow);
}

//valittu sisäharjoitus
else {
    $cursor = $estats->getExercises($id, "indoor-top");
    foreach ($cursor as $object) {
        $route = new Route($object['RouteId']);
        $routeRow = $route->getRoute();
        echo "<div class='practice'>";
        echo "Grade: " . preg_replace('/-/', '', $converter->unConvert($object['Grade']));
        echo "</div>";
    }
}

echo "<h3>Yritykset</h3>";

//ollaan valittu ulkoharjoitus
if ($pstat['IsOutside']) {
    $cursor = $estats->getExercises($id, "outdoor-attempt");
    foreach ($cursor as $object) {
        $route = new Route($object['RouteId']);
        $routeRow = $route->getRoute();
        echo "<div class='practice'>";
        echo "Crag: <a href='showcrag.php?cid={$routeRow['CragId']}'>" . $routeRow['CragName'] . "</a><br>";
        echo "Reitti: " . $routeRow['RouteName'] . "<br>";
        echo "Grade: " . preg_replace('/-/', '', $converter->unConvert($estats->getRouteGrade($object['RouteId'])));
        echo "</div>";
    }
    unset($route);
    unset($routeRow);
}

//valittu sisäharjoitus
else {
    $cursor = $estats->getExercises($id, "indoor-attempt");
    foreach ($cursor as $object) {
        echo "<div class='practice'>";
        echo "Grade: " . preg_replace('/-/', '', $converter->unConvert($object['Grade']));
        echo "</div>";
    }
}

//näytetään campukset ja fingerit ainoastaan sisäharjoituksissa
if (!$pstat['IsOutside']) {
    echo "<h3>Campus</h3>";
    $cursor = $estats->getExercises($id, "campus");
    foreach ($cursor as $object) {
        echo "<div class='practice'>";
        echo "Askeleet: " . $object['Steps'];
        echo "</div>";
    }

    echo "<h3>Fingerboard</h3>";
    $cursor = $estats->getExercises($id, "fingerboard");
    foreach ($cursor as $object) {
        $startTime = new DateTime($object['DateTime']);
        $time = $startTime->diff(new DateTime($object['EndTime']));
        echo "<div class='practice'>";
        echo "Aika: " . $time->format('%I:%S');
        echo "</div>";
    }
}
?>