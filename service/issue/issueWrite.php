<?php
	include_once "../../lib/qsFunc.php";
?>
<center>
<table class="mainTable" >
<colgroup>
<col width="10%" >
<col width="90%">
</colgroup>
	<tr>
		<th colspan=2>
			<font color="black"><B>이슈 쓰기</B></font>
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
		$bInit = true;
		foreach($pResult as $pRow)
		{
			
			if( true == $bInit)
			{
				echo "<option value={$pRow['projectID']} selected='selected'>{$pRow['sTitle']}</option>";
				$bInit = false;
			}
			else
				echo "<option value={$pRow['projectID']} >{$pRow['sTitle']}</option>";
		
		}
?>
			</td>
			<tr><th >완료율</th>
				<td align=left >
				<INPUT type="number" id="editRate" min="0" max="100" value="0"/>
			</td></tr>
			<tr><th >시작시간</th>
				<td align=left >
				<INPUT type="date" id="editStartDate"  value="<?php echo date('Y-m-d');?>"/>
			<tr><th >종료시간</th>
				<td align=left >
				<INPUT type="date" id="editEndDate"  value="<?php echo date('Y-m-d');?>"/>
			</td></tr>
			<tr><th>제 목</th>
				<td align=left >
					<INPUT type=text id="editTitle" style="width:100%">
			</td></tr>
			<tr>
				<th>내용</th>
				<td align=left >
					<TEXTAREA name=content style="width:100%" rows=15 id="editContent"></TEXTAREA>
				</td>
			</tr>
			<tr>
				<th colspan=10 align=center>
				<!--	<button type="button" class="textButton" onclick="axPostModify(88,'editTitle','editContent')">[저장]</button>-->
					<button type="button" class="textButton" onclick="axIssueWrite();">[저장]</button>
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
