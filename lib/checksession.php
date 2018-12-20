<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
	if(!isset($_SESSION['LOGINID']))
	{
		echo "<script>location.href='http://kakadream.iptime.org:1180/simpleBD/main.php';</script>"; 
		exit;
	}
?>