// SranM Guestbook Version 2.2
// Common JavaScript


// 带确认的超链接
function go(URL,cfmText)
{
	var ret;
	ret = confirm(cfmText);
	if(ret!=false)window.location=URL;
}

// 打开自定义窗口
function openwin(URL, width, height)
	{
	var win = window.open(URL,"openscript",'width=' + width + ',height=' + height + ',resizable=0,scrollbars=1,menubar=0,status=1');
	}

// 打开查看回复的窗口
function openreply()
	{
	document.viewreply.replycodes.value=document.replyform.replycode.value;
	var popupwin = window.open('viewreply.asp', 'viewreply_page', 'scrollbars=yes,width=700,height=450');
	document.viewreply.submit()
	}

// 检查必填项
function Submitcheck()
	{
	if (document.lw_form.username.value.length==0){
	alert("请输入您的称呼，此为必填项！");
	document.lw_form.username.focus();
	return false;
		}
	if (document.lw_form.usercontent.value.length==0){
	alert("请输入留言正文，此为必填项！");
	document.lw_form.usercontent.focus();
	return false;
		}
	return true
	}

// 选中全部复选框
function CheckAll(form)
	{
	for (var i=0;i<form.elements.length;i++){
	var e = form.elements[i];
	if (e.name != 'chkall')
		e.checked = form.chkall.checked;
		}
	}

// 页面跳转
function MM_jumpMenu(targ,selObj,restore)
	{
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
	}

// 确认批量操作
function SetSubmitType(sub_type)
	{
	if (confirm("确定要执行批量操作吗？")){
	SetSubmitType = sub_type;
		}
	}

// 选择操作类型
function Submit_all(theForm)
	{
	var flag = false;
		if ( SetSubmitType == 'del'){
			flag = true;
			theForm.action = theForm.action + "del";
		}
		else if (SetSubmitType == 'check'){
			flag = true;
			theForm.action = theForm.action + "check";
		}
	return flag;
	}