
<h3>프로젝트 추가</h3>
<center>
<br />
<!-- 입력된 값을 다음 페이지로 넘기기 위해 FORM을 만든다. -->
<form>
<!--<table width=780 border=0 cellpadding=2 cellspacing=1 bgcolor=#cccccc>-->
<table class="mainTable" >
<colgroup>
<col width="15%" >
<col width="85%">
</colgroup>
	<tr>
		<td colspan= 2 height=20 align=center bgcolor=#eeeeee>
		<B>글 쓰 기</B>
		</td>
	</tr>
		<!-- 입력 부분 -->
	<tr>
		<th>완료율</th>
			<td align=center>
				<INPUT id="doneRate" type=text name=title size=63 style="width:100%;">
			</td>
		</tr>
		<tr>
			<th>제 목</th>
			<td align=center >
				<INPUT id="projectTitle" type=text name=title size=63 style="width:100%;">
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td align=center >
				<TEXTAREA id="projectContent" name=content  rows=15 style="width:100%;"></TEXTAREA>
			</td>
		</tr>
		<tr>
		<td colspan=2 align=center bgcolor=#EEEEEE>
			<BUTTON type="button"  class="textButton" onclick="axProjectWrite()">[저장]</BUTTON>
			&nbsp;&nbsp;
			<BUTTON type="reset" value="[다시 쓰기]" class="textButton">[다시쓰기]</BUTTON>
			&nbsp;&nbsp;
			<button type="button"onclick="history.back(-1)"class="textButton">[취소]</button>
		</td>
		</tr>
<!-- 입력 부분 끝 -->
</table>
</form>
</center>
