<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";

	//var sendData = {PROJECTID:nProjectID,RATE:sRate,STARTDATE:sStartDate,ENDDATE:sEndDate,STITLE:sTitle,SCONTENT:sContent}; 
	$projectID = $_POST['PROJECTID'];
	$userID   = $_SESSION['LOGINID'];
	$doneRate = $_POST['RATE'];
	$startDate = $_POST['STARTDATE'];
	$endDate = $_POST['ENDDATE'];
	$title = $_POST['STITLE'];
	$content = $_POST['SCONTENT'];
	$SQL = "INSERT INTO IssueTBL ( projectID,  userID ,  sTitle,  sContent ,  startDate ,  endDate ,  doneRate ,  wTime,  connectIP ) values";
	$SQL = $SQL . "({$projectID},'{$userID}','{$title}', '{$content}','{$startDate}','{$endDate}',{$doneRate},now(), '{$_SERVER['REMOTE_ADDR']}')";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

