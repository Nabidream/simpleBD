<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
//	var sendData = {GRADEID:gradeID,NAME:sName,DESC:sDesc}; 
	$gradeID = $_POST['GRADEID'];
	$sName = $_POST['NAME'];
	$sDesc = $_POST['DESC'];
	$SQL = "UPDATE GradeTBL SET sName='{$sName}', sDesc='{$sDesc}' WHERE gradeID={$gradeID}";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

