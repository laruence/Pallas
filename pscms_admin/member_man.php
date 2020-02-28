<?php 
require('session.inc');
if(empty($_SESSION['log']) && $_SESSION['log']!=true)
{ //check login? 
	echo "<script>window.location.replace('error.htm')</script>";
	die(0054);
}
require_once('news.php');
switch($glo_language)
{
case 'zh_cn':
	require_once('languages/lang_zh_cn.php');
case 'eng':
	require_once('languages/lang_eng.php');
}
if($action == "del")
{
	$sql="delete from $T_MBER where mb_id=$id";
	$result=mysql_query($sql) or die(mysql_error());
	if($result)
	{
		echo "<script> alert('删除成功');window.location.replace('member_man.php');</script>";
		exit();
	}

}

if($action== "pass")
{

	$sql="update $T_MBER set mb_pass = 1 where mb_id=$id";
	$result=mysql_query($sql) or die(mysql_error());
	if($result)
	{
		echo "<script> alert('审核成功');window.location.replace('member_man.php');</script>";
		exit();
	}


}

if($action=="lock")

{


	$sql="update $T_MBER set mb_lock = mb_lock xor 1 where mb_id = $id";
	$result=mysql_query($sql) or die(mysql_error());
	if($result)
	{
		echo "<script> alert('操作成功');window.location.replace('member_man.php');</script>";
		exit();
	}

}




if($page=="") $page=1;
$eachpage=20;
$start =($page-1)*$eachpage;
$end = $start +  $eachpage;
if($show=="all" || $show=="")
{
	$sql="select  * from $T_MBER order by mb_redate desc limit $start ,$end";
	$total=mysql_query("select count(*) as total from $T_MBER ");
}
else if($show=="pass")
{
	$sql="select  * from $T_MBER where mb_pass=1 order by mb_redate desc limit $start ,$end";
	$total=mysql_query("select count(*) as total from $T_MBER where mb_pass=1");

}

else if($show=="vip")
{
	$sql="select  * from $T_MBER where mb_grade>0 order by mb_redate desc limit $start ,$end";
	$total=mysql_query("select count(*) as total from $T_MBER where mb_grade>0");

}
$result=mysql_query($sql) or die(mysql_error());
$total=mysql_result($total,0,'total');
$totalpage=(int)($total/$eachpage);
if($total % $eachpage!=0) $totalpage++;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>会员管理</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="sources/common.js"></script>
<script language="javascript">

function checkall(form)
{
	obj=document.getElementsByName("userid[]");

	if(obj[0].checked==false)
	{

		for(i=0;i<obj.length;i++)
		{
			obj[i].checked=true;
		}

	}
	else
	{

		for(i=0;i<obj.length;i++)
		{
			obj[i].checked=false;
		}


	}

}

</script>

</head><body>
<form method="post" name="myform"><table width="100%" cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
			   <tr>
				   <td class='submenu' align=center>
					 <table cellpadding='0' cellspacing='0' border='0' width='100%' height='10'>
					  <tr>
						<td class='submenu' width='7%'></td>
						<td class='submenu' align='center'>会员管理</td>
						<td class='submenu' width='7%'  align='right'>	</td>
					  </tr>
					</table>
					 </td>
			   </tr>
</table>

<table width="100%" cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
	<td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="?action=add"><?php echo $lang['meber_add']?></a> | <a href="?action=manage"><?php echo $lang['meber_man']?></a> | <a href="?action=chgpw"><?php echo $lang['meber_chpw']?></a></td>
  </tr>
  <tr>
	<td   bgcolor="#CCCCCC" align="center"><a href="?show=all" class='pagelink'>所有会员</a>
	| <a href="?show=pass" class='pagelink'>注册用户</a>| <a href="?show=vip" class='pagelink'>VIP会员</a>
</td>
  </tr>
</table>

<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=12>会员管理</th>
  </tr>
<tr align=center>
<td width="4%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="12%" class="tablerowhighlight">帐号</td>
<td width="4%" class="tablerowhighlight">性别</td>
<td width="9%" class="tablerowhighlight">QQ</td>
<td width="9%" class="tablerowhighlight">MSN</td>
<td width="9%" class="tablerowhighlight">E-MAIL</td>
<td width="9%" class="tablerowhighlight">注册时间</td>
<td width="9%" class="tablerowhighlight">权限</td>
<td width="9%" class="tablerowhighlight">已审核</td>
<td width="5%" class="tablerowhighlight">锁定</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php while ($rows=mysql_fetch_array($result,MYSQL_BOTH))
		{
			if($rows[mb_gender]) $sex="<font color=red>F</font>";
			else $sex="<font color=blue>M</font>";
			if($rows[mb_pass]) $pass="<font color=blue>√</font>"; else $pass="<font color=red>×</font>";
			$lock= $rows['mb_lock']? "<font color=blue>√</font>":"<font color=red>×</font>";
			$lock_do=$rows['mb_lock']? "解锁":"锁定";
			echo <<< EOT

				<tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
				<td class=forumrow><input type="checkbox" name="userid[]"  id="userid[]" value="$rows[mb_id]"><input type="hidden" name="usermail[$rows[mb_id]]" value="$rows[mb_email]"></td>
				<td class=forumrow>$rows[mb_id]</td>
				<td class=forumrow><a href="sendmail.php?sendto=$rows[mb_email]"  title="最后登录时间：$rows[mb_lasttime]&#10最后登录IP：$rows[mb_lastip]&#10登录次数：$rows[mb_logons]">$rows[mb_name]</a></td>
				<td class=forumrow>$sex</td>
				<td class=forumrow>$rows[mb_qq]</td>
				<td class=forumrow>$rows[mb_msn]</td>
				<td class=forumrow>$rows[mb_email]</td>
				<td class=forumrow>$rows[mb_redate]</td>
				<td class=forumrow>$rows[mb_grade]</td>
				<td class=forumrow>$pass</td>
				<td class=forumrow>$lock</td>
				<td class=forumrow align=center>  
				<a href='?action=del&id=$rows[mb_id]'>删除</a>|<a href='?action=lock&id=$rows[mb_id]'>$lock_do</a>|<a href='?action=pass&id=$rows[mb_id]'>审核</a>
				</td>
				</tr>
EOT;
		}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
	<td>
<input type="submit" name="submit" value="发送Email到选定用户" onClick="document.myform.action='sendmail.php?type=group'">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量解锁" onClick="document.myform.action='?mod=member&file=member&action=lock&val=0'">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量删除" onClick="document.myform.action='?mod=member&file=member&action=delete'">&nbsp;&nbsp;
</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
	<td align="center">总数:<b><?php echo $total?></b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?page=1">首页</a>&nbsp;<?php if($page>1){?>
	  <a href="?page=<?php echo $page-1?>">上一页</a><?php } if ($page<$totalpage){ ?>&nbsp;<a href="?page=<?php echo $page+1?>">下一页</a><?php } ?>&nbsp;页次：<b><font color=red><?php echo $page?></font>/<?php echo $totalpage?></b>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
