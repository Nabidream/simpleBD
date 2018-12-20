<?php
	header("Content-Type: application/json");
	
//	include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/qsFunc.php";
	include_once "../../lib/qsFunc.php";

	$userID   = $_SESSION['LOGINID'];

	
	$toUser = $_POST['TOUSER'];
	$title = $_POST['STITLE'];
	
	$content = $_POST['SCONTENT'];


	$query = "insert into ReceiveMsgTBL (isRead,fromUser,toUser,sTitle,sContent,wTime,connectIP) values ";
    $query = $query .	" (0, '{$userID}',  '{$toUser}', '{$title}', '{$content}',now(),'127.0.0.1')";
	$err = qsSysExecuteSQL($query);
	if("OK" == $err)
	{
		$query = "insert into SendMsgTBL (isRead,fromUser,toUser,sTitle,sContent,wTime,connectIP) values ";
		$query = $query .	" (0, '{$userID}',  '{$toUser}', '{$title}', '{$content}',now(),'127.0.0.1')";
		$err = qsSysExecuteSQL($query);
	}
	echo(json_encode($err));
	
?>