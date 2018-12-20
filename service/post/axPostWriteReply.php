<?php
	//데이터 베이스 연결하기
	include_once "../../lib/qsFunc.php";
	//패스워드 암호화 작업
	
	$postID    = $_POST['POSTID'];
	$replyID   = $_POST['REPLYID'];
	$userID    = $_SESSION['LOGINID'];
	$content   = $_POST['CONTENT'];
//	var sendData = {POSTID:postID,REPLYID:replyID,CONTENT:sTemp}; 	
	$query = "INSERT INTO ReplyTBL ( userID,postID,rereplyID,sContent ,wTime,connectIP )
	VALUES ( '$userID', '$postID', $replyID , '$content', now(), '{$_SERVER['REMOTE_ADDR']}')";
	$err = qsSysExecuteSQL($query);
	echo(json_encode($err));
?>