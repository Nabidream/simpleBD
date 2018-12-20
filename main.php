<?php
	include_once'./lib/qsFunc.php';
?>
<!DOCTYPE html>
<html >
 <head>
	<title>업무관리</title>
	<meta charset="utf-8">
	<link href="./css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script lang="javascript" src="./js/qsMain.js"></script>
	<script lang="javascript" src="./js/jquery.js"></script>
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

</head>
<body>
<center>
<table class="mainTable">
<colgroup>
<col width="20%" >
<col width="80%">
</colgroup>
<tr>
<td colspan=2 >
<?php
	include_once "roof.php";
?>
</td>
</tr>
<tr>  
<td  valign="top"  >
<div style=" min-height: 300px;">
<?php
	include_once "left.php";
?>
</div>
</td>
<td valign="top">
<?php
	include_once "right.php";
?>
</td>
</tr>
<tr>
<td colspan=2>
<?php
	include_once "footer.php";
?>
</td>
</tr>
</table>
</center>
</body>
</html>

