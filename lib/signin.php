<?php
include 'qsFunc.php';

$userID = $_POST['userID'];
$pw = $_POST['userPW'];

$sql = "SELECT uNick, AES_DECRYPT(UNHEX(uPW), '{$pw}'), sName , uEmail  FROM UsersTBL ut, GradeTBL gt  WHERE (ut.gradeID= gt.gradeID) and (userID   ='{$userID }')";
$result = qsSysSelectSQL($sql);
$bAuth = false;
$nickName = "";
$userGrade = "";
$userEmail = "";

if( null != $result)
{
	$row = $result->fetch();
	if($row[1] == $pw)
	{
		$nickName = $row[0];
		$bAuth = true;
		$userGrade = $row[2];
		$userEmail =$row[3];

	}
}
if( true == $bAuth  ) 
{
	$sql = "SELECT * FROM SessionTBL WHERE userID   = '{$userID}'";
	$result = qsSysSelectSQL( $sql );
	$num = $result->rowCount();
	//if( $num > 0 ) 
	if(false)
	{
		echo "<script> alert('해당 아이디는 이미 로그인한 상태입니다'); </script>";
	} 
	else 
	{
		$row = $result->fetch();
		$sess_id = session_id();
		$sql = "INSERT INTO SessionTBL VALUE('$userID', '$sess_id' )";
		$ret = qsSysExecuteSQL( $sql );
		if( "OK" != $ret)
		{
			echo $ret;
		}
		// 2. 세션 변수에 아이디 추가
		$_SESSION['NICKNAME'] = $nickName;
		$_SESSION['LOGINID'] = $userID;
		$_SESSION['USER_GRADE'] = $userGrade;
		$_SESSION['USER_EMAIL'] = $userEmail;
		echo "<script> alert('로그인 되었습니다'); </script>";
	}
} 
else 
{
  echo "<script> alert('아이디 또는 패스워드가 올바르지 않습니다.'); </script>";
}

?>
<meta http-equiv='refresh' content="0;url='http://kakadream.iptime.org:1180/simpleBD/main.php'">