<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
	$postID = $_POST['POSTID'];
	$query = "DELETE FROM PostTBL WHERE postID=" . $postID ;
	$err=qsSysExecuteSQL($query);
	echo(json_encode($err));
?>