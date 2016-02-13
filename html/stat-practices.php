<?php
include('initclasses.php');
$pstats = new Practice();
$estats = new Exercise();
if ($_GET['section'] == 'outdoor') {
    $result = $pstats->getPractices(1); //tulostetaan ulkoharjoitukset
    foreach ($result as $row) {
        echo "<a class='stat-link' href='statistics.php?section=outdoor&id={$row['PracticeId']}'><div class='practice'>";
            echo "<div class='practice_date'>";
                $startTime = strtotime($row['StartTime']);
                $endTime = strtotime($row['EndTime']);
                echo date("d.m.Y", $startTime) . " klo " . date("H:i", $startTime) . " - " . date("H:i", $endTime);
            echo "</div>";
            echo "<ul>";
                echo "<li>Toppaukset: " . $estats->countExercises($row['PracticeId'], "outdoor-top") . "</li>";
                echo "<li>Yritykset: " . $estats->countExercises($row['PracticeId'], "outdoor-attempt") . "</li>";
            echo "</ul>";
        echo "</div></a>";
    }
} else {
    $result = $pstats->getPractices(0); //tulostetaan sisäharjoitukset
    foreach ($result as $row) {
        echo "<a class='stat-link' href='statistics.php?section=indoor&id={$row['PracticeId']}'><div class='practice'>";
            echo "<div class='practice_date'>";
                $startTime = strtotime($row['StartTime']);
                $endTime = strtotime($row['EndTime']);
                echo date("d.m.Y", $startTime) . " klo " . date("H:i", $startTime) . " - " . date("H:i", $endTime);
            echo "</div>";
            echo "<ul>";
                echo "<li>Toppaukset: " . $estats->countExercises($row['PracticeId'], "indoor-top") . "</li>";
                echo "<li>Yritykset: " . $estats->countExercises($row['PracticeId'], "indoor-attempt") . "</li>";
                echo "<li>Campustelut: " . $estats->countExercises($row['PracticeId'], "campus") . "</li>";
                echo "<li>Fingerboardit: " . $estats->countExercises($row['PracticeId'], "fingerboard") . "</li>";
            echo "</ul>";
        echo "</div></a>";
    }
}
?>