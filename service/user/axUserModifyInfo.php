<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
//var sendData = {USERID:sUser,UNAME:sName, UEMAIL:sEmail,UDESC:sDesc}; 
	$userID = $_POST['USERID'];
	$userName = $_POST['UNAME'];
	$email = $_POST['UEMAIL'];
	$desc = $_POST['UDESC'];

	$SQL = "UPDATE UsersTBL SET uNick='{$userName}',uEmail='{$email}', uDesc='{$desc}' WHERE userID='{$userID}'";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

