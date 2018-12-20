<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	
	$userID   = $_SESSION['LOGINID'];
	$title = strip_tags($_POST['STITLE']);
	$content = strip_tags($_POST['SCONTENT']);

	$query = "INSERT INTO PostTBL ( userID ,   sTitle  ,  sContent  ,wTime , connectIP  ,  viewCount )
	VALUES ( '$userID', '$title', '$content',	now(), '{$_SERVER['REMOTE_ADDR']}', 0)";
	$err = qsSysExecuteSQL($query);
	echo(json_encode($err));
?>