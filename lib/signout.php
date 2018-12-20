<?php
	include 'qsFunc.php';
	$user_id = $_SESSION["LOGINID"];
	$sql = "DELETE FROM SessionTBL WHERE USER_ID = '{$user_id}'";
	$ret = qsSysExecuteSQL( $sql );
	unset($_SESSION["LOGINID"]);
	setcookie( session_name(), '', time()-99999999 );
	session_destroy();
?>
<meta http-equiv='refresh' content="0;url='http://kakadream.iptime.org:1180/simpleBD/main.php'">
