<?php 
require('session.inc');

if(empty($_SESSION['log']) && $_SESSION['log']!=true)
{ //check login? 
	echo "<script>window.location.replace('error.htm')</script>";
	exit();
}
require('news.php');
switch($glo_language)
{
case 'zh_cn':
	require('languages/lang_zh_cn.php');
case 'eng':
	require('languages/lang_eng.php');
}
if($action == 'add'){
	if($_SESSION['grad']!=1) echo "<script>alert('对不起，您不是超级管理员，不能添加用户！');window.location.replace('user_man.php?action=view');</script>";
	if($commit==yes)
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$scrt=rand();
		$pwdconfirm=$pwdconfirm.$scrt;
		$pwdconfirm=md5($pwdconfirm);
		$time=date(YmdHis);
		$sql="insert into $T_USERS(ad_name,ad_pswd,ad_email,ad_lastip,ad_lasttime,ad_grad,ad_scrt)values('$name','$pwdconfirm','$email','$ip','$time','$grade','$scrt')";
		$result=mysql_query($sql) or die (mysql_error());
		if($result){
			$action="添加会员: ".$name;
			wLog($_SESSION['loginname'],$date,$action,$ip);
			echo "<script>alert('".$name."添加成功!');window.location.replace('user_man.php?action=view');</script>";
		}}
?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php echo $lang['user_add']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
		<script language="JavaScript">
		/* Create a new XMLHttpRequest object to talk to the Web server */
		var error=0;
		function init()
		{
			var xmlHttp = false;

			try {
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e2) {
					xmlHttp = false;
				}
			}

			if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
				xmlHttp = new XMLHttpRequest();
			}
			return xmlHttp;
		}
		function Check_user( username)
		{//使用AJAX技术 验正用户名唯一性
			if(username.length<5) 
			{
				document.getElementById("checkstate").innerHTML="<img src='source/check_error.gif'> <font color=red>您输入的用户名太短,请重新输入!</font>";
				return;
			}
			xmlHttp=init();
			var user = document.getElementById("name").value;
			// Only go on if there are values for both fields
			if ((user == null) || (user == "")) return;

			// Build the URL to connect to
			var url = "./check.php?user="+escape(user);
			// Open a connection to the server
			xmlHttp.open("GET", url, true);
			// Setup a function for the server to run when it's done
			xmlHttp.onreadystatechange = updatePage;
			// Send the request
			xmlHttp.send(null);

		}

		function updatePage() {
			if (xmlHttp.readyState == 4) {
				var response = xmlHttp.responseText;
				if(response==1)
				{ 
					document.getElementById("checkstate").innerHTML = " <img src='source/check_error.gif'> <font color=red>此用户名已经存在!</font>";
					error=1;
				}

				else
				{ 
					document.getElementById("checkstate").innerHTML = "<img src='source/check_right.gif'> ";
					error=0;
				}

			}
		}


		function checkall(form) {
			for(var i = 0;i < form.elements.length; i++) {
				var e = form.elements[i];
				if (e.name != 'chkall' && e.disabled != true) {
					e.checked = form.chkall.checked;
				}
			}
		}

		function redirect(url) {
			window.location.replace(url);
		}
		</script>
</head>
<body>
		<script LANGUAGE="javascript">
		<!--
			function Check() {
				if (document.myform.name.value=="")
				{
					alert("请输入帐号")
						document.myform.name.focus()
						return false
				}
				if (document.myform.password.value=="")
				{
					alert("请输入密码")
						document.myform.password.focus()
						return false
				}
				if (document.myform.pwdconfirm.value=="")
				{
					alert("请输入确认密码")
						document.myform.pwdconfirm.focus()
						return false
				}
				if (document.myform.pwdconfirm.value!=document.myform.password.value)
				{
					alert("两次输入的密码不一致")
						document.myform.pwdconfirm.focus()
						document.myform.pwdconfirm.select()
						return false
				}
				if (document.myform.email.value=="")
				{
					alert("请输入E-mail")
						document.myform.email.focus()
						return false
				}
				if(error)
				{
					alert("请重新输入用户名")
						document.myform.name.focus()
						return false

				}
				GetCatPurview();
			}

		function GetCatPurview(){
			document.myform.catinputer_article.value='';
			document.myform.catchecker_article.value='';
			document.myform.catmaster_article.value='';
			if(document.myform.purview_article[2].checked==true){
				for(var i=0;i<frmArticle.document.myform.purview_add.length;i++){
					if (frmArticle.document.myform.purview_add[i].checked==true){
						if (document.myform.catinputer_article.value=='')
							document.myform.catinputer_article.value=frmArticle.document.myform.purview_add[i].value;
						else
							document.myform.catinputer_article.value+=','+frmArticle.document.myform.purview_add[i].value;
					}
				}
				for(var i=0;i<frmArticle.document.myform.purview_check.length;i++){
					if (frmArticle.document.myform.purview_check[i].checked==true){
						if (document.myform.catchecker_article.value=='')
							document.myform.catchecker_article.value=frmArticle.document.myform.purview_check[i].value;
						else
							document.myform.catchecker_article.value+=','+frmArticle.document.myform.purview_check[i].value;
					}
				}
				for(var i=0;i<frmArticle.document.myform.purview_manage.length;i++){
					if (frmArticle.document.myform.purview_manage[i].checked==true){
						if (document.myform.catmaster_article.value=='')
							document.myform.catmaster_article.value=frmArticle.document.myform.purview_manage[i].value;
						else
							document.myform.catmaster_article.value+=','+frmArticle.document.myform.purview_manage[i].value;
					}
				}
			}
		}

		function check_password()
		{
			pw=document.myform.password.value;
			pwb=document.myform.pwdconfirm.value;
			if(pw=="" || pwb=="") return;
			if(pw==pwb) 
			{
				document.getElementById('pwstatus').innerHTML="<img src='source/check_right.gif'> ";
				error++;
			}
			else
			{
				document.getElementById('pwstatus').innerHTML="<img src='source/check_error.gif'>  <font color=red>俩次输入的密码不一样</font>";
			}

		}

		function check_email()
		{
			var e = document.getElementById("email").value;

			if(e == "")  return;

			if(!/(\S)+[@]{1}(\S)+[.]{1}(\w)+/.test(e)) 
			{
				document.getElementById('emstatus').innerHTML="<img src='source/check_error.gif'>  <font color=red>错误的Email地址</font>";
				return ;
			} 
			else
			{
				document.getElementById('emstatus').innerHTML="<img src='source/check_right.gif'> ";
				return ;
			}

		}

		//-->
		</script>
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" >
  <tr>
	<td class="submenu" align=center><?php echo $lang['meber_man']?></td>
  </tr>
  <tr>
	<td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="?action=add"><?php echo $lang['meber_add']?></a> | <a href="?action=manage"><?php echo $lang['meber_man']?></a> | <a href="?action=chgpw"><?php echo $lang['meber_chpw']?></a></td>
  </tr>
</table>

<table width="100%" cellpadding="2" cellspacing="1">
  <tr>
	<th colspan=2 class="STYLE1"><?php echo $lang['meber_add']?></th>
  </tr>
  <form method="post" name="myform" onSubmit="return Check()" action="?action=add&commit=yes">
	<tr>
	  <td class="tablerow"  width="10%"><?php echo $lang['account']?></td>
	  <td class="tablerow" ><input name="name" type="text" id="name" size="20" onChange="Check_user(this.value)">
		  <span id="checkstate" ></span></td>
	</tr>
	<tr>
	  <td class="tablerow" ><?php echo $lang['password']?></td>
	  <td class="tablerow" ><input name="password2" type="password" id="password2" size="21" onChange="check_password();"></td>
	</tr>
	<tr>
	  <td class="tablerow"  ><?php echo $lang['submit_pw']?></td>
	  <td class="tablerow" ><input name="pwdconfirm2" type="password" id="pwdconfirm2" size="21" onChange="check_password();">
		  <span id="pwstatus"></span></td>
	</tr>
	<tr>
	  <td class="tablerow" >E-mail</td>
	  <td class="tablerow" ><input name="email" type="text" id="email" size="20" onChange="check_email();">
		  <span id="emstatus"></span></td>
	</tr>
	<tr>
	  <td class="tablerow"  align="right"><?php echo $lang['globel_right']?></td>
	  <td class="tablerow" ><input name='grade' type='radio' value='1'   onClick="purviewdetail.style.display='none'" >
		<?php echo $lang['super_man']?><br>
		<input name='grade' type='radio' value='0' checked onClick="purviewdetail.style.display=''"  >
		<?php echo $lang['normal_man']?><br></td>
	</tr>
	<tr>
	  <td class="tablerow"  align="right">&nbsp;</td>
	  <td class="tablerow" ><input type="submit" name="submit2" value="<?php echo $lang['submit']?>"></td>
	</tr>
  </form>
</table>
</body>
</html>
<?php }
else if($action == 'chgpw') //修改密码
{ 
	if($commit == 'yes')
	{ 
		$old_password=trim($old_password);
		$pwdconfirm=trim($pwdconfirm);
		$sql="select * from $T_USERS where ad_id=$loginid";
		$result=mysql_query($sql) or die (mysql_error());
		$old_confirm_pswd=mysql_result($result,0,'ad_pswd');
		$secret=mysql_result($result,0,'ad_scrt');
		$old_password=md5($old_password.$secret);
		if($old_password==$old_confirm_pswd){
			$scrt=rand();
			$oripswd=$pwdconfirm;
			$pwdconfirm=$pwdconfirm.$scrt;

			$pwdconfirm=md5($pwdconfirm);
			$sql="update $T_USERS set ad_pswd='$pwdconfirm',ad_scrt='$scrt' where ad_id=$loginid";
			$result=mysql_query($sql) or die(mysql_error());
			if($result) {     
				$action="修改密码";
				wLog($_SESSION['loginname'],$date,$action,$ip);
				echo "<script>alert(\"密码修改成功，请牢记您的新密码:".$oripswd."！\");window.location.replace('user_man.php?action=view');</script>";}
		}
		else
		{
			echo "<script>alert(\"原密码输入错误，请重新填写\");window.location.replace('user_man.php?action=chgpw');</script>";
		}

	}

?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php echo $lang['meber_chpw']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
	function checkall(form) {
		for(var i = 0;i < form.elements.length; i++) {
			var e = form.elements[i];
			if (e.name != 'chkall' && e.disabled != true) {
				e.checked = form.chkall.checked;
			}
		}
	}

	function redirect(url) {
		window.location.replace(url);
	}
	</script>
</head>
<body>
	<script LANGUAGE="javascript">
	<!--
		function Check() {
			if (document.myform.old_password.value=="")
			{
				alert("请输入原密码")
					document.myform.password.focus()
					return false
			}
			if (document.myform.password.value=="")
			{
				alert("请输入新密码")
					document.myform.password.focus()
					return false
			}
			if (document.myform.pwdconfirm.value=="")
			{
				alert("请输入确认密码")
					document.myform.pwdconfirm.focus()
					return false
			}
			if (document.myform.pwdconfirm.value!=document.myform.password.value)
			{
				alert("两次输入的密码不一致！")
					document.myform.pwdconfirm.focus()
					document.myform.pwdconfirm.select()
					return false
			}
		}

	//-->
	</script>

<table width="100%" cellpadding="2" cellspacing="1" border="0" align=center >
  <tr>
	<td class="submenu" align=center><?php echo $lang['meber_man']?></td>
  </tr>
  <tr>
 <td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="?action=add"><?php echo $lang['meber_add']?></a> | <a href="?action=manage"><?php echo $lang['meber_man']?></a> | <a href="?action=chgpw"><?php echo $lang['meber_chpw']?></a></td>
  </tr>
</table>

</table>
<table width="100%" cellpadding="2" cellspacing="1" >
  <tr>
	<th colspan=2><?php echo $lang['meber_chpw']?></th>
  </tr>
<form method="post" name="myform" onSubmit="return Check()" action="?action=chgpw&commit=yes">
 <tr>
	<td class="tablerow" align="right"><?php echo $lang['ur_name']?></td>
	<td class="tablerow" ><?php echo $_SESSION['loginname']?></td>
  </tr>
  <tr>
	<td class="tablerow" align="right"><?php echo $lang['formal_pw']?></td>
	<td class="tablerow" ><input name="old_password" type="password" id="old_password" size="15"></td>
  </tr>
  <tr>
	<td class="tablerow" align="right"><?php echo $lang['new_pw']?></td>
	<td class="tablerow" ><input name="password" type="password" id="password" size="15"></td>
  </tr>
  <tr>
	<td class="tablerow"  align="right"><?php echo $lang['confirm_pw']?></td>
	<td class="tablerow" ><input name="pwdconfirm" type="password" id="pwdconfirm" size="15"></td>
  </tr>
  <tr>
	<td class="tablerow"  align="right">&nbsp;</td>
	<td class="tablerow" ><input type="submit" name="submit" value="确定">
</td>
  </tr>
</form>
</table>
</body>
</html>
<?php }
else  //查看用户
{
	if($lock==yes)
	{
		if($_SESSION['grad']!=1) {echo "<script>   	         alert('对不起，您不是超级管理员，没有权限执行此操作！');window.location.replace('user_man.php?action=view');</script>";}
		else {  $sql="update $T_USERS set ad_lock=ad_lock xor 1 where ad_id=$uid";
		if(mysql_query($sql)) echo "<script>alert('操作成功!');window.location.replace('user_man.php?action=view');</script>";
		else die(mysql_error());}}
		if($delete==yes)
		{ 
			if($_SESSION['grad']!=1) {echo "<script>   	    						alert('对不起，您不是超级管理员，没有权限执行此操作！');window.location.replace('user_man.php?action=view');</script>";}
			else 
			{
				$sql="select count(*) as num from $T_USERS where ad_grad=1";
				$result=mysql_query($sql) or die(mysql_error());
				$num=mysql_result($result,0,'num');
				$sql="select * from $T_USERS where ad_id=$uid";
				$result=mysql_query($sql) or die(mysql_error());
				$grd=mysql_result($result,0,'ad_grad');
				$uname=mysql_result($result,0,'ad_name');
				if($num==1&&$grd==1) 
				{
					echo "<script>   	      	alert('对不起，无法完成操作，系统必须保留一个超级管理员!');window.location.replace('user_man.php?action=view');</script>";
				}
				else 
				{

					if($uid==$loginid)
					{
						echo "<script>alert('对不起，您不能删除自己!');window.location.replace('user_man.php?action=view');</script>";
					}
					else
					{
						$sql="delete  from $T_USERS where ad_id=$uid";
						if(mysql_query($sql)) 
						{
							$action="删除会员: ".$uname;
							wLog($_SESSION['loginname'],$date,$action,$ip);
							echo "<script>alert('操作成功!');window.location.replace('user_man.php?action=view');</script>";

						}else die(mysql_error());
					}
				}
			}
		}
?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php echo $lang['meber_list']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="source/function.js"></script>
		<script language="JavaScript">
		function checkall(form) {
			for(var i = 0;i < form.elements.length; i++) {
				var e = form.elements[i];
				if (e.name != 'chkall' && e.disabled != true) {
					e.checked = form.chkall.checked;
				}
			}
		}

		function redirect(url) {
			window.location.replace(url);
		}
		</script>
</head>
<body>

<?php 
		$sql="select * from $T_USERS order by ad_grad desc";
		$result=mysql_query($sql) or die  (mysql_error());
?>

<table width="100%" cellpadding="2" cellspacing="1" border="0" align=center >
  <tr>
	<td class="submenu" align=center><?php echo $lang['meber_man']?></td>
  </tr>
  <tr>
	<td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="?action=add"><?php echo $lang['meber_add']?></a> | <a href="?action=manage"><?php echo $lang['meber_man']?></a> | <a href="?action=chgpw"><?php echo $lang['meber_chpw']?></a></td>
  </tr>
</table>

<table width="100%" cellpadding="2" cellspacing="1" >
  <tr>
	<th colspan=7><?php echo $lang['meber_man']?></th>
  </tr>
<tr align=center>
<td width="10%" class="tablerowhighlight"><?php echo $lang['account']?></td>
<td width="15%" class="tablerowhighlight"><?php echo $lang['degree']?></td>
<td width="18%" class="tablerowhighlight">E-mail</td>
<td width="8%" class="tablerowhighlight"><?php echo $lang['login_times']?></td>
<td width="16%" class="tablerowhighlight"><?php echo $lang['last_login_time']?></td>
<td width="12%" class="tablerowhighlight"><?php echo $lang['last_login_ip']?></td>
<td width="20%" class="tablerowhighlight"><?php echo $lang['man_op']?></td>
</tr>
<?php while ( $rows=mysql_fetch_array($result,MYSQL_BOTH))
		{
?>
<tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class=forumrow><?php echo $rows['ad_name']?></td>
<td class=forumrow>
<?php echo $rows['ad_grad']?"超级管理员":"普通管理员";?></td>
<td class=forumrow><a href="mailto:<?php echo $rows['ad_email']?>" onclick=><?php echo $rows['ad_email']?></a></td>
<td class=forumrow><?php echo $rows['ad_logintimes']?></td>
<td class=forumrow><?php echo $rows['ad_lasttime']?></td>
<td class=forumrow><?php echo $rows['ad_lastip']?></td>
<td class=forumrow align=center>
<a href='?action=view&lock=yes&uid=<?php echo $rows['ad_id']?>'><?php echo $rows['ad_lock']?"解锁":"锁定";?></a>
 | <a href='?action=view&delete=yes&uid=<?php echo $rows['ad_id']?>' onClick="return MakeSure(this.href,'删除会员<?php echo $rows['ad_name']?>')"><?php echo $lang['delete']?></a></td>
</tr>
<?php }//while?>
<tr>
<th  colspan="7">&nbsp;</th>
</tr>

</table>
</body>
</html>
<?php } ?>
