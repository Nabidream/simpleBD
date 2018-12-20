<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	
	$userID   = $_SESSION['LOGINID'];
	//var sendData = {RATIO:doneRatio,STITLE:sTitle,SCONTENT:sContent}; 
	$doneRatio = $_POST['RATIO'];
	$title = $_POST['STITLE'];
	$content = $_POST['SCONTENT'];
	$query = "INSERT INTO ProjectTBL (  doneRatio,userID,  sTitle  ,  sContent  ,wTime , connectIP)
	VALUES ( {$doneRatio},'{$userID}', '{$title}', '{$content}',	now(), '{$_SERVER['REMOTE_ADDR']}')";
	$err = qsSysExecuteSQL($query);
	echo(json_encode($err));
?>