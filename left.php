<?php
	include_once'./lib/qsFunc.php';
	if( !isset($_SESSION['LOGINID']) ) 
	{
?>
		<form class="navbar-form navbar-right" method=POST action="./lib/signin.php" onsubmit="return leftCheckSignIn()">
		<table class="mainTable">
		<tr><td>
			<div class="form-group">
			<labe>아이디</label> <input type="text" name="userID" id="leftUserID" style="width:100%;margine:2px 2px 2px 2px;">
			</div>
		</td></tr>
		<tr><td>
			<div class="form-group">
			<label>비밀번호</label><input type="password" name="userPW" id="leftPassword" style="width:100%;">
			</div>
		</td></tr>
		<tr><td>
			<button type="submit" class="textButton">[입장]</button>
		</td><tr>
		</form>
		<tr><td><button class="textButton" type="button" onclick="GoRightView('./service/member/member.php')">
		[회원가입]</button></td></tr>
		</table>
		<script>
			function leftCheckSignIn()
			{
				var sID = document.getElementById("leftUserID");
				var sPW = document.getElementById("leftPassword");
				//alert(sID.value);
				//alert(sPW.value);
				if(( sID.value == "")||(sPW.value == ""))
				{
					alert("아이디 혹은 패스워드가 비워져 있습니다.")
					return false;
				}
				else
				{
					return true;
				}
			}
		</script>
<?php	
	}
	else
	{
?>
		<form class="navbar-form navbar-center" method=POST action="./lib/signout.php">
			<table class="mainTable">
			<tr>
			<td>이름</td><td> <?php echo  $_SESSION['NICKNAME'] ?> </td>
			</tr>
			<tr>
			<td>이메일</td><td> <?php echo  $_SESSION['USER_EMAIL'] ?> </td>
			</tr>
			<tr>
			<td>등급</td><td> <?php echo  $_SESSION['USER_GRADE'] ?> </td>
			</tr>
			<tr><td colspan=2>
			<button type="submit" class="textButton">[나가기]</button>
			</td></tr>
			</table>
		</form>	
			<br><table class='mainTable'>
			<tr><td>
				<div class="dropdown" style="float:left;" >
				    <button type="button" class="textButton">
					[메시지]</button>
					<div class="dropdown-content" style="left:100%;top:0;">
						<table class="mainTable">
						<tr><td>
						<button type="button" class="textButton" 	onclick="GoRightView('./service/message/message.php')">
						[받은메시지]</button>
						</td></tr>
						<tr><td>
						<button type="button" class="textButton" 	onclick="GoRightView('./service/message/messageSend.php')">
						[보낸메시지]</button>
						</td></tr>
						</table>
					</div>
				</div>	
			</td></tr>
		<!--	<tr><td><a href=main.php?rightView=./service/post/post.php>[게시판]</a></td></tr>-->
			<tr><td>
			    <button type="button" class="textButton" 	onclick="GoRightView('./service/post/post.php')">
					[게시판]</button>
				<!--	<button class="textButton">[게시판]</button>-->
			</td></tr>
			<tr><td>
				<div class="dropdown" style="float:left;" >
				    <button class="textButton">[이슈]</button>
					<div class="dropdown-content" style="left:100%;top:0;">
						<table class="mainTable">
						<tr><td>
						<button type="button" class="textButton" 	onclick="GoRightView('./service/project/project.php')">
						[프로젝트관리]</button>
						</td></tr>
						<tr><td>
						<button type="button" class="textButton" 	onclick="GoRightView('./service/issue/issue.php')">
						[이슈관리]</button>
						</td></tr>
						</table>
					</div>
				</div>	
			</td></tr>
			<!--<tr><td><a href=main.php?rightView=./service/project/project.php>[프로젝트관리]</a></td></tr>
			<tr><td><a href=main.php?rightView=./service/issue/issue.php>[이슈관리]</a></td></tr>-->
		<?php
		if( "관리자" === $_SESSION['USER_GRADE'])
		{
		?>
		<tr><td>
			<div class="dropdown" style="float:left;" >
			    <button class="textButton">[관리자메뉴]</button>
				<div class="dropdown-content" style="left:100%;top:0;">
					<table class="mainTable">
					<tr><td>
					<button type="button" class="textButton" 	onclick="GoRightView('./service/grade/grade.php')">
					[등급관리]</button>
					</td></tr>
					<tr><td>
					<button type="button" class="textButton" 	onclick="GoRightView('./service/user/user.php')">
					[사용자관리]</button>
					</td></tr>
					<tr><td>
					<button type="button" class="textButton" 	onclick="GoRightView('./service/postman/postman.php')">
					[게시물관리]</button>
					</td></tr>
					</table>
				</div>
			</div>		
		</td></tr>
		<?php
		}
		?>
		<tr><td><button class="textButton" onclick="GoRightView('./service/myinfo/myinfo.php')">
		[내계정관리]</button></td></tr>
		</table>
<?php
	}
?>











