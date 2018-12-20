<?php

//데이터 베이스 연결하기
include_once "../lib/qsFunc.php";
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
		$sWhere = $sWhere . "(ist.sTitle like '%$sSearch%')";
		
	}
	if( true ==$bCheckContent)
	{
		
		if("" != $sWhere)
		{
			$sWhere = $sWhere . " OR ";
		}
		$sWhere = $sWhere . "(ist.sContent like '%$sSearch%')";
	}
	if( "" != $sWhere)
	{
		$sWhere = "AND (" . $sWhere . ")" ;
	}
}	

//-----------------------------------------------------
// 총 게시물의 숫자.
$SQL = "SELECT count(ist.userID) FROM IssueTBL ist, UsersTBL ut, ProjectTBL pt WHERE ((ut.userID   = ist.userID)) AND (pt.ProjectID = ist.ProjectID)";
$SQL = $SQL .  "AND (ist.userID = '{$_SESSION['LOGINID']}')  " . $sWhere;
$result = qsSysSelectSQL($SQL);
$row = $result->fetch();
$total_row = 0;
if( null != $row) 
{
	$total_row = $row[0];
}

//-----------------------------------------------------
$SQL ="SELECT ut.uNick , ut.uEmail, pt.sTitle as ptTitle ,ist.* FROM UsersTBL ut, IssueTBL ist, ProjectTBL pt  WHERE (ut.userID   = ist.userID)AND (pt.ProjectID = ist.ProjectID) ";
$SQL = $SQL . "AND (ist.userID = '{$_SESSION['LOGINID']}')  " . $sWhere ." ORDER BY ist.wTime  DESC LIMIT $no,$viewCount";
$result = qsSysSelectSQL($SQL);
//-----------------------------------------------------
if ($total_row <= 0) $total_row = 0;
$total_page = ceil($total_row / $viewCount);
$current_page = ceil(($no+1)/$viewCount);
?>
<center>
<table class="mainTable"> 
<colgroup>
<col width="35%">
<col width="35%">
<col width="10%">
<col width="10%">
<col width="10%">
</colgroup>
<tr>
	<th colspan=5>이슈 록목</th>
</tr>
<tr>
	<th align=center><b>프로젝트</b></th>
	<th align=center><b>이  슈</b></th>
	<th align=center><b>시작날짜</b></th>
	<th align=center><b>종료날짜</b></th>
	<th align=center><b>완료율</b></th>
</tr>
<?php
foreach($result as $row)
{
?>
<!-- 행 시작 -->
<tr height=25 bgcolor=white>
	<!-- 프로젝트 -->
	<td >
		<font color=black><?php echo $row['ptTitle'];?></font>
	</td>
	<!--이슈 -->
	<td>&nbsp;
		<a href="main.php?rightView=./service/issue/issueDetail.php&ISSUEID=<?php echo $row['issueID']?>">
		<font color=black><?php echo $row['sTitle'];?></a></font>
	</td>
	<!--  시작날짜-->
	<td align=center>
		<font color=black><?php echo $row['startDate']?></font>
	</td>
	<!-- 종료 날짜 -->
	<td align=center>
		<font color=black><?php echo $row['endDate']?></font>
	</td>
	<!-- 완료율 -->
	<td align=center>
		<font color=black><?php echo $row['doneRate']?></font>
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
<button class="textButton" onclick="GoRightView('./service/issue/issueWrite.php')">
	[이슈추가]</button>
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











