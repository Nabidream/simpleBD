<?php
	include_once "../../lib/qsFunc.php";
	if(!isset($_GET['ISSUEID'])) die('ERROR : 페이지를 표시하기 위한 정보가 부족합니다.');
	$issueID = $_GET['ISSUEID'];
	$result=qsSysSelectSQL("SELECT * FROM IssueTBL WHERE issueID=$issueID");
	$row= $result->fetch();
?>
<center>
<table class="mainTable" >
<colgroup>
<col width="10%" >
<col width="90%">
</colgroup>
	<tr>
		<th colspan=2>
			<font color="black"><B>이슈 수정</B></font>
		</th>
	</tr>
			<form>
			<th>프로젝트</th>
			<td>
<?php
		$SQL="SELECT * FROM ProjectTBL WHERE userID = '{$_SESSION['LOGINID']}'";
		$pResult=qsSysSelectSQL($SQL);
		//$pRow=$pResult->fetch();
		echo "<select id='editProjectID'>";
		foreach($pResult as $pRow)
		{
			if( $pRow['projectID'] != $row['projectID'])
			{
				echo "<option value={$pRow['projectID']}>{$pRow['sTitle']}</option>";
			}
			else
			{
				echo "<option value={$pRow['projectID']} selected='selected'>{$pRow['sTitle']}</option>";
			}
		}
?>
			</td>
			<tr><th >완료율</th>
				<td align=left >
				<INPUT type="number" id="editRate" min="0" max="100" value=<?php echo $row['doneRate']?>>
			</td></tr>
			<tr><th >시작시간</th>
				<td align=left >
				<INPUT type="date" id="editStartDate"  value=<?php echo $row['startDate']?>>
			</td></tr>
			<tr><th >종료시간</th>
				<td align=left >
				<INPUT type="date" id="editEndDate"  value=<?php echo $row['endDate']?>>
			</td></tr>
			<tr><th>제 목</th>
				<td align=left >
					<INPUT type=text id="editTitle" style="width:100%"
					value=<?php echo $row['sTitle']?>>
			</td></tr>
			<tr>
				<th>내용</th>
				<td align=left >
					<TEXTAREA name=content style="width:100%" rows=15 id="editContent"><?php echo $row['sContent']?></TEXTAREA>
				</td>
			</tr>
			<tr>
				<th colspan=10 align=center>
				<!--	<button type="button" class="textButton" onclick="axPostModify(88,'editTitle','editContent')">[저장]</button>-->
					<button type="button" class="textButton" onclick="axIssueModify(<?php echo $issueID ?>);">[저장]</button>
					&nbsp;&nbsp;
					<button type="reset"class="textButton">[리셋]</button>
					&nbsp;&nbsp;
					<button type="button"onclick="history.back(-1)"class="textButton">[취소]</button>
				</th>
			</tr>
			</form>
<!-- 입력 부분 끝 -->
</table>
</center>
