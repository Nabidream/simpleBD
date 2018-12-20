<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
//	var sendData = {GRADEID:gradeID,NAME:sName,DESC:sDesc}; 
	$sName = $_POST['NAME'];
	$sDesc = $_POST['DESC'];
	$SQL = "INSERT INTO GradeTBL (sName,sDesc) VALUES ('{$sName}','{$sDesc}')";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

