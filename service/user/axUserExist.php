<?php
	header("Content-Type: application/json");
	include_once "../../lib/qsFunc.php";
//var sendData = {USERID:sUser,UNAME:sName, UEMAIL:sEmail,UDESC:sDesc}; 
	$userID = $_POST['USERID'];

	$SQL = "SELECT Count(userID) from UsersTBL WHERE userID='{$userID}'";
	$result = qsSysSelectSQL($SQL);
	$myIndex = 0;
	$myRows= array();
	if( NULL != $result)
	{
		$row = $result->fetch();
		$myRows[] = $row[0];
		$myRows[] = "Check existing ID";
	}
	else
	{
		$myRows[] = "SQL FAIL";
	}
	echo(json_encode($myRows));
    
?>

