<?php
//데이터 베이스 연결하기
include_once "../../lib/qsFunc.php";
$viewCount=20;
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
		$sWhere = $sWhere . "(pt.sTitle like '%$sSearch%')";
		
	}
	if( true ==$bCheckContent)
	{
		
		if("" != $sWhere)
		{
			$sWhere = $sWhere . " OR ";
		}
		$sWhere = $sWhere . "(pt.sContent like '%$sSearch%')";
	}
	if( "" != $sWhere)
	{
		$sWhere = "AND (" . $sWhere . ")" ;
	}
}	

//-----------------------------------------------------
$SQL = "SELECT count(pt.postID) FROM PostTBL pt, UsersTBL ut WHERE ut.userID   = pt.userID " . $sWhere;
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
$SQL ="SELECT ut.uNick , ut.uEmail  ,pt.* FROM UsersTBL ut, PostTBL pt WHERE ut.userID   = pt.userID $sWhere ORDER BY pt.postID  DESC LIMIT $no,$viewCount";
//qsAlert($SQL);
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
<table id="postTable" class="mainTable"> 
<colgroup>
<col width="5%" >
<col width="5%" >
<col width="40%">
<col width="20%">
<col width="20%">
<col width="10%">
</colgroup>
<tbody>
<tr>
	<th colspan=6>게시물관리목록</th>
</tr>
<!-- 리스트 타이틀 부분 -->
<tr >
	<th><input type="checkbox" name="postAll"></input></th>
	<th align=center><b>번호</b></th>
	<th align=center><b>제 목</b></th>
	<th align=center><b>글쓴이</b></th>
	<th align=center><b>시 간</b></th>
	<th align=center><b>조회수</b></th>
</tr>
<!-- 리스트 타이틀 끝 -->
<!-- 리스트 부분 시작 -->
<?php
foreach($result as $row)
{
?>
<!-- 행 시작 -->
<tr height=25 bgcolor=white>
	<!-- 선택 박스 -->
	<td align="center"><input type="checkbox" name="postSelect"></input></td>
	<!-- 번호 -->
	<td align=center>
		<?php echo $row['postID']?>
	</td>
	<!-- 제목 -->
	<td>&nbsp;
		<a href="main.php?rightView=./service/postman/postmanDetail.php&POSTID=<?php echo $row['postID']?>&NO=<?php echo $no?>">
		<?php echo $row['sTitle'];?></a>
	</td>
	<!-- 이름 -->
	<td align=center>
		<font color=black><?php echo $row['uNick']?></font>
	</td>
	<!-- 날짜 -->
	<td align=center>
		<font color=black><?php echo $row['wTime']?></font>
	</td>
	<!-- 조회수 -->
	<td align=center>
		<font color=black><?php echo $row['viewCount']?></font>
	</td>
</tr>
<!-- 행 끝 -->
<?php
} // end While
?>
<!-- 게시물 리스트를 보이기 위한 테이블 끝-->
<!-- 페이지를 표시하기 위한 테이블 -->
<tr >
<!--<td width=600 height=20 align=center rowspan=4>-->
<th colspan=6>
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
</tbody>
</table>
<button type="button" class="textButton" onclick="DeletePostRows()">[선택 삭제]</button>
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
<script>
	$('input[name=postAll]').on('change', function()
	{
		$('input[name=postSelect]').prop('checked', this.checked);
	});
	function DeletePostRows()
	{
		var MyRows = $('table#postTable').find('tbody').find('tr');
		var nCount = $('input[name=postSelect]').length;
		var inputs = new Array(nCount);
		for(var i=0; i<nCount; i++)
		{                          
			inputs[i] = $('input[name=postSelect]')[i];
			if( true  == inputs[i].checked)
			{
				var postID = jQuery.trim($(MyRows[i+2]).find('td:eq(1)').html());
				axDeletePostEx(postID);
			}	
		}
		location.reload();
	}
</script>
</center>

