<?php
include("config.php");
echo '<meta charset="UTF-8">';
$start= array("AC"); //TODO add starting points
$mysqli = new mysqli;
$mysqli->mysqli(_DB_HOST, _DB_USER, _DB_PASS, _DB_NAME, null, null);
$mysqli->query("SET NAMES 'utf8'");
$mysqli->query('SET CHARACTER SET utf8');
if(!isset($_GET['stand'])){
	foreach($start as $s){
		echo "<a href='?stand=$s'>$s</a><br />\n";	
	}
	die();
}
$stand = $mysqli->real_escape_string($_GET['stand']);
$q=$mysqli->query("SELECT * FROM stand WHERE label='$stand'")->fetch_assoc();
echo "<b>".$q['question']."</b>";
echo "<ul>";
foreach($mysqli->query("SELECT stand.label as label,path.answer as answer FROM path INNER JOIN stand on stand.stand_id=path.to WHERE `from`='$q[stand_id]'") as $res){
	echo "<li><a href='?stand=$res[label]'> <b>$res[label]</b>: $res[answer]</a></li>";
}
	echo "</ul>";
