<?php
	include_once "../../lib/checksession.php";
	include_once "../../lib/qsFunc.php";
?>
<center>
<?php
	//$rightView = "rightBoardRead";
	//데이터 베이스 연결하기
	if (!isset($_GET['MESSAGEID'])) die('ERROR : 페이지를 표시하기 위한 정보가 부족합니다.');
	$messageID = (int)$_GET['MESSAGEID'];
	$no =0;
	if(isset($_GET['NO'])) $no = (int)$_GET['NO'];
	$SQL = "SELECT ut.uGroup, ut.uNick, ut.uEmail ,pt.* FROM UsersTBL ut, SendMsgTBL pt WHERE ut.userID = pt.toUser AND pt.messageID={$messageID}";
	$result=qsSysSelectSQL($SQL);
	//echo $SQL;
	$row=$result->fetch();
	if( null == $row)
	{
		exit();
	}
	$textID = $row['userID'];
	$loginID = $_SESSION['LOGINID'];
	$sTitle = $row['sTitle'];
	$fromUser = $row['fromUser'];
?>
<table class="mainTable" >
<colgroup>
<col width="10%" >
<col width="40%">
<col width="10%">
<col width="40%">
</colgroup>
<tr>
	<th >받은사람</th>
	<td	><?php echo  $row['uNick']?></td>
	<th >시간</th>
	<td	><?php echo  $row['wTime']?></td>
</tr>
<tr>
	<th colspan=4 align="left"><B>&nbsp;<?php echo $row['sTitle']?></B></th>
</tr>
<tr height=150>
	<td bgcolor=white colspan=4 valign=top>
		<table width=95% height=95% border=0 cellpadding=5>
		<tr><td style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
		<pre><?php echo $row['sContent']?></pre>
		</td></tr>
		</table>
	</td>
</tr>
<!-- 기타 버튼 들 -->
<tr>
	<td colspan=4 bgcolor=#eeeeee>
	<table class="mainTable" >
		<tr>
			<td width=200 align=left height=20 style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
				<a href="main.php?rightView=./service/message/message.php&no=<?php echo $no?>">
				[목록보기]</a>
				<a href=# onclick="axDeleteMessage(<?php echo $messageID ?>, '<?php echo $sTitle ?>');return false;">[삭제]</a>
			</td>
			<!-- 기타 버튼 끝 -->
			<!-- 이전 다음 표시 -->
		<td align=right class="noBorder" style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
<?php
	// 현재 글보다  값이 큰 글 중 가장 작은 것을 가져온다. 
	// 즉 바로 이전 글
	$result_pid = qsSysSelectSQL("SELECT messageID FROM SendMsgTBL WHERE (messageID > $messageID) AND (fromUser='{$logID}') LIMIT 1");
	$prev_id = $result_pid->fetch();

	if ($prev_id['messageID']) // 이전 글이 있을 경우
	{
	echo "<a href=main.php?rightView=messageSendDetail.php&MESSAGEID={$prev_id['messageID']}>[이전]</a>";
	}
	else
	{
		echo "<font color=grey>[이전]</font>";
	}

	$result_nid = qsSysSelectSQL("SELECT messageID FROM SendMsgTBL WHERE (messageID < $messageID) AND (fromUser='{$logID}')ORDER BY messageID DESC LIMIT 1");
	$next_id = $result_nid->fetch();

	if ($next_id['messageID'])
	{
		echo "<a href=main.php?rightView=messageSendDetail.php&MESSAGEID={$next_id['messageID']}>[다음]</a>";
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

<br>
<table class="mainTable" >
<colgroup>
<col width="15%">
<col width="85%">
</colgroup>

<tr>
	<th colspan=2 >
		<B>답글쓰기</B>
	</th>
</tr>
<tr >
	<th>
		제목
	</th>
	<td>
		<input type="text" name="messageTitle" id="messageTitle" style="width:100%;line-height:100%"></input>
	</td>
</tr>
<tr>
	<th>
		내용
	</th>
	<td>
	<TEXTAREA name="messageContent" id="messageContent" rows=5 style="width:100%;"></TEXTAREA>
	</td>
</tr>
<tr>
	<th colspan=2 align="left">
		<button type="button" class="textButton" onclick="axMessageWrite(<?php echo "'{$fromUser}'";?> ,'messageTitle','messageContent')">[보내기]</button>
	</th>
	</tr>
</table>
</center>
<?php
	$result= qsSysExecuteSQL("UPDATE SendMsgTBL SET isRead =isRead +1 WHERE messageID =$messageID");
//	$result= qsSysExecuteSQL("UPDATE SendMsgTBL SET isRead =isRead +1 WHERE messageID =$messageID");
?>

