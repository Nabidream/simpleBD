<center>
<br />
<!-- 입력된 값을 다음 페이지로 넘기기 위해 FORM을 만든다. -->
<form>
<!--<table width=780 border=0 cellpadding=2 cellspacing=1 bgcolor=#cccccc>-->
<table class="mainTable" >
<colgroup>
<col width="20%" >
<col width="80%">
</colgroup>
	<tr>
		<td height=20 align=center bgcolor=#eeeeee>
		<B>글 쓰 기</B>
		</td>
	</tr>
	<!-- 입력 부분 -->
	<tr>
		<td bgcolor=white>&nbsp;
		<table class="mainTable" >
			<tr>
				<td align=center >제 목</td>
				<td align=center >
					<INPUT id="postWrite" type=text name=title size=63 style="width:100%;">
				</td>
			</tr>
			<tr>
				<td align=center >내용</td>
				<td align=center >
					<TEXTAREA id="postContent" name=content  rows=15 style="width:100%;"></TEXTAREA>
				</td>
			</tr>
			<tr>
				<td colspan=10 align=center>
					<BUTTON type="button"  class="textButton" onclick="axPostWrite()">[저장]</BUTTON>
					&nbsp;&nbsp;
					<BUTTON type="reset" value="[다시 쓰기]" class="textButton">[다시쓰기]</BUTTON>
					&nbsp;&nbsp;
					<button type="button"onclick="history.back(-1)"class="textButton">[취소]</button>
			</td>
			</tr>
		</TABLE>
</td>
</tr>
<!-- 입력 부분 끝 -->
</table>
</form>
</center>
