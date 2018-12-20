<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";

	$projectID = $_POST['WRITEID'];
	$doneRate = $_POST['RATE'];
	$title = $_POST['STITLE'];
	$content = $_POST['SCONTENT'];
	$SQL = "UPDATE ProjectTBL SET doneRate={$doneRate}, sTitle='{$title}', sContent='{$content}' WHERE projectID={$projectID}";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

