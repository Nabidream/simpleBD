<?php
	include_once "../checksession.php";
	include_once "../../lib/qsFunc.php";
?>
<center>
<table class="mainTable" >
<colgroup>
<col width="20%" >
<col width="80%">
</colgroup>
<tr> <th colspan=2>회원가입</th> </tr>
<tr>
	<th> 아이디 </th>
	<td>
	<input type="text" id="memberID">
	<button type="button" onclick="axUserExist()">[아이디 확인]</button>
	</td>
</tr>
<tr>
	<th >이름</th>
	<td	><input type="text" id="memberNick"></td>
</tr>
<tr>
	<th >이메일</th>
	<td	><input type="text" id="memberEmail" ></td>
</tr>
<tr>
	<th>자기소개</th>
	<td align=center >
		<TEXTAREA id="memberDesc" name=content  rows=15 style="width:100%;"></TEXTAREA>
	</td>
</tr>
<tr>
	<th >비밀번호</th>
	<td	><input id="memberPW" type="text"></td>
</tr>
<tr>
	<th >비밀번호확인</th>
	<td	><input id="memebercheckPW" type="text">
	</td>
</tr>
<!-- 기타 버튼들 -->
<tr>
	<th colspan=2 align="left">
		<br>
		<button  type="button" class="textButton" onclick="axMemeberRegister()">[가입하기]</button>
		<br>
		<br>
	</th>
</tr>
</table>
</center>
