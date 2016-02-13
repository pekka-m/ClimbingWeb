<div id='profile_stats_card'>
    <nav>
        <ul class='tabs'>
            <li><a href='#tab1'>Kiipeilyt</a></li>
            <li><a href='#tab2'>Fingerboardit</a></li>
            <li><a href='#tab3'>Campus</a></li>
        </ul>
    </nav>
    <div id='tab1'>
<?php
echo "Kiipeilysuorituksia sisällä: " .
    $exercise->countExercisesType($_GET['user'], 'indoor-top') . 
    "<br>";
$result = $exercise->getExercisesGrouped($_GET['user']);
$cursor = $result['result'];
foreach ($cursor as $object) {
    //näytetään ainoastaan dokumentit joissa on grade-kenttä
    if ($object['_id']) {
        echo preg_replace('/-/', '', $converter->unConvert($object['_id'])) . " " . $object['count'];
        echo "<br>";
    }
}
?>
    </div>
    <div id='tab2'>
<?php
echo "Fingerboardsuorituksia: " . $exercise->countExercisesType($_GET['user'], 'fingerboard') . "<br>";
$totalTime = $exercise->getTotalFingerboardTime($_GET['user']);
echo "Roikuttu yhteensä: " . $totalTime->format('H:i:s');
?>    
    </div>
    <div id='tab3'>
<?php
echo "Campussuorituksia: " . $exercise->countExercisesType($_GET['user'], 'campus') . "<br>";
echo "Lautoja hypitty: " . $totalSteps = $exercise->getTotalCampusSteps($_GET['user']);
?>
    </div>
</div>
<?php


//viimeisin harjoittelukerta
$row = $practice->getLastPractice($_GET['user']);
$date = strtotime($row['StartTime']);
echo "<p id='last_workout'>Viimeisin treenipäivä:<br>" . date("d.m.Y", $date) . "<br>";

//käyttäjän harjoitusten lkm
echo "Harjoituksia: " . $practice->getSummary($_GET['user']);

echo "<br>Kiipeilyjen keskiarvo: " . preg_replace('/-/', '', $exercise->getAvgGrade()) . "</p>";

//array chart.js varten
$pieChartArr = [];

//chartin osien värikoodit
$colors = [
    '#772B00',
    '#B24100',
    '#CE4B00',
    '#FF5D00'
];

//luodaan array chart.js varten
//getAllExercises() palauttaa arrayn johon on lasketty kunkin suoritystyypin lkm
$i = 0;
foreach ($exercise->getAllExercises($_GET['user']) as $type => $value) {

    //jätetään yritykset pois
    if ($type != 'indoor-attempt' && $type != 'outdoor-attempt') {
        $pieChartArr[] = [
            'value' => $value,
            'color' => $colors[$i],
            'label' => $type
        ];
        $i++;
    }
}
?>
<div id='canvas_container'>
    <h3>Suoritusjakauma:</h3>
    <canvas id='ePieChart'></canvas>
    <p id='canvas_legend'></p>
</div>

<script>
    var ctx = $('#ePieChart').get(0).getContext('2d');
    var ar = <?php echo json_encode($pieChartArr) ?>;
    var pieChart = new Chart(ctx).Pie(ar, {
        animationEasing: "easeOut",
        segmentShowStroke: true,
        segmentStrokeColor: "#1B2021",
        segmentStrokeWidth: 4,
        percentageInnerCutout: 50,
        legendTemplate: "<% for (var i=0; i<segments.length; i++){%><span style=\"color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%> <%=segments[i].value%><%}%></span><br><%}%>"
    });
    $('#canvas_legend').append(pieChart.generateLegend());
</script>