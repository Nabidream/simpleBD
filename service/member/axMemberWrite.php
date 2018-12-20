<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$userID   = $_POST['USERID'];
	$userNick = $_POST['UNICK'];
	$userEmail = $_POST['UEMAIL'];
	$userDesc = $_POST['UDESC'];
	$userPW = $_POST['UPW'];

	$query = "INSERT INTO UsersTBL VALUES (2 , '{$userID}'  , HEX(AES_ENCRYPT('{$userPW}', '{$userPW}')), '{$userNick}'  ,'{$userEmail}' , '{$userDesc}')";
	$err = qsSysExecuteSQL($query);
	echo(json_encode($err));
?>