<?php
require_once("config.php");

if($_GET['action']=="send")
{

	require("./includes/phpmailer/class.phpmailer.php");

	$mail = new PHPMailer();

	$mail->SetLanguage("zh", $lang_path = "./includes/phpmailer/language/");

	$mail->Sendmail ="./includes/phpmailer/";

	$mail->PluginDir = "./includes/phpmailer/";

	$mail->IsSMTP();   // send via SMTP

	$mail->SMTPDebug = false;

	$mail->CharSet = "utf7";  //字符集

	$smtpuser=explode("@",$glo_smtp_username);//SMTP服务器的用户帐号

	$mail->Host     = $glo_smtp_server;; // SMTP servers
	$mail->SMTPAuth = $glo_smtp_auth;     // turn on SMTP authentication
	$mail->Username = $smtpuser[0];;  // SMTP username
	$mail->Password = $glo_smtp_password; // SMTP password


	$mail->From     = $sendfrom;

	$sendformnam=explode("<",$sendfrom);

	$mail->FromName = $sendformnam[0];

	$sendto=explode(",",$sendto);

	for($i=0;$i<count($sendto);$i++)
	{
		$email_to=explode("<",$sendto[$i]);

		$mail->AddAddress($email_to[0],$email_to[1]); 
		//$mail->AddAddress("ellen@site.com");               // optional name
		//$mail->AddReplyTo("info@site.com","Information");
	}

	$mail->WordWrap = 50;                              // set word wrap
	//$mail->AddAttachment("/var/tmp/file.tar.gz");      // attachment


	if($attach)
	{
		$attfile="./attachs/".$attach;
		$att[0]["name"] = $attachname;
		$att[0]["source"] = $attfile;
		$mail->AddAttachment($att[0]["source"], $att[0]["name"]); 
	}
	$mail->IsHTML($mail_type);                               // send as HTML

	$mail->Subject  = $mail_title;
	$mail->Body     = $mail_content;
	$mail->AltBody  = "";

	if(!$mail->Send())
	{
		echo "<script> alert('邮件发送失败\\r\\n错误信息:\\r\\n".nl2br($mail->ErrorInfo)."');window.history.go(-2);</script>";
		@unlink($att[0][source]);
		exit;
	}
	else
	{
		echo "<script> alert('邮件发送成功！');</script>;indow.history.go(-2);";
		@unlink ($att[0][source]);
		exit;
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>发送邮件</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language=JavaScript>

// 表单提交检测
function doCheck(){

	if (document.myform.sendto.value=="") {
		alert("请输入收件人");
		return false;
	}
	if (document.myform.sendfrom.value=="") {
		alert("请输入发件人");
		return false;
	}

	if (document.myform.mail_title.value=="") {
		alert("请输入主题");
		return false;
	}

	return true;
}
</script>
</head>
<body>
<?php if($type=="group")
	{
		$sendnum=count($userid);
		for($i=0;$i<$sendnum;$i++)
		{
			if($i==0&&$i!=$sendnum-1)
				$sendto=$usermail[$userid[$i]].",";
			else if($i==$sendnum-1)
				$sendto.=$usermail[$userid[$i]];
			else
				$sendto.=$usermail[$userid[$i]].",";

		}

	}
?>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=3 class="STYLE1">发送邮件</th>
  </tr>
   <form action="?action=send" method="post" name="myform" onSubmit="return doCheck();">
	<tr> 
	  <td class="tablerowhighlight" colspan=3>&nbsp;</td>
   <td width="2%"></td>
</tr>   
	 <tr> 
	  <td width="30%" align="center" class="tablerow">收件人</td>
	  <td colspan="2" valign="top" class="tablerow"><input type="text" name="sendto" size="40" value="<?php=$sendto?>"></td></tr>  
   <tr> 
	  <td width="30%" align="center" class="tablerow">发送人</td>
	  <td colspan="2" valign="top" class="tablerow"><input type="text" name="sendfrom" size="40" value="<?php=$glo_smtp_username?>"></td></tr>  
   <tr> 
	  <td width="30%" align="center" class="tablerow">主题</td>
	  <td colspan="2" valign="top" class="tablerow"><input type="text" name="mail_title" size="40" value="<?php=$replytitle?"Re:$replytitle":""?>"></td></tr>  
		<tr> 
	  <td width="30%" align="center" class="tablerow">信件类型</td>
	  <td colspan="2" valign="top" class="tablerow">TXT:<input type="radio" name="mail_type"  value="0" checked="checked">&nbsp;HTML:<input type="radio" name="mail_type"  value="1" ></td></tr>  
   <input type="hidden" name="attach"  value="">
   <input type="hidden" name="attachname"  value=""><tr> 
	  <td width="30%" align="center" class="tablerow">附件</td>
	  <td colspan="2" valign="top" class="tablerow"><div id="attachlist"><input type="button"  onClick="window.open('attach.php','upload','toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=228');" value="添加附件"></div></td></tr>  
	<tr> 

	  <td align="center" class="tablerow">邮件内容(可以使用HTML代码)</td>
	  <td width="52%" rowspan="2" class="tablerow">
	  <textarea id="mail_content" name="mail_content" rows=12 cols=100></textarea></td>
	  <td width="16%" rowspan="2" class="tablerow">&nbsp;</td>
	</tr>
	<tr>
	  <td align="center" class="tablerow">&nbsp;</td>
	</tr></form>



	<tr> 
	  <td class="tablerow"></td>
	  <td colspan="2" class="tablerow"> <input type="submit" name="Submit" onClick="document.myform.submit();"  value="发送"> 
		&nbsp; <input type="reset" name="Reset" onClick="document.myform.reset();" value="重写"> </td>
	</tr>
</table>
