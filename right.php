<?php
	//데이터 베이스 연결하기
	include_once "lib/qsFunc.php";

	$rightView = "./serivcie/message/message.php";
	if( isset($_GET["rightView"]) ) 
	{
		$rightView = $_GET["rightView"];
	}
	include_once $rightView;	
?>


