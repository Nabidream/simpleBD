<center>
<br />
<!-- 입력된 값을 다음 페이지로 넘기기 위해 FORM을 만든다. -->
<?php
	include_once "../../lib/qsFunc.php";
	if(!isset($_GET['POSTID'])) die('ERROR : 페이지를 표시하기 위한 정보가 부족합니다.');
	$postID = $_GET['POSTID'];
?>
<!--<table width=780 border=0 cellpadding=2 cellspacing=1 bgcolor=#cccccc>-->
<table class="mainTable" >
<colgroup>
<col width="20%" >
<col width="80%">
</colgroup>
	<tr>
		<td height=20 align=center bgcolor=#eeeeee >
			<font color="black"><B>글 수 정 하 기</B></font>
		</td>
	</tr>
<?php
	include_once "./lib/qsFunc.php";
	// 먼저 쓴 글의 정보를 가져온다.
	$result=qsSysSelectSQL("SELECT * FROM PostTBL WHERE postID=$postID");
	$row= $result->fetch();
?>
<!-- 입력 부분 -->
	<tr>
		<td bgcolor=white>&nbsp;
		<table class="mainTable" >
			<tr>
			<form>
			<td width=60 align=left >제 목</td>
				<td align=left >
					<INPUT type=text name=title size=60 id="editTitle" style="width:100%"
					value=<?php echo $row['sTitle']?>>
				</td>
			</tr>
			<tr>
				<td width=60 align=left >내용</td>
				<td align=left >
					<TEXTAREA name=content style="width:100%" rows=15 id="editContent"><?php echo $row['sContent']?></TEXTAREA>
				</td>
			</tr>
			<tr>
				<td colspan=10 align=center>
				<!--	<button type="button" class="textButton" onclick="axPostModify(88,'editTitle','editContent')">[저장]</button>-->
					<button type="button" class="textButton" onclick="axPostModify(<?php echo $postID ?>,'editTitle','editContent');">[저장]</button>
					&nbsp;&nbsp;
					<button type="reset"class="textButton">[리셋]</button>
					&nbsp;&nbsp;
					<button type="button"onclick="history.back(-1)"class="textButton">[취소]</button>
				</td>
			</tr>
			</form>
			</TABLE>
		</td>
	</tr>
<!-- 입력 부분 끝 -->
</table>
</center>
