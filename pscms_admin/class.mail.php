<?php 
/*
* 邮件发送类
* 作 者：laruence
* 联系邮箱：laruence@yahoo.com.cn
* 创建时间：2005-12-11
* 注明：此类为改装过来的,忘记出处了
*/
class smail {
//您的SMTP 服务器供应商，可以是域名或IP地址
var $smtp = "smtp.163.com";
//SMTP需要要身份验证设值为 1 不需要身份验证值为 0，现在大多数的SMTP服务商都要验证，如不清楚请与你的smtp 服务商联系。
var $check = 1;
//您的email帐号名称
var $username = "laruence";
//您的email密码
var $password = "211314";
//此email 必需是发信服务器上的email
var $s_from = "laruence@yahoo.com.cn";

/*
* 功能：发信初始化设置
* $from 你的发信服务器上的邮箱
* $password 你的邮箱密码
* $smtp 您的SMTP 服务器供应商，可以是域名或IP地址
* $check SMTP需要要身份验证设值为 1 不需要身份验证值为 0，现在大多数的SMTP服务商都要验证
*/
function smail ( $from, $password, $smtp, $check = 1 )
 {
if( preg_match("/^[^\d\-_][\w\-]*[^\-_]@[^\-][a-zA-Z\d\-]+[^\-](\.[^\-][a-zA-Z\d\-]*[^\-])*\.[a-zA-Z]{2,3}/", $from ) ) 
	{

	$this->username = substr( $from, 0, strpos( $from , "@" ) );
	$this->password = $password;
	$this->smtp = $smtp ? $smtp : $this->smtp;
	$this->check = $check;
	$this->s_from = $from;
	}

 }
/*
* 功能：发送邮件
* $to 目标邮箱
* $from 来源邮箱
* $subject 邮件标题
* $message 邮件内容
*/
function send ( $to, $from, $subject, $message ) {

//连接服务器
$fp = fsockopen ( $this->smtp, 25, $errno, $errstr, 60);
if (!$fp ) return "联接服务器失败".__LINE__;
set_socket_blocking($fp, true );

$lastmessage=fgets($fp,512);
if ( substr($lastmessage,0,3) != 220 ) return "错误信息:".$lastmessage.__LINE__;

//HELO
$yourname = "YOURNAME";
if($this->check == "1") $lastact="EHLO ".$yourname."\r\n";
else $lastact="HELO ".$yourname."\r\n";

fputs($fp, $lastact);
$lastmessage == fgets($fp,512);
if (substr($lastmessage,0,3) != 220 ) return "错误信息$lastmessage".__LINE__;
while (true) {
$lastmessage = fgets($fp,512);
if ( (substr($lastmessage,3,1) != "-") or (empty($lastmessage)) )
break;
}


//身份验证
if ($this->check=="1") {
//验证开始
$lastact="AUTH LOGIN"."\r\n";
fputs( $fp, $lastact);
$lastmessage = fgets ($fp,512);
if (substr($lastmessage,0,3) != 334) return "错误信息$lastmessage".__LINE__;
//用户姓名
$lastact=base64_encode($this->username)."\r\n";
fputs( $fp, $lastact);
$lastmessage = fgets ($fp,512);
if (substr($lastmessage,0,3) != 334) return "错误信息$lastmessage".__LINE__;
//用户密码
$lastact=base64_encode($this->password)."\r\n";
fputs( $fp, $lastact);
$lastmessage = fgets ($fp,512);
if (substr($lastmessage,0,3) != "235") return "错误信息$lastmessage".__LINE__;
}

//FROM:
$lastact="MAIL FROM: ". $this->s_from . "\r\n";
fputs( $fp, $lastact);
$lastmessage = fgets ($fp,512);
if (substr($lastmessage,0,3) != 250) return "错误信息$lastmessage".__LINE__;

//TO:
$lastact="RCPT TO: $to" . "\r\n";
fputs( $fp, $lastact);
$lastmessage = fgets ($fp,512);
if (substr($lastmessage,0,3) != 250) return "错误信息$lastmessage".__LINE__;

//DATA
$lastact="DATA\r\n";
fputs($fp, $lastact);
$lastmessage = fgets ($fp,512);
if (substr($lastmessage,0,3) != 354) return "错误信息$lastmessage".__LINE__;


//处理Subject头
$head="Subject: $subject\r\n";
$message = $head."\r\n".$message;


//处理From头
$head="From: $from\r\n";
$message = $head.$message;

//处理To头
$head="To: $to\r\n";
$message = $head.$message;


//加上结束串
$message .= "\r\n.\r\n";

//发送信息
fputs($fp, $message);
$lastact="QUIT\r\n";

fputs($fp,$lastace);
fclose($fp);
return 0;
}
}
?>
