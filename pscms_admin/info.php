<?php
header("content-Type: text/html; charset=utf-8");
/* 
+----------------------------------------------------------------------
|   **如果你看到了这里，说明你的服务器不支持PHP**
+----------------------------------------------------------------------
*/
extract($_REQUEST);

function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$page_time_start=getmicrotime();
//脚本运行时间
function addTime($s=0)
{
	$time_start=getmicrotime();
	for($index=0;$index<=500000;$index++);
	{
		$count=1+1;
	}
	$time_end=getmicrotime();
	$time=$time_end-$time_start;
	$time=round($time*1000);
	$time=$s==0?"<font color=red>$time</font>":$time;
	return($time);	
}//END FUNCTION
function sqrtTime($s=0)
{
	$test=pi();
	$time_start=getmicrotime();
	for($index=0;$index<=500000;$index++);
	{
		sqrt($test);
	}
	$time_end=getmicrotime();
	$time=$time_end-$time_start;
	$time=round($time*1000);
	$time=$s==0?"<font color=red>$time</font>":$time;
	return($time);
}//END FUNCTION

if ("phpinfo" == $testinfo)
{
	phpinfo();
	exit;
}//END IF

function echo_info($str)
{
	echo "<script>alert('$str')</script>";
}

function temp($temp)
{
	if($temp==1)
	{
	$s='<font color=green>On<b>√</b></font>';
	}
	else
	{
	$s='<font color=red>Off<b>×</b></font>';
	}
	return $s;
}
//回传数据
$mailcontent	=	$_SERVER[SERVER_NAME].$_SERVER[PHP_SELF];
//服务器时间比较
$mtime[] = array("参照机器","整数运算,50万次“1+1”","浮点运算，50万次平方根");
$mtime[] = array("C1.2G/512M/Win2k/Apache2.0.55/PHP5.0.5/Zend Optimizer2.5.10a","418 毫秒","446 毫秒");
//当前主机
$mtime[] = array("<font color=red>当前这台服务器</font>",addTime()." 毫秒",sqrtTime()." 毫秒");

/*获取服务器信息*/
//ZEND op
$url	= "http://".$mailcontent."?testinfo=phpinfo";
@$content = file_get_contents ($url);  
eregi("Optimizer (.*), Copyright", $content, $regs);  
$OptimizerVersion	=	$regs[1]; 
$info[] = array("域名","Domain Name",$_SERVER['SERVER_NAME']."&nbsp;-&nbsp;".getenv(SERVER_ADDR));//主机名
$info[] = array("服务器端口","Server Port",getenv(SERVER_PORT));//端口
$info[] = array("服务器操作系统","Operating System",PHP_OS); //服务器操作系统
$info[] = array("WEB服务器版本","Web Server Version",$_SERVER['SERVER_SOFTWARE']); //web服务器版本
$info[] = array("PHP版本","PHP Version",PHP_VERSION);//php版本
$info[] = array("服务器语种","Server Language",getenv("HTTP_ACCEPT_LANGUAGE")); //服务器语种
$info[] = array("ZEND版本","ZEND Version",zend_version());
if('' != $OptimizerVersion){
	$info[] = array("ZEND Optimizer版本","ZEND Optimizer Version",$OptimizerVersion);
}
$info[] = array("绝对路径","Full path",$_SERVER['DOCUMENT_ROOT']. "<br>".$_SERVER['$PATH_INFO']); //绝对路径
$info[] = array("服务器剩余空间","Disk Free Space",intval(diskfreespace(".") / (1024 * 1024))."M"); //服务器空间大小
$info[] = array("服务器时间","Server Current Time",date("n月j日H点i分s秒")); //服务器时间
//$info[] = array("","",get_current_user()); //用户
//$info[] = array("","",isset($_SERVER["SERVER_ADMIN"])?"<a href=\"mailto:$_SERVER[SERVER_ADMIN]\" title=发送邮件>$_SERVER[SERVER_ADMIN]</a>":"<a href=\"mailto:get_cfg_var(sendmail_from)\" title=发送邮件>get_cfg_var(sendmail_from)</a>"); //管理员邮箱

/*PHP基本特性*/
$dis_func = get_cfg_var("disable_functions");
$php[] = array("PHP信息","PHPINFO",ereg("phpinfo",$dis_func)?"<font color=red>Off<b>×</b></font>":"<font color=green>On<b>√</b></font><a href=$PHP_SELF?testinfo=phpinfo>查看PHPINFO详细信息</a>");
$php[] = array("自定义全局变量","register_globals",temp(get_cfg_var("register_globals")));
$php[] = array("脚本运行可占最大内存","memory_limit",get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"无"); //单个脚本运行时可占用的最大内存
$php[] = array("脚本上传文件大小限制","upload_max_filesize",get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件");   //用PHP脚本上传文件大小限制
$php[] = array("被屏蔽的函数","disable_functions",get_cfg_var("disable_functions")?get_cfg_var("disable_functions"):"无"); //被屏蔽的函数
$php[] = array("POST方法提交限制","post_max_size",get_cfg_var("post_max_size")); //post方法提交内容限制
$php[] = array("脚本超时时间","max_execution_time",get_cfg_var("max_execution_time")."秒"); //脚本超时时间
$php[] = array("显示错误信息","display_errors",temp(get_cfg_var("display_errors"))); 

/*常见组件*/   
$obj[] = array("SMTP支持","smtp",temp(get_magic_quotes_gpc("smtp")));//SMTP
$obj[] = array("PHP安全模式","Safe_mode",temp(get_cfg_var("safe_mode")));  //PHP安全模式(Safe_mode)
$obj[] = array("XML 解析函数库","XML Support",temp(get_magic_quotes_gpc("XML Support")));//XML 支持      
$obj[] = array("FTP 文件传输函数库","FTP support",temp(get_magic_quotes_gpc("FTP support")));//FTP 支持
$obj[] = array("允许使用URL打开文件","allow_url_fopen",temp(get_cfg_var("allow_url_fopen")));//允许使用URL打开文件
$obj[] = array("动态链接库","enable_dl",temp(get_cfg_var("enable_dl")));//动态链接库

/*其他组件*/
$qobj[] = array("IMAP 电子邮件系统函数库","IMAP, POP3 and NNTP Functions",temp(function_exists("imap_close")));//IMAP电子邮件系统 
$qobj[] = array("历法运算函数库","Calendar Functions",temp(function_exists("JDToGregorian")));//历法
$qobj[] = array("压缩文件函数库(Zlib)","Zlib Compression Functions",temp(function_exists("gzclose"))); //压缩文件支持(Zlib)
$qobj[] = array("Session支持","Session Handling Functions",temp(function_exists("session_start"))); //Session支持
$qobj[] = array("Socket支持","Socket Functions",temp(function_exists("fsockopen"))); //Socket支持
$qobj[] = array("正则表达式函数库","PREL",temp(function_exists("preg_match")));//PREL相容语法 PCRE
@$gdInfo=gd_info();
$qobj[] = array("图像函数库","GD Library",function_exists("imageline")==1?temp(function_exists("imageline")).$gdInfo["GD Version"]:temp(function_exists("imageline")));//图形处理 GD Library
$qobj[] = array("FDF表单资料格式函数库","Forms Data Format Functions",temp(function_exists("FDF_close")));//FDF表单资料格式
$qobj[] = array("Iconv编码转换","iconv Functions",temp(function_exists("iconv")));//ICONV
$qobj[] = array("mbstring","Multi-Byte String Functions",temp(function_exists("mb_eregi")));//mb_string
$qobj[] = array("SNMP网络管理协议","SNMP Functions",temp(function_exists("snmpget")));//SNMP网络管理协议

/*数据库信息*/
$sql[] = array("MySQL 数据库","",temp(function_exists("mysql_close"))); //mysql数据库
$sql[] = array("ODBC 数据库","",temp(function_exists("odbc_close"))); //odbc数据库
$sql[] = array("Oracle 数据库","",temp(function_exists("ora_close"))); //ora数据库
$sql[] = array("Oracle 8 数据库","",temp(function_exists("OCILogOff")));//Oracle 8 数据库
$sql[] = array("SQL Server 数据库","",temp(function_exists("mssql_close")));//SQL Server数据库
$sql[] = array("mSQL 数据库","",temp(function_exists("msql_close")));//msql数据库
$sql[] = array("Hyperwave 数据库","",temp(function_exists("hw_close")));//Hyperwave数据库
$sql[] = array("dBase 数据库","",temp(function_exists("dbase_close")));//dbase数据库
$sql[] = array("PostgreSQL 数据库","",temp(function_exists("pg_connect")));//PostgreSQL数据库
$sql[] = array("firePro 数据库","",temp(function_exists("filepro")));//firePro数据库

function echoInfo($in,$tb=0)
{  
	$rs = '';
	$tw = $tb != 1 ? array("20%", "30%", "50%") : array("50%", "25%", "25%");
	for ($i = 0; $i < count($in); $i++)
	{
		$tbClass = $i%2 == 0 ? "bTable" : "cTable";
		$rs .= "<tr><td width={$tw[0]} class={$tbClass}>&nbsp; {$in[$i][0]}</td>
				<td width={$tw[1]} class={$tbClass}>{$in[$i][1]}</td>
				<td width={$tw[2]} class={$tbClass}>{$in[$i][2]}</td></tr>";
	}
	return $rs;
}
function echoTable($arr)
{
	$rs = '';
	for ($i = 0; $i < count($arr); $i++)
	{
		$rs .= '<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="aTable">
				  <tr>
					<td colspan="3"><span class="aTitle"> ■'.$arr[$i][0].'</span></td>
				  </tr>'.$arr[$i][1].
				'</table>';
	}
	return $rs;
}
$arr[]	= array("服务器相关参数",echoInfo($info));
$arr[]	= array("PHP基本参数",echoInfo($php));
$arr[]	= array("常见组件信息",echoInfo($obj));
$arr[]	= array("其他组件信息",echoInfo($qobj));
$arr[]	= array("数据库支持信息",echoInfo($sql));
$arr[]	= array("服务器性能测试",echoInfo($mtime,1));
$page	= echoTable($arr);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>EasyAPM-Server PHP 测试</title>
<style type="text/css">
<!--
body {
	table-layout: fixed;
	word-break:break-all;
	margin-top: 0px;
	color: #FFFFFF;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.LogoFont {
	font-family: "Arial Black";
	font-size: 18px;
	font-weight: bolder;
}
a:link {
	color: #FFFFFF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #FFFFFF;
}
a:hover {
	text-decoration: none;
	color: #FFFFFF;
}
a:active {
	text-decoration: none;
	color: #FFFFFF;
}
.aTable {
	background-color: #666666;
}
.bTable {
	background-color: #999999;
}
.cTable {
	background-color: #AAAAAA;
}
.aTitle {font-size: 12px; font-weight: bold; color: #FFFFFF; }
.input
{
	BORDER: 1px solid #333333;
	FONT-SIZE: 8pt;
	BACKGROUND-color: #FFFFFF;
	color: #435463;
	height: 12px;
	font-family: Tahoma, Vrinda, Arial;
}
.sub
{
	BACKGROUND-COLOR: #333333;
	BORDER: medium none;
	COLOR: #FFFFFF;
	HEIGHT: 14px;
	font-size: 8pt;
	font-family: Tahoma, Vrinda, Arial;
}
-->
</style>
</head>

<body>
<table width="760" height="10" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" >
  <tr>
    <td></td>
  </tr>
</table>
<?php echo $page?>
<A name="#function"></A>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="aTable">
  <tr>
    <td colspan="3" align="center">
	<?php
	$page_time_end=getmicrotime(); 
	$pageTime = round(($page_time_end-$page_time_start)*1000000)/1000;
	echo "页面执行时间".$pageTime."毫秒";
	?>
	</td>
  </tr>
</table>
</body>
</html>
