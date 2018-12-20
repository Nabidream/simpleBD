<?php
	include_once "../../lib/checksession.php";
	include_once "../../lib/qsFunc.php";
?>
<center>
<?php
	//$rightView = "rightBoardRead";
	//데이터 베이스 연결하기
	if (!isset($_GET['POSTID'])) die('ERROR : 페이지를 표시하기 위한 정보가 부족합니다.');
	$postID = (int)$_GET['POSTID'];
	$no =0;
	if(isset($_GET['NO'])) $no = (int)$_GET['NO'];
	$SQL = "SELECT ut.uNick, ut.uEmail ,pt.* FROM UsersTBL ut, PostTBL pt WHERE ut.userID = pt.userID AND pt.postID=$postID";
	//qsAlert($SQL);
	// 글 정보 가져오기
	$result=qsSysSelectSQL($SQL);
	//echo $SQL;
	$row=$result->fetch();
	if( null == $row)
	{
		exit();
	}
	$textID = $row['userID'];
	$logID = $_SESSION['LOGINID'];
	$sTitle = $row['sTitle'];
?>
<table class="mainTable" >
<tr>
	<td width=50 height=20 align=center bgcolor=#EEEEEE>글쓴이</td>
	<td	width=240 bgcolor=white><?php echo  $row['uNick']?></td>
	<td width=50 height=20 align=center bgcolor=#EEEEEE>그룹</td>
	<td	width=240 bgcolor=white><?php echo  $_SESSION['USER_GRADE']?></td>
</tr>
<tr>
	<td width=50 height=20 align=center bgcolor=#EEEEEE>
	날&nbsp;&nbsp;&nbsp;짜</td><td width=240
	bgcolor=white><?php echo $row['wTime']?></td>
	<td width=50 height=20 align=center bgcolor=#EEEEEE>조회수</td>
	<td	width=240 bgcolor=white><?php echo $row['pView'] +1 ?></td>
</tr>
<tr>
	<td height=20 colspan=4 align=left bgcolor=#eeeeee>
		<B>&nbsp;<?php echo $row['sTitle']?></B>
	</td>
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
				<a href="main.php?rightView=./service/post/post.php&no=<?php echo $no?>">
				[목록보기]</a>
				<a href="main.php?rightView=./service/post/postWrite.php" >[글쓰기]</a>
				<?php
					//if(true)
					if( $textID == $logID )
					{
						echo "<a href=\"main.php?rightView=./service/post/postModify.php&POSTID=$postID\">[수정]</a>";
						echo "&nbsp<a href=# onclick='axDeletePost({$postID},\"{$sTitle}\");return false;'>[삭제]</a>";
					}
				?>
			</td>
			<!-- 기타 버튼 끝 -->
			<!-- 이전 다음 표시 -->
		<td align=right class="noBorder" style=" border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px;">
<?php
	// 현재 글보다  값이 큰 글 중 가장 작은 것을 가져온다. 
	// 즉 바로 이전 글
	$result_pid = qsSysSelectSQL("SELECT postID FROM PostTBL WHERE postID > $postID LIMIT 1");
	$prev_id = $result_pid->fetch();

	if ($prev_id['postID']) // 이전 글이 있을 경우
	{
	echo "<a href=main.php?rightView=postDetail.php&POSTID={$prev_id['postID']}>[이전]</a>";
	}
	else
	{
		echo "<font color=grey>[이전]</font>";
	}

	$result_nid = qsSysSelectSQL("SELECT postID FROM PostTBL WHERE postID < $postID ORDER BY postID DESC LIMIT 1");
	$next_id = $result_nid->fetch();

	if ($next_id['postID'])
	{
		echo "<a href=main.php?rightView=postDetail.php&POSTID={$next_id['postID']}>[다음]</a>";
	
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

<table class="mainTable">  
<?php
	$SQL = "SELECT uNick ,rt.* FROM ReplyTBL rt, UsersTBL ut WHERE ( rt.postID=" . $postID . ") AND ";
	$SQL = $SQL . "(ut.userID = rt.userID) AND ( rt.rereplyID  < 0) ORDER BY wTime";
	$result = qsSysSelectSQL($SQL);
	if( NULL != $result)
	{

		foreach($result as $row)
		{
			$replyID = $row["replyID"];
			echo "<tr><td >";
			echo "<label>┖> ▣ 작성자: " . $row["uNick"] . " ▣ 시간: " . $row["wTime"] . "</label>"; 
			echo "<button class='textButton'  onclick='ShowRereply($postID,$replyID)'>&nbsp&nbsp[답글]</button>";
			if( $row["userID"]  === $_SESSION['LOGINID'])
			{
				echo "<button class='textButton' onclick='ShowEditReply($postID,$no,$replyID)' >[수정]</button>";
				echo "<button class='textButton' onclick='axPostDeleteReply(\"replyContentDIV\", $replyID)'>[삭제]</button>";
			}
			echo "<br><br><div><pre id='replyContentDIV$replyID'>";  
			echo $row["sContent"];  
			echo "</pre></div>";
			echo "<br><br><div name='rereplyDiv' id='rereplyDiv$replyID' style='display:none;'></div>";
			echo "<table class='mainTable'>";
			$SQL = "SELECT * FROM ReplyTBL WHERE (postID=" . $postID . ") AND (rereplyID  = " . $replyID . ") ORDER BY wTime";
			$rreeply = qsSysSelectSQL($SQL);
			foreach( $rreeply  as $rerow)
			{
				$rereplyID = $rerow['replyID'];
				echo "<tr><td><label> ┖>┖> ▣ 작성자: " . $rerow["userID"] . " ▣ 시간: " . $rerow["wTime"] . "</label>"; 

				if( $rerow["userID"]  === $_SESSION['LOGINID'])
				{
					echo "<button class='textButton' onclick='ShowEditRereply($postID,$no,$rereplyID)'>&nbsp&nbsp[수정]</button>";
					echo "<button class='textButton' onclick='axPostDeleteReply(\"rereplyContentDIV\", $rereplyID)'>[삭제]</button>";
				}
				echo "<br><br><div><pre id='rereplyContentDIV$rereplyID'>";  
				echo $rerow["sContent"] . "</pre></div>";  
				echo "<div id='editrereplyDiv$rereplyID' style='display:none;'></div>";
				echo "</td></tr>";
			}
			echo "</table>";
			echo "</td><tr>";
		}
	}
?>
</table>
<br>
<table class="mainTable" >
<tr>
	<td height=20 colspan=4 align=center bgcolor=#eeeeee>
		<B>댓글쓰기</B>
	</td>
</tr>
<tr >
	<td bgcolor=white colspan=4 valign=top align=left>
		<TEXTAREA id="replyContent" name=replyContent  rows=5 style="width:100%;"></TEXTAREA>
		<br>
		<br>
		<!--<a href=writereply.php?id=<> -->
		<button type="button" class="textButton" onclick="axPostWriteReply(<?php echo $postID ?>)">[저장]</button>

	</td>
</tr>
</table>
</center>
<?php
	// 조회수 업데이트
	$result= qsSysExecuteSQL("UPDATE SimpleBoardTBL SET viewCount =viewCount +1 WHERE id=$postID");
?>

