<?php 
require('session.inc');
require('news.php');
if(empty($_SESSION['log']) && $_SESSION['log']!=true){
	//check login? 
	echo "<script>window.location.replace('error.htm')</script>";
	die(0054);
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>栏目管理 </title>
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
function doCheck(){
	// 检测表单的有效性
	// 如：标题不能为空，内容不能为空，等等....
	if (myform.catid.value==""||parseInt(myform.catid.value)==NaN||myform.catid.value<=0||myform.catid.value>=70)
	{
		alert("请正确输入栏目ID");
		document.myform.catid.focus();
		return false;
	}
	if (myform.catname.value=="") {
		alert("请输入栏目标题");
		document.myform.catname.focus();
		return false;
	}
	//alert(myform.cattype);
	if (myform.cattype.value==0 && myform.linkurl.value=="") {
		alert("请输入外部链接地址");
		myform.linkurl.focus();
		return false;
	}
}
function redirect(url) {
	window.location.replace(url);
}
</script>
</head>
<body>
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<td class="submenu" align=center>栏目管理</td>
  </tr>
  <tr>
	<td class="tablerow"><b>管理选项：</b><a href="?action=add">栏目添加</a> | <a href="?action=manage">栏目管理</a></td>
  </tr>
</table>

<?php 
$sql="select * from $T_CAT where cat_parent=0 order by cat_id";
$result=mysql_query($sql) or die(mysql_error());
if(isset($_GET['commit']) && $_GET['commit'] == 'yes')
{
	$sql="insert into  $T_CAT(cat_id,cat_title,cat_content,cat_link,cat_url,cat_parent,cat_order,cat_name, cat_attr, cat_static) values('$catid','$catname','$description','$cattype','$linkurl','$parentid','$catorder', '$cat_path', '$attrs', '$static')";
	$result=mysql_query($sql) or die(mysql_error());
	if($result) {
		refrestSrot();
		$action = "添加栏目: ".$catname;
		wLog($_SESSION['loginname'],$date,$action,$ip);
		echo "<script>alert('".$catname."添加成功!'); window.location.replace('sort_man.php?action=add');</script>";
	}
}

if($delete == 'all'){
	if($_SESSION['grad']!=1) {
		echo "<script>alert('对不起，您不是超级管理员，没有权限执行此操作！');window.location.replace('sort_man.php?action=manage');</script>";}
	else{
		if($parentid==0){
			$sql="delete from $T_NEWS where news_cat=$id";
		}
		else{
			$sql="delete from $T_NEWS where news_cat=$parentid and news_spec=$id";
		}

		$result=mysql_query($sql) or die(mysql_error());
		if($result) 
			echo "<script>alert('操作成功! 删除相关记录".mysql_affected_rows()."条!'); window.location.replace('sort_man.php?action=manage');</script>";
	}
}

if($delete == 'yes')
{
	if($_SESSION['grad']!=1) {echo "<script> alert('对不起，您不是超级管理员，没有权限执行此操作！');window.location.replace('sort_man.php?action=manage');</script>";}
	else
	{
		$sql="delete from $T_CAT where cat_id=$id and cat_parent=$parentid";
		$result=mysql_query($sql) or die(mysql_error());
		if($result) 
		{
			refrestSrot();
			$action="删除栏目: ".$catname;
			wLog($_SESSION['loginname'],$date,$action,$ip);
			echo "<script>alert('".$catname."删除成功!'); window.location.replace('sort_man.php?action=manage');</script>";
		}
	}
}
if(isset($_GET['edit']) && $_GET['edit'] == 'yes'){
	if(isset($_GET['commit']) && $_GET['commit'] == 'edit')
	{
		if($_SESSION['grad']!=1){
			echo "<script> alert('对不起，您不是超级管理员，没有权限执行此操作！');window.location.replace('sort_man.php?action=manage');</script>";
			exit();
		}

		$sql="update $T_CAT set cat_id='$catid',cat_title='$catname' ,cat_content='$description',cat_parent='$parentid',cat_link='$cattype',cat_url='$linkurl', cat_name = '$cat_path', cat_attr = '$attrs' , cat_static='$static'  where cat_id=$id and cat_parent=$parentid";
		$result=mysql_query($sql) or die(mysql_error());
		if($result) {
			refrestSrot();
			echo "<script>alert('修改成功!'); window.location.replace('sort_man.php?action=manage');</script>";
		}
	}
	$sqledit="select * from $T_CAT where cat_id=$id and cat_parent=$parentid";
	$resultedit=mysql_query($sqledit) or die (mysql_error());
	$rowsedit = mysql_fetch_array($resultedit,MYSQL_BOTH);
?>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=2 class="STYLE1">栏目修改</th>

  </tr>
  <form name="myform" method="post" action="?commit=edit&edit=yes&id=<?php echo $id?>&parentid=<?php echo $parentid?>" onSubmit="return doCheck();">
	<tr>
	  <td width="8%" class="tablerow">栏目ID </td>
	  <td width="92%" class="tablerow"><input name="catid" id="catid" size="2"  maxlength="2" value="<?php echo $rowsedit['cat_id']?>"  readonly="readonly" > <font color="#FF0000">请您一定确保ID没有被使用!!</td>
	</tr>
	<tr>
	  <td class="tablerow">所属栏目</td>
	  <td class="tablerow"><select name='parentid'  disabled="disabled">
		<option value='0'>无（作为一级栏目）</option>
<?php 
	while($rows=mysql_fetch_array($result,MYSQL_BOTH))
	{
		if($parentid==$rows['cat_id'])
			echo "<option value='".$rows['cat_id']." selected'>".$rows['cat_title']."</option>";
		echo "<option value='".$rows['cat_id']."'>".$rows['cat_title']."</option>";

	}
?>
	  </select>
	  </td>
	</tr>
	<tr>
	  <td class="tablerow">栏目名称</td>
	  <td class="tablerow"><input size=30 name="catname" type=text value="<?php echo $rowsedit['cat_title']?>"></td>
	</tr>
	<tr>
	  <td class="tablerow">栏目Path</td>
	  <td class="tablerow"><input size=30 name="cat_path" type=text value='<?php echo $rowsedit['cat_name']?>'> *英文，数字组合</td>
	</tr>
	<tr>
	  <td class="tablerow">栏目说明</td>
	  <td class="tablerow"><textarea name='description' cols='40' rows='3' id='description'value="<?php echo $rowsedit['cat_content']?>" ></textarea>
	  </td>
	</tr>
	<tr>
<?php
	$checked = array('','checked');
	if($rowsedit['cat_attr']){
		$checked = array('checked', '');
	}
	echo <<<HTML
	  <td class="tablerow">是否解释性栏目</td>
	  <td class="tablerow"><input name='attrs' type='radio' value='1' {$checked[0]}>
		是&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='attrs' value='0' {$checked[1]}>
		否</td>
HTML;
?>
	</tr>
	<tr>
<?php
	$checked = array('checked','');
	if($rowsedit['cat_static']){
		$checked = array('', 'checked');
	}
	echo <<<HTML
	  <td class="tablerow">栏目类型</td>
	  <td class="tablerow"><input type='radio' name='static' value='0' {$checked[0]}>
		动态栏目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name='static' type='radio' value='1' {$checked[1]}>
		静态栏目</td>
HTML;
?>
	</tr>
	<tr>
	  <td class="tablerow">栏目类型</td>
	  <td class="tablerow"><table>
		<tr>
		  <td class="tablerow"><fieldset>
			<legend>
			  <input name='cattype' type='radio' value='1' checked onClick="ClassSettings.style.display=''">
			  <font color=blue><b>系统内部栏目</b></font></legend>
			&nbsp;&nbsp;&nbsp;&nbsp;系统内部栏目具有详细的参数设置。可以添加子栏目和文章。<br>
			<table id='ClassSettings' width='100%' border='0' cellpadding='2' cellspacing='1' style='display:'>
			  <tr>
				<td class="tablerowhighlight" colspan='2' align='center'>内部栏目参数设置</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否在父栏目的分类列表处显示</strong><br>
				  如果某栏目下有几十个子栏目，但只想显示其中几个子栏目的文章列表，这个选项就非常有用。</td>
				<td class="tablerow"><input name='islist' type='radio' value='1' checked>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type='radio' name='islist' value='0'>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>有子栏目时是否可以在此栏目添加文章</strong></td>
				<td class="tablerow"><input name='enableadd' type='radio' value='1' disabled >
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input  disabled type='radio' name='enableadd' value='0' checked>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否允许评论</strong><br></td>
				<td class="tablerow"><input name='enablecomment' type='radio' value='1'  disabled checked>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type='radio'  disabled name='enablecomment' value='0'>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否允许投稿</strong><br></td>
				<td class="tablerow"><input name='enablecontribute' type='radio' value='1' disabled checked>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input  disabled type='radio' name='enablecontribute' value='0'>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否启用此栏目的防止复制、防盗链功能</strong></td>
				<td class="tablerow"><input name='enableprotect' type='radio' value='1' disabled>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input  disabled type='radio' name='enableprotect' value='0' checked>
				  否</td>
			  </tr>
			  <tr>
				<td width='300' class="tablerow" ><b>此栏目下的文章列表的排序方式</b></td>
				<td class="tablerow"><select name='ordertype' disabled>
				  <option value='1' selected>文章ID降序</option>
				  <option value='2'>文章ID升序</option>
				  <option value='3'>点击次数降序</option>
				  <option value='4'>点击次数升序</option>
				</select></td>
			  </tr>
			</table>
			</fieldset>
				<br>
				<fieldset>
				  <legend>
					<input name='cattype' type='radio' value='0' disabled="disabled" onClick="ClassSettings.style.display='none'">
					<font color=blue><b>外部栏目</b></font></legend>
				   当此栏目准备链接到网站中的其他系统时，请使用这种方式。不能在外部栏目中添加文章，也不能添加子栏目。<br>
				  &nbsp;&nbsp;&nbsp;&nbsp;外部栏目的链接地址
				  <input name='linkurl' type='text' id='linkurl' size='40' maxlength='200'>
				  <br>
				  <br>
			  </fieldset>
			<br>
		  </td>
		</tr>
	  </table></td>
	</tr>
	<tr>
	  <td class="tablerow"></td>
	  <td class="tablerow"><input name="submit" type=submit value="确定">
		  <input name="reset" type=reset value="清除"></td>
	</tr>
  </form>
</table>

<?php 
}
if($action == 'add')
{
	$max_sql="select MAX(cat_id) as max_id from $T_CAT ";
	$max_result=mysql_query($max_sql) or die (mysql_error());
	$max_cat_id=mysql_result($max_result,0,'max_id');


?>

<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=2>栏目添加</th>
  </tr>
  <form name="myform" method="post" action="?commit=yes&action=add" onSubmit="return doCheck();">
	<tr>
	  <td class="tablerow">栏目ID </td>
	  <td width="92%" class="tablerow"><input name="catid" id="catid" size="2" value="<?php echo $max_cat_id+1?>"  maxlength="2"  > <font color="#FF0000">请您一定确保ID没有被使用!!</td>
	</tr>
	<tr>
	  <td width=8% class="tablerow">所属栏目</td>
	  <td class="tablerow"><select name='parentid'>
		<option value='0'>无（作为一级栏目）</option>
<?php 
	while($rows = mysql_fetch_array($result,MYSQL_BOTH))
	{
		echo "<option value='".$rows['cat_id']."'>".$rows['cat_title']."</option>";
	}
?>
	  </select>
	  </td>
	</tr>
	<tr>
	  <td class="tablerow">栏目名称</td>
	  <td class="tablerow"><input size=30 name="catname" type=text></td>
	</tr>
	<tr>
	  <td class="tablerow">栏目Path</td>
	  <td class="tablerow"><input size=30 name="cat_path" type=text value='<?php echo $max_cat_id+1?>'> *英文，数字组合</td>
	</tr>
	<tr>
	  <td class="tablerow">栏目说明</td>
	  <td class="tablerow"><textarea name='description' cols='40' rows='3' id='description'></textarea>
	  </td>
	</tr>
	<tr>
	  <td class="tablerow">是否解释性栏目</td>
	  <td class="tablerow"><input name='attrs' type='radio' value='1'>
		是&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='attrs' value='0' checked>
		否</td>
	</tr>
	<tr>
	  <td class="tablerow">栏目类型</td>
	  <td class="tablerow"><input type='radio' name='static' value='0' checked>
		动态栏目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name='static' type='radio' value='1'>
		静态栏目</td>
	</tr>
	<tr>
	  <td class="tablerow">栏目类型</td>
	  <td class="tablerow"><table>
		<tr>
		  <td class="tablerow"><fieldset>
			<legend>
			  <input name='cattype' type='radio' value='1' checked onClick="ClassSettings.style.display=''">
			  <font color=blue><b>系统内部栏目</b></font></legend>
			&nbsp;&nbsp;&nbsp;&nbsp;系统内部栏目具有详细的参数设置。可以添加子栏目和文章。<br>
			<table id='ClassSettings' width='100%' border='0' cellpadding='2' cellspacing='1' style='display:'>
			  <tr>
				<td class="tablerowhighlight" colspan='2' align='center'>内部栏目参数设置</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否在父栏目的分类列表处显示</strong><br>
				  如果某栏目下有几十个子栏目，但只想显示其中几个子栏目的文章列表，这个选项就非常有用。</td>
				<td class="tablerow"><input name='islist' type='radio' value='1' checked>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type='radio' name='islist' value='0'>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>有子栏目时是否可以在此栏目添加文章</strong></td>
				<td class="tablerow"><input name='enableadd' type='radio' value='1' disabled >
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input  disabled type='radio' name='enableadd' value='0' checked>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否允许评论</strong><br></td>
				<td class="tablerow"><input name='enablecomment' type='radio' value='1'  disabled checked>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type='radio'  disabled name='enablecomment' value='0'>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否允许投稿</strong><br></td>
				<td class="tablerow"><input name='enablecontribute' type='radio' value='1' disabled checked>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input  disabled type='radio' name='enablecontribute' value='0'>
				  否</td>
			  </tr>
			  <tr>
				<td class="tablerow" width='300'><strong>是否启用此栏目的防止复制、防盗链功能</strong></td>
				<td class="tablerow"><input name='enableprotect' type='radio' value='1' disabled>
				  是&nbsp;&nbsp;&nbsp;&nbsp;
				  <input  disabled type='radio' name='enableprotect' value='0' checked>
				  否</td>
			  </tr>
			  <tr>
				<td width='300' class="tablerow" ><b>此栏目下的文章列表的排序方式</b></td>
				<td class="tablerow"><select name='ordertype' disabled>
				  <option value='1' selected>文章ID降序</option>
				  <option value='2'>文章ID升序</option>
				  <option value='3'>点击次数降序</option>
				  <option value='4'>点击次数升序</option>
				</select></td>
			  </tr>
			</table>
			</fieldset>
				<br>
				<fieldset>
				  <legend>
					<input name='cattype' type='radio' value='0' onClick="ClassSettings.style.display='none'">
					<font color=blue><b>外部栏目</b></font></legend>
				   当此栏目准备链接到网站中的其他系统时，请使用这种方式。不能在外部栏目中添加文章，也不能添加子栏目。<br>
				  &nbsp;&nbsp;&nbsp;&nbsp;外部栏目的链接地址
				  <input name='linkurl' type='text' id='linkurl' size='40' maxlength='200'>
				  <br>
				  <br>
			  </fieldset>
			<br>
		  </td>
		</tr>
	  </table></td>
	</tr>
	<tr>
	  <td class="tablerow"></td>
	  <td class="tablerow"><input name="submit" type=submit value="确定">
		  <input name="reset" type=reset value="清除"></td>
	</tr>
  </form>
</table>
<?php } 

else if($action==manage)
{  
	$sql="select * from $T_CAT order by cat_parent and cat_id  ";
	$result=mysql_query($sql) or die(mysql_error());
?>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=5>栏目管理</th>
  </tr>
<tr align=center>
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">栏目名称</td>
<td class="tablerowhighlight">栏目目录</td>
<td class="tablerowhighlight" >栏目说明</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?php while($rows=mysql_fetch_array($result,MYSQL_BOTH))
{ ?>
<tr onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><?php echo $rows['cat_id']?></td>
<td align="center">
<a href="../show_cat.php?cat=<?php echo ($rows['cat_parent'])?$rows['cat_parent']."spec=".$rows['cat_id']:$rows['cat_id']?>&sand=<?php echo base64_encode(rand())?>" target="_blank">
<?php echo $rows['cat_title']?></a></td>
<td height=20 align=center><?php if($rows['cat_parent']==0) echo "一级目录"; else echo "二级目录(".$rows['cat_parent'].")"; ?></td>
<td align=center><?php echo $rows['cat_content']?></td>
<td align=center> <a href='?id=<?php echo $rows['cat_id']?>&parentid=<?php echo $rows['cat_parent']?>&edit=yes'>修改</a> | <a href='' onClick="return false">锁定</a> | <a href='?id=<?php echo $rows['cat_id']?>&parentid=<?php echo $rows['cat_parent']?>&delete=all' onClick="return MakeSure(this.href,'清空栏目<?php echo $rows['cat_title']?>');">清空</a> | <a href='?id=<?php echo $rows['cat_id']?>&parentid=<?php echo $rows['cat_parent']?>&delete=yes' onClick="return MakeSure(this.href,'删除栏目<?php echo $rows['cat_title']?>');">删除</a></td>
</tr><?php } ?>
<tr> 
<th colspan="5">&nbsp;</th> 	
</tr>
</table>

<?php  } ?> 
</td>
</tr>

	  </table>

</body>
</html>
