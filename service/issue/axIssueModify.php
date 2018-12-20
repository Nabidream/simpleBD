<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";

	//var sendData = {WRITEID:issueID,RATE:sRate,STARTDATE:sStartDate,ENDDATE:sEndDate,STITLE:sTitle;SCONTENT:sContent}; 
	$issueID = $_POST['WRITEID'];
	$projectID = $_POST['PROJECTID'];
	$doneRate = $_POST['RATE'];
	$startDate = $_POST['STARTDATE'];
	$endDate = $_POST['ENDDATE'];
	$title = $_POST['STITLE'];
	$content = $_POST['SCONTENT'];
	$SQL = "UPDATE IssueTBL SET projectID={$projectID},doneRate={$doneRate}, startDate='{$startDate}',endDate='{$endDate}',sTitle='{$title}', sContent='{$content}' WHERE issueID={$issueID}";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

