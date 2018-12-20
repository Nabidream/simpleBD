<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$method = $_SERVER['REQUEST_METHOD'];
	// 1. 자바스크립트 객체 또는 serialize() 로 전달
	$replyID = $_POST['deleteID'];
	$query = "DELETE FROM ReplyTBL WHERE replyID=$replyID";
	$err = qsSysExecuteSQL($query);
	if( "OK" == $err)
	{
		$query = "DELETE FROM ReplyTBL WHERE rereplyID =$replyID";
		$err = qsSysExecuteSQL($query);
	}
	echo(json_encode($err));
?>



