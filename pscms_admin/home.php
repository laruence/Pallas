<?php
require('session.inc');

if(empty($_SESSION['log']) && $_SESSION['log']!=true)
{ 
//check login? 
echo "<script>window.location.replace('error.htm')</script>";
die(0054);
}
if($action == "edit")
{
	$glo_Con_GBK=$_POST['glo_Con_GBK'];
    $glo_Con_GBK =( $glo_Con_GBK==1 ? "_YES_":"_NO_");
    $fp=fopen("config.php",'w+');
	$content="<?php\nrequire_once(\"includes/Gvar.php\");\n\$db_host=\"$db_host\";\n\$db_username=\"$db_username\";\n\$db_password=\"$db_password\";\n\$db_data_base=\"$db_data_base\";\n\$glo_web_path=\"$glo_web_path\";\n\$glo_web_descript=\"$glo_web_descript\";\n\$glo_web_keywords=\"$glo_web_keywords\";\n\$glo_web_name=\"$glo_web_name\";\n\$glo_allowedext=\"$glo_allowedext\";//容许上传的文件，最好不要添加BMP文件，体积大，并且可能会有未知的错误发生\n\$glo_smtp_password=\"$glo_smtp_password\";\n\$glo_smtp_server=\"$glo_smtp_server\";\n\$glo_smtp_username=\"$glo_smtp_username\";\n\$glo_MYSQL_Client=$glo_MYSQL_Client;//使用的MYSQL连接方式MYSQL(mysql) 或者 MYSQLI(mysqli);\n\$glo_Con_GBK=$glo_Con_GBK;//是否校正链接字符集为GBK;_NO_为不校正\n\$glo_language=\"$glo_language\";//zh_cn简体中文  eng英文\n\$glo_reg_pass=$glo_reg_pass;\n\$glo_reg_permit=\"$glo_reg_permit\";\n\$glo_smtp_auth=$glo_smtp_auth;\n?>";
	if(fwrite($fp,$content))
	{
	echo "<script> alert('修改成功');window.location.replace('home.php');</script>";
 	}
	else die("文件不能写!");
	
	exit();
}

require_once('config.php');
switch($glo_language)
{
case zh_cn:
  require_once('languages/lang_zh_cn.php');
case eng:
  require_once('languages/lang_eng.php');
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>参数设置</title>
<script>
function check()
{
    return confirm("确定要修改么?" );
	
}
</script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="myform" action="?action=edit" method="post" onSubmit="return check();">
<table width="100%" cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
               <tr>
                   <td class='submenu' align=center>
					 <table cellpadding='0' cellspacing='0' border='0' width='100%' height='10'>
					  <tr>
						<td class='submenu' width='7%'></td>
						<td class='submenu' align='center'>基本参数设置</td>
						<td class='submenu' width='7%'  align='right'>	</td>
					  </tr>
					</table>
				 </td>
               </tr>
</table>
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="tablerow" width="12%">网站名称</td>
      <td class="tablerow" width="88%"><input type="text" name="glo_web_name" value="<?php echo $glo_web_name?>" size="40" /></td>
    </tr>
    <tr>
      <td class="tablerow" width="12%">网站关键字</td>
      <td class="tablerow" width="88%"><textarea cols="60" rows="3" name="glo_web_keywords" style="overflow:  auto" ><?php echo $glo_web_keywords?></textarea></td>
    </tr><tr> 
      <td class="tablerow" width="12%">网站简介</td> 

<td  class="tablerow"  width="88%" > <textarea cols="60" rows="3" name="glo_web_descript" style="overflow:  auto" ><?php echo $glo_web_descript?></textarea></td>
</tr>  <tr> 
      <td class="tablerow" width="12%">网站路径</td>
      <td width="88%" class="tablerow"><input type="text" name="glo_web_path"  value="<?php echo $glo_web_path?>"  /></td>
    </tr>
<tr> 
      <td class="tablerow" width="12%">数据库</td>
      <td width="88%" class="tablerow"><input type="text" name="db_host" value="<?php echo $db_host?>" readonly/>&nbsp;请不要随便修改</td>
    </tr>   
	<tr> 
      <td class="tablerow" width="12%">Database</td>
      <td width="88%" class="tablerow"><input type="text" name="db_data_base" value="<?php echo $db_data_base?>"  />&nbsp;请不要随便修改</td>
    </tr>  <tr> 
      <td class="tablerow" width="12%">数据库用户名</td>
      <td width="88%" class="tablerow"><input type="text" name="db_username" value="<?php echo $db_username?>"  readonly/>&nbsp;请不要随便修改</td>
    </tr>
    <tr> 
      <td class="tablerow">数据库密码</td>
      <td class="tablerow"><input type="text" name="db_password" value="<?php echo $db_password?>"  readonly/>&nbsp;请不要随便修改</td>
    </tr>
   <tbody >
    <tr> 
      <td class="tablerow">MYSQL连接方式</td>
      <td class="tablerow"><input type="text" name="glo_MYSQL_Client" value="<?php echo $glo_MYSQL_Client?>" />&nbsp;MYSQL或者MYSQLI</td>
    </tr>
	<tr> 
      <td class="tablerow">是否使用GBK连接校对</td>
      <td class="tablerow">是:<input type="radio" name="glo_Con_GBK" value="1" <?php if($glo_Con_GBK==1) echo "checked"?> />&nbsp;&nbsp;否:<input type="radio" name="glo_Con_GBK" value="0"<?php if($glo_Con_GBK==0) echo "checked"?> /></td>
    </tr>
	 <tr> 
      <td class="tablerow">语言</td>
      <td class="tablerow">简体中文:<input type="radio" name="glo_language" value="zh_cn"<?php if($glo_language=="zh_cn") echo "checked"?> />&nbsp;&nbsp;英文:<input type="radio" name="glo_language" value="eng" <?php if($glo_language=="eng") echo "checked"?> /></td>
    </tr>
	<tr> 
      <td class="tablerow">容许上传类型</td>
      <td class="tablerow"><input type="text" name="glo_allowedext" value="<?php echo $glo_allowedext?>" />&nbsp;多种类型用"|"分开</td>
    </tr>
	
	   <tr>
                   <td class='submenu' align=center colspan="2">
					 <table cellpadding='0' cellspacing='0' border='0' width='100%' height='10'>
					  <tr>
						<td class='submenu' width='7%'></td>
						<td class='submenu' align='center'>SMTP参数设置</td>
						<td class='submenu' width='7%'  align='right'>	</td>
					  </tr>
					</table>					 </td>
               </tr>
    <tr> 
      <td class="tablerow" width="12%">发送邮件SMTP服务器</td>
      <td width="88%" class="tablerow"><input type="text" name="glo_smtp_server" value="<?php echo $glo_smtp_server?>"  >&nbsp;比如:smtp.163.com</td>
    </tr> <tr> 
      <td class="tablerow">SMTP服务器需要验证</td>
      <td class="tablerow">需要:<input type="radio" name="glo_smtp_auth"  value="1" <?php if($glo_smtp_auth==1) echo "checked"?> >&nbsp;不需要<input type="radio" name="glo_smtp_auth"  value="0" <?php if($glo_smtp_auth==0) echo "checked"?>></td>
    </tr>
    <tr> 
      <td class="tablerow">SMTP服务器帐号</td>
      <td class="tablerow"><input type="text" name="glo_smtp_username" value="<?php echo $glo_smtp_username?>"  >&nbsp;包含@，比如Laruence@163.com</td>
    </tr>
   <tbody >
    <tr> 
      <td class="tablerow">SMTP服务器密码</td>
      <td class="tablerow"><input type="text" name="glo_smtp_password" value="<?php echo $glo_smtp_password?>" >&nbsp;</td>
    </tr>
      <tr>
                   <td class='submenu' align=center colspan="2">
					 <table cellpadding='0' cellspacing='0' border='0' width='100%' height='10'>
					  <tr>
						<td class='submenu' width='7%'></td>
						<td class='submenu' align='center'>会员注册设置</td>
						<td class='submenu' width='7%'  align='right'>	</td>
					  </tr>
					</table>					 </td>
               </tr>
 <tr> 
      <td class="tablerow">会员注册自动审核</td>
      <td class="tablerow">是:<input type="radio" name="glo_reg_pass" value="1" <?php if($glo_reg_pass==1) echo "checked"?> />&nbsp;&nbsp;否:<input type="radio" name="glo_reg_pass" value="0"<?php if($glo_reg_pass==0) echo "checked"?> /></td>
    </tr>
 <tr> 
      <td class="tablerow">会员注册自动条款</td>
      <td class="tablerow"><textarea name="glo_reg_permit" rows="6" cols="60" style="overflow:auto" ><?php echo $glo_reg_permit?>
      </textarea></td>
 </tr>
    <tr> 
      <td class="tablerow"> 确定修改</td>
      <td class="tablerow"><input type="submit" value="确定" />&nbsp;&nbsp;<input type="reset" value="取消" /></td>
    </tr>


    </td>
  </tr>
</table>  
</form>
</body>
</html>
