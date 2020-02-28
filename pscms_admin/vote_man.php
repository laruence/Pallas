<?php
require('session.inc');
require('news.php');
switch($glo_language)
{
case 'zh_cn':
	require_once('languages/lang_zh_cn.php');
case 'eng':
	require_once('languages/lang_eng.php');
}
if(empty($_SESSION['log']) || $_SESSION['log']!=true) 
{
	echo "<script>window.location.replace('error.htm')</script>";
	die($lang['unlogged']);
}

?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php echo $lang['vote_man']?></title>
<link href="style.css" rel="stylesheet" type="text/css">

<?php 


if(isset($_GET['action']) && $action == 'manage'){ ?>


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

	$sql="select *, sum(v_voted) as v_total from $T_VOTE  group by v_title order by v_fromtime desc";
$result= mysql_query($sql) or die (mysql_error());
$total=mysql_num_rows($result);
if(!$page)$page =0;

$eachpage=15;
$start=$page*$eachpage;
$end=$start+$eachpage;
if($end>$total) $end =$total;
$totalpage =$total/$eachpage;

$pagestr=$lang['total'].$total.$lang['news'];
if($page>0) $pagestr=$pagestr."[<a href=".$PATH_INFO."?page=".($page-1)."&delete=yes>上一页</a>] ";
$pagestr=$pagestr."[".$lang['rank'];
for ($i=0;$i<$totalpage;$i++)
{
	if ($i!=$page) {$pagestr=$pagestr."<a href=".$PATH_INFO."?page=".$i."&delete=yes>".($i+1)."</a> ";}
	else {$pagestr=$pagestr.($i+1)." ";}
}
$pagestr=$pagestr.$lang['page']."]";

if ($page<($totalpage-1)) $pagestr=$pagestr." [<a href=".$PATH_INFO."?&page=".($page+1)."&delete=yes>$lang[next_page]</a>]";

?>
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<td class="submenu" align=center><?php echo $lang['vote_man']?></td>
  </tr>
  <tr>
	<td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="?action=add"><?php echo $lang['vote_add']?></a> | <a href="?action=manage"><?php echo $lang['man_vote']?></a></td>
  </tr>
</table>

<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<th colspan=9 class="STYLE1"><?php echo $lang['vote_man']?></th>
  </tr>
<form method="post" name="myform" >
  <tr align=center>
	<td class="tablerowhighlight"><?php echo $lang['select']?></td>
	<td width="20%" class="tablerowhighlight"><?php echo $lang['vote_theme']?></td>
	<td width="8%" class="tablerowhighlight"><?php echo $lang['type']?></td>
	<td width="10%" class="tablerowhighlight"><?php echo $lang['enter']?></td>
	<td width="15%" class="tablerowhighlight"><?php echo $lang['start_date']?></td>
	<td width="15%" class="tablerowhighlight"><?php echo $lang['end_date']?></td>
	<td width="8%" class="tablerowhighlight"><?php echo $lang['num']?></td>
	<td width="14%" class="tablerowhighlight"><?php echo $lang['man_op']?></td>
  </tr>
<?php while($total>0&&$rows=mysql_fetch_array($result,MYSQL_BOTH))
{ ?>
  <tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
	<td><input type="checkbox"></td>
	<td><a href="voteview.php?view=result&vtitle=<?php echo $rows['v_title']?>" target='_blank' ><?php echo $rows['v_title'] ?></a></td>
	<td>
<?php echo ($rows['v_type']?多选:单选);?>
</td>
	<td><?php echo $rows['v_author'];?></td>
	<td><?php echo substr($rows['v_fromtime'],0,10);?></td>
	<td><?php echo ($rows['v_totime']?substr($rows['v_totime'],0,10):不限);?></td>
	<td><?php echo $rows['v_total'];?> </td>
	<td><a href="?action=manage&delete=yes&votetitle=<?php echo $rows['v_title'];?>"><?php echo $lang['delete']?></a></td>
  </tr>

<?php   if($votetitle==$rows['v_title']&&$delete=='yes')
{  $sql = "delete from $T_VOTE where v_title='$votetitle'";
$result=mysql_query($sql) or die (mysql_error());
if ($result){
	$action="删除投票: ".$votetitle;
	wLog($_SESSION['loginname'],$date,$action,$ip);
?> 
		 <script>alert("<?php echo $rows['v_title']?>删除成功! "); location.reload();</script>
<?php 
}$total--; 
}
} 
?>
   <tr><td colspan="9" class="tablerowhighlight"> <?php echo $pagestr; ?></td></tr>
</table>
<?php } 
else { 
	if(isset($_GET['commit']) && $_GET['commit'] == 'yes')
	{
		include('news.php');
		$i=$votenum;
		while($i)
		{
			$sql="insert into $T_VOTE(v_title,v_content,v_voted,v_fromtime,v_totime,v_author,v_type) values ('$subject','$voteoption[$i]',0,'$fromtime','$totime','unkown',$type)";
			$result=mysql_query($sql) or die(mysql_error());
			$i--;
		}
		$action="添加投票: ".$subject;
		wLog($_SESSION['loginname'],$date,$action,$ip);?> <script>alert("投票添加成功");window.location.replace('vote_man.php?action=manage');</script><?php  exit;
	}
?>


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
<script type="text/javascript" src="source/MyCalendar.js"></script> 
	<script language="javascript">
	var i=1;
	function AddItem()
	{ 
		i++;
		if(i>50)
		{
			alert("最大只允许50个选项！");
			return;
		}
		document.all.voteitem.innerHTML+="<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='tablerow' align='left' width='8%'>选项"+i+"</td><td class='tablerow' width='92%'><input name='voteoption["+i+"]' type='text' size='50' maxlength='100'></td></tr></table>";
		document.all.votenum.value=i;}
		function ResetItem()
		{ 
			i = 1;
			document.all.voteitem.innerHTML="<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='tablerow' align='left' width='8%'>选项"+i+"</td><td class='tablerow' width='92%'><input name='voteoption["+i+"]' type='text' size='50' maxlength='100'></td></tr></table>";
			document.all.votenum.value=i;}

			function doCheck(){

				// 检测表单的有效性
				// 如：标题不能为空，内容不能为空，等等....
				if (myform.subject.value=="") {
					alert("请输入投票标题!");
					return false;
				}

				if (myform.fromtime.value=="") {
					alert("请输入起始时间!");
					return false;
				}

				if (myform.totime.value=="") {
					alert("请输入结束时间!");
					return false;
				}
				return true;
			}
			</script>

<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<td class="submenu" align=center><?php echo $lang['vote_man']?></td>
  </tr>
  <tr>
	<td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="?action=add"><?php echo $lang['vote_add']?></a> | <a href="?action=manage"><?php echo $lang['man_vote']?></a></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=2 class="STYLE1"><?php echo $lang['vote_add']?></th>
  </tr>
<form method="post" name="myform" action="?action=add&commit=yes" onSubmit="return doCheck()">
		  <tr>
			<td class="tablerow" align="left" valign="middle" width="8%"><?php echo $lang['vote_theme']?></td>
			<td class="tablerow" width="92%"><input name="subject" size="50"  maxlength="100">
			<font color="#FF0000"> *</font></td>
		  </tr>
		  <tr >
			<td class="tablerow" align="left"><?php echo $lang['type']?></td>
			<td class="tablerow">
<input name="type" type="radio" value="0" checked style="border:0">
		<?php echo $lang['single_choice']?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="type" value="1" style="border:0">
		<?php echo $lang['multi_choice']?></td>
		  </tr>
		  <tr >
			<td class="tablerow" align="left"><?php echo $lang['vote_choice']?></td>
			<td class="tablerow">
			  <input type="button" value="<?php echo $lang['add_choice']?>" name="addoption" onClick="AddItem();">
			  <input type="button" value="<?php echo $lang['delete_choice']?>" name="resetoption" onClick="ResetItem();">
			  <input type="hidden" name="votenum" id="votenum" value="1"> </td>
		  </tr>
  <tr>
	<td colspan=2 class="tablerow">
   <div id="voteitem">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
		  <tr> 
			<td class="tablerow" align="left" width="8%"><?php echo $lang['choice1']?></td>
			<td class="tablerow" width="92%">
<input name="voteoption[1]" type="text"  id="voteoption[1]" size="50" maxlength="100">
	</td>
		  </tr>
	  </table>
   </div>
	  </td>
  </tr>
		  <tr>
			<td class="tablerow" align="left"><?php echo $lang['start_date']?></td>
			<td class="tablerow">
<script language=javascript>var dateFrom=new MyCalendar("fromtime","today","<?php echo $lang['select']?>,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>
				<font color="#FF0000">*</font> <?php echo $lang['format']?>：yyyy-mm-dd</td>
		  </tr>
		  <tr>
			<td class="tablerow" align="left"><?php echo $lang['end_date']?></td>
			<td class="tablerow">
<script language=javascript>var dateFrom=new MyCalendar("totime","0","<?php echo $lang['select']?>,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>
				<font color="#FF0000">*</font> <?php echo $lang['tip']?>, <?php echo $lang['format']?>：yyyy-mm-dd</td>
		  </tr>
		  <tr>
			<td class="tablerow" align="left"><?php echo $lang['release']?></td>
			<td class="tablerow">
<input name="passed" type="radio" value="1" checked style="border:0" disabled>
		<?php echo $lang['yes']?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="passed" value="0" style="border:0" disabled>
		<?php echo $lang['no']?></td>
		  </tr>
			<tr><td class="tablerow" align="left"></td>
			<td class="tablerow">
				<input type="submit" value=" <?php echo $lang['submit']?> " name="submit" >
				 <input type="reset" value=" <?php echo $lang['clear']?> " name="reset"></tr>
			</td>
		  </tr>

  </form>
</table>
</form>
<?php } ?> <table height="100" border="0" > <td></td></table>
</html>
