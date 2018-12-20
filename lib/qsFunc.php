<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
	//------------------------------------------------------------------------
	function qsAlert($sMsg)
	{
		
		echo '<script>alert("' . $sMsg . '")</script>';
	}
	//------------------------------------------------------------------------
	function qsGoBack()
	{
		
		echo  '<script> history.back();</script>';
	}
	//------------------------------------------------------------------------
	function qsCheckedStr($bCheck)
	{
		if(true == $bCheck)
		{
			echo "checked";
		}
	}
	//------------------------------------------------------------------------
	function qsSetVar($sKey, $sValue)
	{
		echo '<script> sessionStorage.setItem("' . $sKey . '","' . $sValue . '") </script>'; 
	}
	
	function qsGetVar($sKey)
	{
		echo '<script> sessionStorage.setItem("' . $sKey . '","' . $sValue . '") </script>'; 
	}
	
	/**
		@brief DB얻기.
	*/
	function qsGetSystemDB()
	{
		$link = null;
		try 
		{
			$username="simpleuser";
			$password="simpleuser##!!";
			$host="localhost";
			$db="simpleBD";
			$link = new PDO("mysql:dbname=$db;host=$host", $username, $password);
			$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$link->exec("set names utf8"); 
		} 
		catch(PDOException $e) 
		{ 
			echo $e->getMessage(); 
			$link = null;
		}
		return $link;
	}
	
	// System Execute SQL문 실행.
	function qsSysExecuteSQL($sSQL)
	{
		try
		{
			$userlink = qsGetSystemDB();
			$userlink->exec($sSQL);
			return 'OK';
		}
		catch(PDOException $e) 
		{ 
			return  $e->getMessage(); 
		}
	}

	// System Select 문 실행.
	function qsSysSelectSQL($sSQL)
	{
		try
		{
			$userlink = qsGetSystemDB();
			$result = $userlink->query($sSQL);
			return $result;
		}
		catch(PDOException $e) 
		{ 
			//echo $userDB = qsGetDbDir() . qsGetUserName() .'.db';
			echo $e->getMessage(); 
			return null;
		}
	}
	//------------------------------------------------------------------------
	/**
		@brief 로그인 체크.
	*/
	function qsSelectLogin($sID, $sPW, &$sNick)
	{
		$link = qsGetSystemDB();
		$sql="select USER_ID,USER_PWD,USER_NICK from UsersTBL where USER_ID = '$sID' and USER_PWD = '$sPW' "; 
		$result = $link->query($sql) or die("SQL 에러");
		$row  = $result->fetch();
		if ( $row != null ) 
		{
			$sNick = $row["USER_NICK"]; 
			$link = null;
			return true;
		}
		else
		{
			$link = null;
			return false;
		}
	}
	//------------------------------------------------------------------------
	function qsCheckUserDir()
	{
		if(!isset($_SESSION['nickname']))
		{
			exit;
		}
		$User = $_SESSION['nickname'];
		$BaseDir = $_SERVER["DOCUMENT_ROOT"] . "/users/" . $User . "/";
		$dbDir  = $BaseDir . "db";
		$excelDir = $BaseDir . "excel";
		$tempDir = $BaseDir . "temp";
		$uploadDir = $BaseDir . "upload";
		if( !is_dir($dbDir))
		{
			mkdir($dbDir,0777,true);
		}

		if( !is_dir($excelDir))
		{
			mkdir($excelDir,0777,true);
		}
		if( !is_dir($tempDir))
		{
			mkdir($tempDir,0777,true);
		}
	
		if( !is_dir($uploadDir))
		{
			mkdir($uploadDir,0777,true);
		}
	}
	function qsGetUserName()
	{
		if(!isset($_SESSION['nickname']))
		{
			return "";
		}
		else
		{
			return $_SESSION['nickname'];
		}

	}

	function qsGetDbDir()
	{
		if(!isset($_SESSION['nickname']))
		{
			echo("Check User");
			return "";
		}
		$User = $_SESSION['nickname'];
		$sDir = $_SERVER["DOCUMENT_ROOT"] . "/users/" . $User . "/db/";
		return $sDir;
	}
	
	function qsGetExcelDir()
	{
		if(!isset($_SESSION['nickname']))
		{
			echo("Check User");
			return "";
		}
		$User = $_SESSION['nickname'];
		$sDir =  $_SERVER["DOCUMENT_ROOT"] . "/users/" . $User . "/excel/";
		return $sDir;
	}
	function qsGetTempDir()
	{
		if(!isset($_SESSION['nickname']))
		{
			echo("Check User");
			return "";
		}
		$User = $_SESSION['nickname'];
		$sDir =  $_SERVER["DOCUMENT_ROOT"] . "/users/" . $User . "/temp/";
		return $sDir;
	}

	//------------------------------------------------------------------------
	function qsCheckUserDB()
	{
		$userlink = null;
		try 
		{ 
			$userDB = qsGetDbDir() . qsGetUserName() .'.db';
			//qsAlert($userDB);
			$userlink = new PDO('sqlite:' . $userDB);
			$userlink->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
			$userlink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		} 
		catch(PDOException $e) 
		{ 
			echo $e->getMessage(); 
			$userlink  = null;
		}
		return $userlink;
	}
	//------------------------------------------------------------------------
	
	function qsCheckUserTables()
	{
		$sSQL = "create table IF NOT EXISTS ProjectTBL( PRJ_ID varchar(64) not NULL, PRJ_COMMENT  varchar(64)   not NULL, primary key(PRJ_ID))";
		qsExecuteSQL($sSQL);
		$sSQL =          "CREATE table IF NOT EXISTS JobTBL  ( PRJ_ID  varchar(64)    not NULL, JOBID varchar(64) not NULL, ";
		$sSQL =  $sSQL . "JOBDESC  varchar(64) not NULL, JOBRATIO  int not NULL, ";
		$sSQL =  $sSQL . "BEGINDATE        datetime        not NULL, ";
		$sSQL =  $sSQL . "ENDDATE                datetime        not NULL,";
		$sSQL =  $sSQL . "PRIMARY KEY (PRJ_ID, JOBID))";
		qsExecuteSQL($sSQL);
		$sSQL =  "CREATE TABLE IF NOT EXISTS KeyValTBL  ( SKEY text, SVALUE text, PRIMARY KEY (SKEY))";
		qsExecuteSQL($sSQL);
	}

	// SQL문 실행.
	function qsExecuteSQL($sSQL)
	{
		try
		{
			$userlink = qsCheckUserDB();
			$userlink->exec($sSQL);
			return 'OK';
		}
		catch(PDOException $e) 
		{ 
			return  $e->getMessage(); 
		}
	}

	function qsSelectSQL($sSQL)
	{
		try
		{
			$userlink = qsCheckUserDB();
			$result = $userlink->query($sSQL);
			return $result;
		}
		catch(PDOException $e) 
		{ 
			//echo $userDB = qsGetDbDir() . qsGetUserName() .'.db';
			echo $e->getMessage(); 
			return null;
		}
	}
	
	function qsGetKeyVal($sKey)
	{
		$sSQL = 'SELECT SVALUE FROM KeyValTBL WHERE SKEY=\'' . $sKey . '\'';
		$result = qsSelectSQL($sSQL);
		foreach ($result as $row)
		{
			return $row[0];
		}
		return "";
	}
	
	function qsSetKeyVal($sKey,$sVal)
	{
		$sSQL = 'REPLACE INTO KeyValTBL (SKEY, SVALUE) VALUES (\'' . $sKey . '\', \'' . $sVal . '\')';
		qsExecuteSQL($sSQL);
	}
	
	
	function qsCheckSession()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
		if(!isset($_SESSION['nickname']))
		{
			echo "<script>location.href='login.php';</script>"; 
		}
	}
?>

















