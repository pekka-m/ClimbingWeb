<style>
td {
	border: 1px solid black;
	padding: 1px 2px;
}
</style>
<?php
$m = new MongoClient();
$db = $m->climbmongo;
$collection = $db->Exercise;
$cursor = $collection->find()->sort(array('_id' => 1));
print_r($cursor);
echo "<table>";
	echo "<tr>";
	echo "<th>_id</th><th>UserId</th><th>Type</th><th>PracticeId</th><th>Grade</th><th>RouteId</th><th>Steps</th><th>DateTime</th><th>EndTime</th>";
	echo "</tr>";
foreach ($cursor as $object) {
	echo "<tr>";
	echo "<td>" . $object['_id'] . "</td><td>" . $object['UserId'] . "</td><td>" . $object['Type'] . "</td><td>" . $object['PracticeId'] . "</td><td>" . $object['Grade'] . "</td><td>" . $object['RouteId'] . "</td><td>" . $object['Steps'] . "</td><td>" . $object['DateTime'] . "</td><td>" . $object['EndTime'] . "</td>";
	echo "</tr>";
}
echo "</table>";
?>