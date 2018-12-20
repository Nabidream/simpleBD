<?php

include_once "../lib/qsFunc.php";
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
$SQL = "SELECT count(gradeID) FROM GradeTBL " . $sWhere;
$result = qsSysSelectSQL($SQL);
$row = $result->fetch();
$row_count = 0;
if( null != $row) 
{
	$row_count = $row[0];
}

//-----------------------------------------------------
$SQL ="SELECT * FROM GradeTBL " . $sWhere;
$result = qsSysSelectSQL($SQL);
//-----------------------------------------------------
if ($row_count <= 0) $row_count = 0;
$total_page = ceil($row_count / $viewCount);
$current_page = ceil(($no+1)/$viewCount);
?>
<center>
<table class="mainTable"> 
<colgroup>
<col width="10%">
<col width="40%">
<col width="50%">
</colgroup>
<tr>
	<th colspan=3>등급 목록</th>
</tr>
<tr>
	<th align=center><b>아이디</b></th>
	<th align=center><b>등급이름</b></th>
	<th align=center><b>설 명</b></th>
</tr>
<?php
foreach($result as $row)
{
?>
<!-- 행 시작 -->
<tr height=25 bgcolor=white>
	<!-- 등급 아이디-->
	<td align=center>
		<?php echo $row['gradeID'];?>
	</td>
	<!-- 이름 -->
	<td	 name="gradeName" style="cursor:pointer;"><?php echo $row['sName'];?>
	</td>
	<!-- 설명 -->
	<td>
		<font color=black><?php echo $row['sDesc']?></font>
	</td>
</tr>
<!-- 행 끝 -->
<?php
} // end While
?>
<center>
</table>
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
	$prev_list = ($start_page - 2)*$viewCount;
	echo "<a href= $PHP_SELF?no=$prev_list>◀</a>";
}

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
<br>
<br>
<table class="mainTable"> 
<colgroup>
<col width="10%">
<col width="40%">
<col width="50%">
</colgroup>
<tr>
	<th align=center id="thIDView"><b>아이디</b></th>
	<th align=center><b>등급이름</b></th>
	<th align=center><b>설 명</b></th>
</tr>
<tr>
	<td align="center" id="tdIDView" style="height:100%"><label id="gradeIDView"></label></td>
	<td><input id="NameView" style="width:100%"></input></td>
	<td><input id="DescView" style="width:100%"></input></td>
</tr>
</table>
</center>
<br>
<button type="button" class="textButton" onclick="axGradeModify()">[수정]</button>
<!--<button type="button" class="textButton" onclick="CloseEditor('thIDView');CloseEditor('tdIDView');">[추가모드]</button>-->
<button type="button" class="textButton" onclick="axGradeWrite()">[추가]</button>
<button class="textButton" onclick="axGradeDelete()">[삭제]</button>
<script>
$("td[name=gradeName]").click(function()
{     
	var td = $(this);
	var tr = td.parent();
	var tdChild = tr.children();
	var gradeID = jQuery.trim(tdChild.eq(0).text());
	var sName = jQuery.trim(tdChild.eq(1).text());
	var sDesc = jQuery.trim(tdChild.eq(2).text());
	document.getElementById("gradeIDView").innerHTML = gradeID;
	document.getElementById("NameView").value = sName;
	document.getElementById("DescView").value = sDesc;
});
</script>









