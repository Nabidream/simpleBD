<?php
	include_once "../lib/checksession.php";
	include_once "../lib/qsFunc.php";
?>
<?php
	if (!isset($_GET['PROJECTID'])) die('ERROR : 페이지를 표시하기 위한 정보가 부족합니다.');
	$projectID = (int)$_GET['PROJECTID'];
	$no =0;
	if(isset($_GET['NO']))
	{
		$no = (int)$_GET['NO'];
	}
	$SQL = "SELECT uNick, ut.uEmail ,pt.* FROM UsersTBL ut, ProjectTBL pt WHERE ut.userID = pt.userID AND pt.projectID={$projectID}";
	$result=qsSysSelectSQL($SQL);
	$row=$result->fetch();
	if( null == $row)
	{
		
		exit();
	}
	$userID = $row['userID'];
	$loginID = $_SESSION['LOGINID'];
	$sTitle = $row['sTitle'];
?>
<h3>프로젝트 상세 정보</h3>
<center>
<table class="mainTable" >
<colgroup>
<col width="10%" >
<col width="30%">
<col width="10%">
<col width="20%">
<col width="10%">
<col width="20%">
</colgroup>
<tr>
	<th >소유자</th>
	<td	><?php echo  $row['uNick']?></td>
	<th >완료율</th>
	<td	><?php echo  $row['doneRate']?></td>
	<th >날짜</th>
	<td	><?php echo  $row['wTime']?></td>
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
				<button type="button" class="textButton" 	onclick="GoRightView('./service/project/project.php&no=<?php echo $no?>')">
					[목록보기]</button>
				<button  type="button" class="textButton"  onclick="GoRightView('./service/project/projectModify.php&PROJECTID=<?php echo $projectID?>')">
					[수정]</button>
				<button  type="button" class="textButton"  onclick="axDeleteProject(<?php echo $projectID ?>, '<?php echo $sTitle ?>');">
					[삭제]</button>
			</td>
			<!-- 기타 버튼 끝 -->
			<!-- 이전 다음 표시 -->
		<td align=right class="noBorder" style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
<?php
	$result_pid = qsSysSelectSQL("SELECT projectID FROM ProjectTBL WHERE (projectID > $projectID) AND (userID='{$userID}') LIMIT 1");
	$prev_id = $result_pid->fetch();

	if ($prev_id['projectID']) // 이전 글이 있을 경우
	{
	echo "<a href=main.php?rightView=projectDetail.php&MESSAGEID={$prev_id['projectID']}>[이전]</a>";
	}
	else
	{
		echo "<font color=grey>[이전]</font>";
	}

	$result_nid = qsSysSelectSQL("SELECT projectID FROM ProjectTBL WHERE (projectID < $projectID) AND (userID='{$userID}')ORDER BY projectID DESC LIMIT 1");
	$next_id = $result_nid->fetch();

	if ($next_id['projectID'])
	{
		echo "<a href=main.php?rightView=projectDetail.php&MESSAGEID={$next_id['projectID']}>[다음]</a>";
	}
	else
	{
		echo "<font color=grey>[다음]</font>";
	}
?>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
</center>
<?php
	// 조회수 업데이트
	//$result= qsSysExecuteSQL("UPDATE ProjectTBL SET isRead =isRead +1 WHERE projectID =$projectID");
?>

