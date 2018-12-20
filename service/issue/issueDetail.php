<?php
	include_once "../checksession.php";
	include_once "../../lib/qsFunc.php";
	if (!isset($_GET['ISSUEID'])) die('ERROR : 페이지를 표시하기 위한 정보가 부족합니다.');
	$issueID = (int)$_GET['ISSUEID'];
	$no =0;
	if(isset($_GET['NO']))
	{
		$no = (int)$_GET['NO'];
	}
	$SQL = "SELECT ut.uNick, ut.uEmail ,pt.sTitle as prjName, ist.* FROM UsersTBL ut, ProjectTBL pt, IssueTBL ist";
	$SQL = $SQL . " WHERE (ut.userID = ist.userID) AND (pt.projectID = ist.projectID) AND(ist.issueID  ={$issueID})";
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
<h3>이슈 상세 정보</h3>
<center>
<table class="mainTable" >
<colgroup>
<col width="20%" >
<col width="30%">
<col width="20%">
<col width="30%">
</colgroup>
<tr>
	<th >프로젝트</th>
	<td	><?php echo  $row['prjName']?></td>
	<th >완료율</th>
	<td	><?php echo  $row['doneRate']?></td>
</tr>
<tr>
	<th >시작날짜</th>
	<td	><?php echo  $row['startDate']?></td>
	<th >종료날짜</th>
	<td	><?php echo  $row['endDate']?></td>
</tr>
<tr>
	<th colspan=6 align="left"><B>&nbsp;<?php echo $row['sTitle']?></B></th>
</tr>
<tr height=150>
	<td bgcolor=white colspan=6 valign=top>
		<table width=95% height=95% border=0 cellpadding=5>
		<tr><td style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
		<pre><?php echo $row['sContent']?></pre>
		</td></tr>
		</table>
	</td>
</tr>
<!-- 기타 버튼 들 -->
<tr>
	<td colspan=6 bgcolor=#eeeeee>
	<table class="mainTable" >
		<tr>
			<td width=200 align=left height=20 style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
				<button type="button" class="textButton" 	onclick="GoRightView('./service/issue/issue.php&no=<?php echo $no?>')">
					[목록보기]</button>
				<button  type="button" class="textButton"  onclick="GoRightView('./service/issue/issueModify.php&ISSUEID=<?php echo $issueID?>')">
					[수정]</button>
				<button  type="button" class="textButton"  onclick="axDeleteIssue(<?php echo $projectID ?>, '<?php echo $row['sTitle']; ?>');">
					[삭제]</button>
			</td>
			<!-- 기타 버튼 끝 -->
			<!-- 이전 다음 표시 -->
		<td align=right class="noBorder" style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
<?php
	$result_pid = qsSysSelectSQL("SELECT issueID FROM IssueTBL WHERE (issueID > $issueID) AND (userID='{$userID}') ORDER BY issueID  LIMIT 1");
	$prev_id = $result_pid->fetch();

	if ($prev_id['issueID']) // 이전 글이 있을 경우
	{
	echo "<a href=main.php?rightView=./service/issue/issueDetail.php&ISSUEID={$prev_id['issueID']}>[prev]</a>";
	}
	else
	{
		echo "<font color=grey>[prev]</font>";
	}
	$result_nid = qsSysSelectSQL("SELECT issueID FROM IssueTBL WHERE (issueID < $issueID) AND (userID='{$userID}') ORDER BY issueID DESC LIMIT 1");
	$next_id = $result_nid->fetch();
	if ($next_id['issueID'])
	{
		echo "<a href=main.php?rightView=./service/issue/issueDetail.php&ISSUEID={$next_id['issueID']}>[next]</a>";
	}
	else
	{
		echo "<font color=grey>[next]</font>";
	}
?>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
</center>
