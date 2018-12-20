<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	
	$userID   = $_SESSION['LOGINID'];
	//var sendData = {RATE:doneRate,STITLE:sTitle,SCONTENT:sContent}; 
	$doneRate = $_POST['RATE'];
	$title = $_POST['STITLE'];
	$content = $_POST['SCONTENT'];
	$query = "INSERT INTO ProjectTBL (  doneRate,userID,  sTitle  ,  sContent  ,wTime , connectIP)
	VALUES ( {$doneRate},'{$userID}', '{$title}', '{$content}',	now(), '{$_SERVER['REMOTE_ADDR']}')";
	$err = qsSysExecuteSQL($query);
	echo(json_encode($err));
?>