<?php
	//데이터 베이스 연결하기
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";

	$replyID =  $_POST['REPLYID'];
	$content = strip_tags($_POST['CONTENT']);
	
	$query = "UPDATE  ReplyTBL SET  sContent = '$content' WHERE replyID=$replyID";
	$err = qsSysExecuteSQL($query);
	echo(json_encode($err));
?>
