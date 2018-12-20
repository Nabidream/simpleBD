<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";

	$postID = $_POST['WRITEID'];
	$title = $_POST['STITLE'];
	$content = $_POST['SCONTENT'];
	$SQL = "UPDATE PostTBL SET sTitle='$title', sContent='$content' WHERE postID=$postID";
	$err= qsSysExecuteSQL($SQL);
	echo(json_encode($err));
?>

