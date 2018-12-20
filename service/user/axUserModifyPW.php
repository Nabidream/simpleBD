<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
//	var sendData = {USERID:sUser, PASSWORD:sPW}; 
	$userID = $_POST['USERID'];
	$pw = $_POST['PASSWORD'];
	$SQL = "UPDATE UsersTBL SET uPW=HEX(AES_ENCRYPT('{$pw}', '{$pw}')) WHERE userID='{$userID}'";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

