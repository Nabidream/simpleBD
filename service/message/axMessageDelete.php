<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$messageID = $_POST['MESSAGEID'];
	$query = "DELETE FROM ReceiveMsgTBL WHERE messageID=" . $messageID ;
	$err=qsSysExecuteSQL($query);
	echo(json_encode($err));
?>