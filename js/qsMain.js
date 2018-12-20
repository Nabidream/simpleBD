function GoRightView(sPage)
{
	//var slocation = "location.href='http://kakadream.iptime.org:1180/simpleBD/main.php?rightView=" + sPage + "'";
	var slocation = "main.php?rightView=" + sPage ;
//	alert(slocation);
	location.href = slocation;
}
//---------------------------------------------------------------------------------------//
// Ajax Post;
function SendAjaxPost(sUrl, sendData)
{
	var bResult = false;
	$.ajax({
        type: "POST",
        url : sUrl,
        data: sendData,
        dataType:"json",
		async: false,
        success : function(data, status, xhr) 
		{
			if( "OK" == data)
			{
				bResult = true;
			}
			else
			{
				alert(data);
			}
        },
        error: function(jqXHR, textStatus, errorThrown) 
		{
			alert(jqXHR.responseText);
		}
    }
	);
	return bResult;
}
//---------------------------------------------------------------------------------------//
// Ajax Post;

function SendSelect(sUrl, sendData)
{
	var aResult = new Array();
	$.ajax({
        type: "POST",
        url : sUrl,
        data: sendData,
        dataType:"json",
		async: false,
        success : function(data, status, xhr) 
		{
			aResult =	data;

        },
        error: function(jqXHR, textStatus, errorThrown) 
		{
			alert(jqXHR.responseText);
		}
    }
	);
	return aResult;
}

// 댓을을 쓴다.
function axPostWriteReply(sPostID)
{
	var	sWriteReply = document.getElementById("replyContent").value;
	if(( sWriteReply == ""))
	{
		alert("댓글이 비워져 있습니다.");
		return;
	}
	var sendData = {POSTID:sPostID,REPLYID:-1,CONTENT:sWriteReply}; 
	SendAjaxPost("./service/post/axPostWriteReply.php",sendData);
	location.reload();
}

function axPostWriteRereply(postID ,replyID)
{
	var sTemp = "rereplyContent" + replyID;
	sTemp = document.getElementById(sTemp).value;
	if("" == sTemp)
	{
		alert("답글이 비워져 있습니다.");
		return;
	}
	var sendData = {POSTID:postID,REPLYID:replyID,CONTENT:sTemp}; 
	SendAjaxPost("./service/post/axPostWriteReply.php",sendData);
	location.reload();
}


// 댓글을 지운다.
function axPostDeleteReply(contentDiv, replyID)
{
	var sTemp = contentDiv + replyID;
	var contentDiv = document.getElementById(sTemp);
	var contentStr = contentDiv.innerHTML;
	var bDel = confirm("아래 내용을 삭제 하시겠습니까?\n-------------------------------------\n" 
	+ contentStr + "\n-------------------------------------");
	if( false == bDel)
	{
		reutrn;
	}
	SendAjaxPost
	var sendData = {deleteID:replyID}; 
	SendAjaxPost("./service/post/axPostDeleteReply.php",sendData);
	location.reload();
}

function axPostModifyReply(replyID)
{
	var sTemp = "editContent" + replyID;
	sTemp = document.getElementById(sTemp).value;
	if("" == sTemp)
	{
		alert("답글이 비워져 있습니다.");
		return;
	}
	var sendData = {REPLYID:replyID,CONTENT:sTemp}; 
	SendAjaxPost("./service/post/axPostModifyReply.php",sendData);
	location.reload();
}

function axPostModify(postID,titleID,contentID)
{
	var sTitle   = document.getElementById(titleID).value;
	var sContent = document.getElementById(contentID).value;
	if(("" == sTitle)||("" == sContent))
	{
		alert("제목 또는 내용이 비워져 있습니다.");
		return;
	}
	var sendData = {WRITEID:postID,STITLE:sTitle,SCONTENT:sContent}; 
	SendAjaxPost("./service/post/axPostModify.php",sendData);
	history.back();
}

function axPostWrite()
{
	var sTitle   = document.getElementById("postWrite").value;
	var sContent = document.getElementById("postContent").value;
	if(("" == sTitle)||("" == sContent))
	{
		alert("제목 또는 내용이 비워져 있습니다.");
		return;
	}
	var sendData = {STITLE:sTitle,SCONTENT:sContent}; 
	SendAjaxPost("./service/post/axPostWrite.php",sendData);
	history.back();
}

function axDeletePost(postID,sTitle)
{
	var bDel = confirm("아래 글을 삭제 하시겠습니까?\n-------------------------------------\n" 
	+ sTitle + "\n-------------------------------------");
	if( true == bDel)
	{
		var sendData = {POSTID:postID}; 
		if( true == SendAjaxPost("./service/post/axPostDelete.php",sendData))
		{
			alert("삭제 되었습니다.");
			history.back();
		}
		else
		{
			
		}
	}
}


function axDeletePostEx(postID)
{
	var sendData = {POSTID:postID}; 
	if( true == SendAjaxPost("./service/post/axPostDelete.php",sendData))
	{
	}
	else
	{
		
	}
}

function axDeleteMessage(messageID,sTitle)
{
	var bDel = confirm("아래 글을 삭제 하시겠습니까?\n-------------------------------------\n" 
	+ sTitle + "\n-------------------------------------");
	if( true == bDel)
	{
		var sendData = {MESSAGEID:messageID}; 
		if( true == SendAjaxPost("./service/message/axMessageDelete.php",sendData))
		{
			alert("삭제 되었습니다.");
			history.back();
		}
		else
		{
			
		}
	}
}


function axSendMessage(sToUser,sTitle,sContent)
{
	if(("" == sToUser) ||("" == sTitle)||("" == sContent))
	{
		alert("사용자/제목/내용을 확인해야 합니다.");
		return;
	}
	var sendData = {TOUSER:sToUser, STITLE:sTitle,SCONTENT:sContent}; 
	if( true == SendAjaxPost("./service/message/axMessageWrite.php",sendData))
	{
		alert("메시지가 보내졌습니다.");
		history.back();
	}
}

function axMessageWrite(toUser, titleDiv, contentDiv)
{
	var sTitle   = document.getElementById(titleDiv).value;
	var sContent = document.getElementById(contentDiv).value;
	axSendMessage(toUser,sTitle,sContent);
}

function axMessageWriteMain()
{
	var sToUser = document.getElementById("toUserID").value;
	var sTitle   = document.getElementById("messageTitle").value;
	var sContent = document.getElementById("messageContent").value;
	axSendMessage(sToUser,sTitle,sContent);
}

function alertClose(sMsg)
{
	setTimeout(myAlert, 4000);
	function myAlert()
	{
		sleep(4000);
	   alert("hello world");
	   sleep(500);
	}
	sleep(3000);
}

//---------------------------------------------------------------------------------------//
function axProjectModify(projectID,rateID,titleID,contentID)
{
	var sRate   = document.getElementById(rateID).value;
	var sTitle   = document.getElementById(titleID).value;
	var sContent = document.getElementById(contentID).value;
	if(("" == sTitle)||("" == sContent)||(""== sRate))
	{
		alert("제목/제목/완료율이 모두 채워져야 합니다.");
		return;
	}
	var sendData = {WRITEID:projectID,RATE:sRate,STITLE:sTitle,SCONTENT:sContent}; 
	SendAjaxPost("./service/project/axProjectModify.php",sendData);
	history.back();
}

function axDeleteProject(projectID,sTitle)
{
	var bDel = confirm("아래 글을 삭제 하시겠습니까?\n-------------------------------------\n" 
	+ sTitle + "\n-------------------------------------");
	if( true == bDel)
	{
		var sendData = {PROJECTID:projectID}; 
		if( true == SendAjaxPost("./service/project/axProjectDelete.php",sendData))
		{
			alert("삭제 되었습니다.");
			history.back();
		}
		else
		{
			
		}
	}
}

function axProjectWrite()
{
	var doneRate   = document.getElementById("doneRate").value;
	var sTitle   = document.getElementById("projectTitle").value;
	var sContent = document.getElementById("projectContent").value;
	if(("" == sTitle)||("" == sContent))
	{
		alert("제목/내용/완요률이 모두 채워져 있어야 합니다.");
		return;
	}
	var sendData = {RATE:doneRate,STITLE:sTitle,SCONTENT:sContent}; 
	SendAjaxPost("./service/project/axProjectWrite.php",sendData);
	history.back();
}

//---------------------------------------------------------------------------------------//
function axIssueModify(issueID)
{
	var nProjectID = document.getElementById("editProjectID").value;
	var sRate   = document.getElementById("editRate").value;
	var sStartDate   = document.getElementById("editStartDate").value;
	var sEndDate   = document.getElementById("editEndDate").value;
	var sTitle   = document.getElementById("editTitle").value;
	var sContent = document.getElementById("editContent").value;
	if(("" == sRate)||("" == sStartDate)||("" == sEndDate)||("" == sTitle)||(""== sContent))
	{
		alert("완료율/시작시간/종료시간/제목/내용이 모두 채워져야 합니다.");
		return;
	}
	var sendData = {WRITEID:issueID,PROJECTID:nProjectID,RATE:sRate,STARTDATE:sStartDate,ENDDATE:sEndDate,STITLE:sTitle,SCONTENT:sContent}; 
	if(true == SendAjaxPost("./service/issue/axIssueModify.php",sendData))
	{
		alert("수정되었습니다.");
	}
	else
	{
	}
	history.back();
}


function axIssueWrite()
{
	var sRate   = document.getElementById("editRate").value;
	var nProjectID = document.getElementById("editProjectID").value;
	var sStartDate   = document.getElementById("editStartDate").value;
	var sEndDate   = document.getElementById("editEndDate").value;
	var sTitle   = document.getElementById("editTitle").value;
	var sContent = document.getElementById("editContent").value;
	if(("" == sRate)||("" == sStartDate)||("" == sEndDate)||("" == sTitle)||(""== sContent))
	{
		alert("완료율/시작시간/종료시간/제목/내용이 모두 채워져야 합니다.");
		return;
	}
	var sendData = {PROJECTID:nProjectID,RATE:sRate,STARTDATE:sStartDate,ENDDATE:sEndDate,STITLE:sTitle,SCONTENT:sContent}; 
	if(true == SendAjaxPost("./service/issue/axIssueWrite.php",sendData))
	{
		alert("추가 되었습니다.");
	}
	else
	{
	}
	history.back();
}

function axGradeModify()
{
	var gradeID = document.getElementById("gradeIDView").innerHTML;
	var sName = document.getElementById("NameView").value;
	var sDesc = document.getElementById("DescView").value;

	if((""==gradeID)||("" == sName)||("" == sDesc))
	{
		alert("아이디/이름/설명이 모두 채워져야 합니다.");
		return;
	}
	var sendData = {GRADEID:gradeID,NAME:sName,DESC:sDesc}; 
	if(true == SendAjaxPost("./service/grade/axGradeModify.php",sendData))
	{
		alert("수정 되었습니다.");
	}
	else
	{
	}
	location.reload();
}

function axGradeWrite()
{
	var sName = document.getElementById("NameView").value;
	var sDesc = document.getElementById("DescView").value;
	if(("" == sName)||("" == sDesc))
	{
		alert("이름/설명이 모두 채워져야 합니다.");
		return;
	}
	var sendData = {NAME:sName,DESC:sDesc}; 
	if(true == SendAjaxPost("./service/grade/axGradeWrite.php",sendData))
	{
		alert("추가 되었습니다.");
	}
	else
	{
	}
	location.reload();
}

function axGradeDelete()
{
	var sName = document.getElementById("NameView").value;
	var gradeID = document.getElementById("gradeIDView").innerHTML;
	if(("" == sName)||("" == gradeID))
	{
		alert("아이디와 이름이 모두 채워져야 합니다.");
		return;
	}
	var bDel = confirm("아래 등급을 삭제하시겠습니까?\n-------------------------------------\n" 
	+ sName + "\n-------------------------------------");
	if( true == bDel)
	{
		var sendData = {GRADEID:gradeID}; 
		if(true == SendAjaxPost("./service/grade/axGradeDelete.php",sendData))
		{
			alert("삭제 되었습니다.");
		}
		else
		{
		}
		location.reload();
	}
}

//---------------------------------------------------------------------------------------//
function axUserModifyInfo(sUser)
{
	//"userName" ,"userEmail" ,	"userDesc" 
	var sName = document.getElementById("userName").value;
	var sEmail = document.getElementById("userEmail").value;
	var sDesc = document.getElementById("userDesc").value;
	if((""==sName) ||("" == sEmail)||("" == sDesc))
	{
		alert("이름/이메일/설명이 모두 채워져야 합니다.");
		return;
	}
	var sendData = {USERID:sUser,UNAME:sName, UEMAIL:sEmail,UDESC:sDesc}; 
	if(true == SendAjaxPost("./service/user/axUserModifyInfo.php",sendData))
	{
		alert("수정 되었습니다.");
	}
	else
	{
	}
	location.reload();
}

function axUserModifyPW(sUser)
{
	//id="userPW"></td>
	//id="userCheckPW">
	var sPW = document.getElementById("userPW").value;
	var sCheckPW = document.getElementById("userCheckPW").value;
	if(("" == sPW)||("" == sCheckPW))
	{
		alert("비밀번호를 입력해야 합니다.");
		return;
	}
	if((sPW != sCheckPW))
	{
		alert("비밀번호와 비밀번호 확인이 다릅니다.");
		return;
	}
		
	var sendData = {USERID:sUser, PASSWORD:sPW}; 
	if(true == SendAjaxPost("./service/user/axUserModifyPW.php",sendData))
	{
		alert("수정 되었습니다.");
	}
	else
	{
	}
	location.reload();
	
}

function axUserDelete(sUser)
{
	if("" == sUser)
	{
		alert("아이디가 없습니다");
		return;
	}
	var sendData = {USERID:sUser}; 
	if(true == SendAjaxPost("./service/user/axUserDelete.php",sendData))
	{
	}
}

function axUserDeleteEx(sUser)
{
	if("" == sUser)
	{
		alert("아이디가 없습니다");
		return;
	}
	var bDel = confirm("아래 아이디를 삭제하시겠습니까?\n-------------------------------------\n" 
	+ sUser + "\n-------------------------------------");
	if( true == bDel)
	{
		var sendData = {USERID:sUser}; 
		if(true == SendAjaxPost("./service/user/axUserDelete.php",sendData))
		{
			alert("삭제 되었습니다.");
		}
		history.back();
	}
}

function axUserExist()
{
	var userID = document.getElementById("memberID").value;
	if("" == userID)
	{
		alert("아이디가 채워져야 합니다.");
		return true;
	}

	var sendData = {USERID:userID}; 
	var reSelect = new Array();
	reSelect = SendSelect("./service/user/axUserExist.php",sendData);
	if( 0 < reSelect.length)	
	{
		if( 0 < reSelect[0])
		{
			alert("[" + userID + "]기존에 ID가 있습니다.");
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function axMemeberRegister()
{
	if( true == axUserExist())
	{
		return;
	}
	var userID = document.getElementById("memberID").value;
	var userNick = document.getElementById("memberNick").value;
	var userEmail = document.getElementById("memberEmail").value;
	var userDesc = document.getElementById("memberDesc").value;
	var userPW = document.getElementById("memberPW").value;
	var userCheckPW = document.getElementById("memebercheckPW").value;
	if(( "" == userNick)|| ( "" == userEmail)|| ( "" == userDesc )||("" == userPW)||(""==userCheckPW))
	{
		alert("ID/이름/이메일/자기소개/비밀번호/확인이 모두 채워져야 합니다.");
		return;
	}
	if( userPW != userCheckPW)
	{
		alert("비밀 번호가 다릅니다.");
		return;
	}
	var sendData = {USERID:userID,UNICK:userNick,UEMAIL:userEmail,UDESC:userDesc,UPW:userPW};
	if( true == SendAjaxPost("./service/member/axMemberWrite.php",sendData))
	{
		alert("가입되었습니다.");
	}
	else
	{
		alert("가입이 안되었습니다. 관리자에게 문의 하세요.");
	}
}

//---------------------------------------------------------------------------------------//
function  ShowRereply(postID, replyID)
{
	var starDiv = "rereplyDiv" + replyID;
	var tartDiv = document.getElementById(starDiv);
	tartDiv.style.display = 'block';
	//sTemp ="<form action='writeRereply.php?targetId=";
	//sTemp = sTemp + targetID + "& no=" + pageNo + "& replyID=" + replyID + "'method=post";
	//sTemp = sTemp + " onsubmit='return CheckRreeplyInputs(" + replyID + ")'>";
	sTemp = "<label>답글작성</label>";
	sTemp = sTemp + "<TEXTAREA  name=\"rereplyContent" + replyID + "\" id=\"rereplyContent" + replyID + "\" rows=5 style=\"width:100%;\"></TEXTAREA>";
	sTemp = sTemp + "<br><button class='textButton' onclick='axPostWriteRereply(" + postID + "," + replyID + ")'> [저장]</button>";
	sTemp = sTemp + "&nbsp<button type='button' class='textButton' onclick=\"CloseEditor(\'" + starDiv + "\')\">[취소]</button><br><br>";
	tartDiv.innerHTML = sTemp;
}


function  ShowEditReply(targetID, pageNo, replyID)
{
	var starDiv = "rereplyDiv" + replyID;
	var tartDiv = document.getElementById(starDiv);
	sTemp = "replyContentDIV" + replyID;
	var replyContentDiv = document.getElementById(sTemp);
	var replyContent = replyContentDiv.innerHTML;
	tartDiv.style.display = 'block';
	//sTemp ="<form action='editReply.php?targetId=";
	//sTemp = sTemp + targetID + "& no=" + pageNo + "& replyID=" + replyID + "'method=post";
	//sTemp = sTemp + " onsubmit='return CheckEditReplyInputs(" + replyID + ")'>";
	sTemp = "<label>댓글수정</label>";
	sTemp = sTemp + "<TEXTAREA  name=\"editContent" + replyID + "\" id=\"editContent" + replyID;
	sTemp = sTemp + "\" rows=5 style=\"width:100%;\">" + replyContent +"</TEXTAREA>";
	sTemp = sTemp + "<br><button class='textButton' onclick='axPostModifyReply(" + replyID + ")'> [저장]</button>";
	sTemp = sTemp + "&nbsp<button type='button' class='textButton' onclick=\"CloseEditor(\'" + starDiv + "\')\">[취소]</button><br><br>";
	tartDiv.innerHTML = sTemp;
}


function  ShowEditRereply(targetID, pageNo, replyID)
{
	var starDiv = "editrereplyDiv" + replyID;
	var tartDiv = document.getElementById(starDiv);
	sTemp = "rereplyContentDIV" + replyID;
	var replyContentDiv = document.getElementById(sTemp);
	var replyContent = replyContentDiv.innerHTML;
	tartDiv.style.display = 'block';
		
	//sTemp ="<form action='editReply.php?targetId=";
	//sTemp = sTemp + targetID + "& no=" + pageNo + "& replyID=" + replyID + "'method=post";
//	sTemp = sTemp + " onsubmit='return CheckEditReplyInputs(" + replyID + ")'>";
	sTemp = "<label>답글 수정</label>";
	sTemp = sTemp + "<TEXTAREA  name=\"editContent" + replyID + "\" id=\"editContent" + replyID;
	sTemp = sTemp + "\" rows=5 style=\"width:100%;\">" + replyContent + "</TEXTAREA>";
	sTemp = sTemp + "<br><button class='textButton' onclick='axPostModifyReply(" + replyID + ")'> [저장]</button>";
	sTemp = sTemp + "&nbsp<button type='button' class='textButton' onclick=\"CloseEditor(\'" + starDiv + "\')\">[취소]</button><br><br>";
	tartDiv.innerHTML = sTemp;
	//var textArea = document.getElementById("editContent" + replyID);
//	textArea.value = replyContent;
}

function CloseEditor(hideDiv)
{
	var tartDiv = document.getElementById(hideDiv);
	tartDiv.style.display = 'none';
}