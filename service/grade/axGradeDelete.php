<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$gradeID = $_POST['GRADEID'];
	$SQL = "DELETE FROM GradeTBL  WHERE gradeID={$gradeID}";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

