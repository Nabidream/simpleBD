<?php

//데이터 베이스 연결하기
include_once "../../lib/qsFunc.php";
# LIST 설정
# 1. 한 페이지에 보여질 게시물의 수
$viewCount=20;
# 2. 페이지 나누기에 표시될 페이지의 수
$pageSize = 5;

$no=0;
if (isset($_GET['no']) && ( 0 <=  $_GET['no'] )) 
{
	$no = $_GET['no'];
}

if(trim($no) === "")
{
	$no=0;
}

/*
	<input type="checkbox" name="CHECKNAME" value="이름" >이름</input> 
	<input type="checkbox" name="CHECKTITLE" value="제목">제목</input>
	<input type="checkbox" name="CHECKCONTENT" value="내용" checked>내용</input>
	<input type="text" name="Search"></input>
*/
$sSearch = "";
if(ISSET($_POST["Search"]))
{
	$sSearch = trim($_POST["Search"]);
	qsSetVar("rightSearch",$sSearch);
}
$bCheckName = false;
if(ISSET($_POST["CHECKNAME"]))
{
	$bCheckName = $_POST["CHECKNAME"];
}
qsSetVar("bCheckName",$bCheckName);

$bCheckTitle= false;
if(ISSET($_POST["CHECKTITLE"]))
{
	$bCheckTitle = $_POST["CHECKTITLE"];
}
qsSetVar("bCheckTitle",$bCheckTitle);

$bCheckContent=true;
if(ISSET($_POST["CHECKCONTENT"]))
{
	$bCheckContent= $_POST["CHECKCONTENT"];
}
else
{
	$bCheckContent= false;
}

qsSetVar("bCheckContent",$bCheckContent);

if("" != $sSearch )
{
	if(true==$bCheckName)
	{
		$sWhere = "(ut.uNick  like '%$sSearch%')";
	}
	if(true==$bCheckTitle)
	{
		if("" != $sWhere)
		{
			$sWhere = $sWhere . " OR ";
		}
		$sWhere = $sWhere . "(mt.sTitle like '%$sSearch%')";
		
	}
	if( true ==$bCheckContent)
	{
		
		if("" != $sWhere)
		{
			$sWhere = $sWhere . " OR ";
		}
		$sWhere = $sWhere . "(mt.sContent like '%$sSearch%')";
	}
	if( "" != $sWhere)
	{
		$sWhere = "AND (" . $sWhere . ")" ;
	}
}	

//-----------------------------------------------------
// 총 게시물의 숫자.
$SQL = "SELECT count(mt.fromUser) FROM SendMsgTBL mt, UsersTBL ut WHERE (ut.userID   = mt.toUser)";
$SQL = $SQL .  "AND (mt.fromUser = '{$_SESSION['LOGINID']}')  " . $sWhere;
$result = qsSysSelectSQL($SQL);
$row = $result->fetch();
$total_row = 0;
if( null != $row) 
{
	$total_row = $row[0];
}

//-----------------------------------------------------
// 데이터베이스에서 페이지의 첫번째 글($no)부터 
// $viewCount 만큼의 글을 가져온다.
//
$SQL ="SELECT  ut.uNick , ut.uEmail, mt.* FROM UsersTBL ut, SendMsgTBL mt WHERE (ut.userID   = mt.toUser) ";
$SQL = $SQL . "AND (mt.fromUser = '{$_SESSION['LOGINID']}')  " . $sWhere ." ORDER BY mt.wTime  DESC LIMIT $no,$viewCount";
$result = qsSysSelectSQL($SQL);
//-----------------------------------------------------
// 총 게시물 수 를 구한다.
//결과의 첫번째 열이 count(*) 의 결과다.
# 총 페이지 계산
if ($total_row <= 0) $total_row = 0;
$total_page = ceil($total_row / $viewCount);

# 현재 페이지 계산
$current_page = ceil(($no+1)/$viewCount);
?>
<!-- 게시물 리스트를 보이기 위한 테이블 -->
<center>
<table class="mainTable"> 
<colgroup>
<!--<col width="10%">-->
<col width="60%">
<col width="20%">
<col width="20%">
</colgroup>

<!-- 리스트 타이틀 부분 -->
<tr>
	<th colspan=3>보낸 메시지</th>
</tr>
<tr>
<!--	<th align=center><b>읽기여부</b></th>-->
<!--	<th align=center><b>읽기여부</b></th>-->
	<th align=center><b>제 목</b></th>
	<th align=center><b>받은사람</b></th>
	<th align=center><b>시 간</b></th>
</tr>
<!-- 리스트 타이틀 끝 -->
<!-- 리스트 부분 시작 -->
<?php
foreach($result as $row)
{
?>
<!-- 행 시작 -->
<tr height=25 bgcolor=white>
	<!-- 읽기 여부 -->
<!--
	<td align=center>
		<?php 
			if( 0 == $row['isRead'])
			{
				echo "<div>안읽음</div>";
			}
			else
			{
				echo "<div>읽음</div>";
			}
		?>
	</td>
-->
	<!-- 제목 -->
	<td>&nbsp;
		<a href="main.php?rightView=./service/message/messageSendDetail.php&MESSAGEID=<?php echo $row['messageID']?>">
		<?php echo $row['sTitle'];?></a>
	</td>
	<!-- 보낸 사람 -->
	<td align=center>
		<font color=black><?php echo $row['uNick']?></font>
	</td>
	<!-- 날짜 -->
	<td align=center>
		<font color=black><?php echo $row['wTime']?></font>
	</td>
</tr>
<!-- 행 끝 -->
<?php
} // end While
?>
<center>
</table>
<!-- 게시물 리스트를 보이기 위한 테이블 끝-->
<!-- 페이지를 표시하기 위한 테이블 -->
<table class="mainTable">

<tr>
<th>
<font color=gray>
	&nbsp;
<?php
$start_page = floor(($current_page - 1) / $pageSize) * $pageSize + 1;
# 페이지 리스트의 마지막 페이지가 몇 번째 페이지인지 구하는 부분이다.
$end_page = $start_page + $pageSize - 1;
if ($total_page < $end_page) $end_page = $total_page;
if ( $pageSize <= $start_page) 
{
	# 이전 페이지 리스트값은 첫 번째 페이지에서 한 페이지 감소하면 된다.
	# $viewCount 를 곱해주는 이유는 글번호로 표시하기 위해서이다.
	$prev_list = ($start_page - 2)*$viewCount;
	echo "<a href= $PHP_SELF?no=$prev_list>◀</a>";
}

// 페이지 리스트를 출력
for ($i=$start_page;$i <= $end_page;$i++) 
{
	$page= ($i-1) * $viewCount;// 페이지값을 no 값으로 변환.
	if ($no!=$page){ //현재 페이지가 아닐 경우만 링크를 표시
		echo "<a href=\"$PHP_SELF?no=$page\">";
	}
	
	echo " $i "; //페이지를 표시
	
	if ($no!=$page)
	{
		echo "</a>";
	}
}

# 다음 페이지 리스트가 필요할때는 총 페이지가 마지막 리스트보다 클 때이다.
# 리스트를 다 뿌리고도 더 뿌려줄 페이지가 남았을때 다음 버튼이 필요할 것이다.
if($total_page > $end_page)
{
	$next_list = $end_page * $viewCount;
	echo "<a href=$PHP_SELF?no=$next_list>▶</a><p>";
}
?>

</font>
</th>
</tr>
</table>
<!--<a href="main.php?rightView=./service/message/messageWrite.php" align="left">[글쓰기]</a>-->
<br>
<br>
<form method="POST" action="main.php">
	<input type="checkbox" name="CHECKNAME" value="이름" <?php qsCheckedStr($bCheckName)?> >이름</input> 
	<input type="checkbox" name="CHECKTITLE" value="제목" <?php qsCheckedStr($bCheckTitle)?>>제목</input>
	<input type="checkbox" name="CHECKCONTENT" value="내용" <?php qsCheckedStr($bCheckContent)?>>내용</input>
	<script>
		var sSearch = sessionStorage.getItem("rightSearch");
		if( null == sSearch)
		{
			sSearch = "";
		}
		var sTemp = "&nbsp&nbsp<input type='text' name='Search' value ='" + sSearch + "'></input>";
		document.write(sTemp);
	</script>
	<button type="submit">조회</button>
</form>
</center>











