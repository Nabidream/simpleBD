<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$userID = $_POST['USERID'];
	$query = "DELETE FROM UsersTBL WHERE userID='{$userID}'" ;
	$err=qsSysExecuteSQL($query);
	echo(json_encode($err));
?>