<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$projectID = $_POST['PROJECTID'];
	$query = "DELETE FROM ProjectTBL WHERE projectID=" . $projectID ;
	$err=qsSysExecuteSQL($query);
	echo(json_encode($err));
?>