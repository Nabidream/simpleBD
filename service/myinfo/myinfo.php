<?php
	include_once "../checksession.php";
	include_once "../../lib/qsFunc.php";
	$userID = $_SESSION['LOGINID'];
	$no =0;
	if(isset($_GET['NO']))
	{
		$no = (int)$_GET['NO'];
	}
	$SQL = "SELECT * FROM UsersTBL WHERE userID='{$userID}'";
	$result=qsSysSelectSQL($SQL);
	$row=$result->fetch();
	
	if( null == $row)
	{
		die("ERRO : 데이터가 없습니다.");
		exit();
	}
	$userID = $row['userID'];
	$loginID = $_SESSION['LOGINID'];
?>
<center>
<table class="mainTable" >
<colgroup>
<col width="20%" >
<col width="80%">
</colgroup>
<tr>
	<th >등급</th>
	<td	><?php echo  $row['gradeID']?></td>
</tr>
<tr>
	<th >이름</th>
	<td	><input type="text" id="userName" value ="<?php echo  $row['uNick']?>"></td>
</tr>

<tr>
	<th >이메일</th>
	<td	><input type="text" id="userEmail" value ="<?php echo  $row['uEmail']?>"></td>
</tr>
<tr>
	<th>자기소개</th>
	<td align=center >
		<TEXTAREA id="userDesc" name=content  rows=15 style="width:100%;"><?php echo $row['uDesc'] ?></TEXTAREA>
	</td>
</tr>
<!--
<tr>
	<th colspan=2 align="left"><button type="button" class="textButton">[정보수정]</button>
	</th>
</tr>
-->
<tr>
	<th >비밀번호</th>
	<td	><input type="password" id="userPW"></td>
</tr>
<tr>
	<th >비밀번호확인</th>
	<td	><input type="password" id="userCheckPW">
		<!--<button type="button" class="textButton" >[비밀번호 변경]</button>-->
	</td>
</tr>
<!-- 기타 버튼들 -->
<tr>
	<th colspan=2 align="left">
		<br>
		<button  type="button" class="textButton" onclick="axUserModifyInfo('<?php echo $userID ?>')">[정보수정]</button>
		<button  type="button" class="textButton" onclick="axUserModifyPW('<?php echo $userID ?>')">[비밀번호변경]</button>
		<br>
		<br>
	</th>
</tr>
</table>
</center>
