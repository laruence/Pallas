<?php
require_once('config.php');
require_once("common.php");
$ext_echo=$allowedext;
$ext_echo=explode("|",$allowedext);
$ext_echo=join(",",$ext_echo);
$allowedext="(".$allowedext.")";

function c2s($bs) {
	if ($bs < 964)     { return round($bs)           . " Bytes"; }
	else if ($bs < 1000000) { return round($bs/1024,2)    . " KB"   ; }
	else                    { return round($bs/1048576,2) . " MB"   ; }
}


function guessMIMEType($filename) {
	//GUESS MIME TYPE
	$filename = basename($filename);
	if(strrchr($filename,".") == false) {
		return("application/octet-stream");
	}
	$ext = strrchr($filename,".");
	switch($ext) {
	case ".gif":
		return "image/gif";
		break;
	case ".gz":
		return "application/x-gzip";
	case ".htm":
	case ".html":
		return "text/html";
		break;
	case ".jpg":
		return "image/jpeg";
		break;
	case ".tar":
		return "application/x-tar";
		break;
	case ".txt":
		return "text/plain";
		break;
	case ".zip":
		return "application/zip";
		break;
	default:
		return "application/octet-stream";
		break;
	}
}

function file_ext($attach_name,$allowedext)
{
	$pos=strrpos($attach_name,".");
	if($pos===false)
	{
		$attach_ext="";
	}
	else
	{
		$attach_ext=strtolower(substr($attach_name,$pos+1));
	}


	if(eregi($allowedext,$attach_ext))
	{
		return $attach_ext;
	}
	else
	{
		return false;
	}
}


$ext_echo=$allowedext;
$ext_echo=explode("|",$allowedext);
$ext_echo=join(",",$ext_echo);
$allowedext="(".$allowedext.")";


if($submit){
	if(empty($userfile)){
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset='>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgColor=menu topmargin=15 leftmargin=15 >
			<center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>对不起，您没有上传文件 [ <a href='attach.php' > 返回 </a> ]</fieldset><center>
			</body></html>");
	}
	if($userfile_size==0){
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset='>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgColor=menu topmargin=15 leftmargin=15 ><center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>  对不起，您的文件大小为零 [ <a href='attach.php' >返回 </a> ]</fieldset><center></body></html>");
	}
	if(!is_uploaded_file($userfile)){
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset='>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgColor=menu topmargin=15 leftmargin=15 ><center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>上传失败[ <a href='attach.php' > 返回 </a> ]</fieldset><center></body></html>");
	}
	if(!$ext=file_ext($userfile_name,$allowedext))
	{
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset='>
			<title>附件上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgColor=menu topmargin=15 leftmargin=15 ><center><FIELDSET><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>文件格式不和要求,容许的格式有:<br>".$ext_echo."[ <a href='attach.php' > 返回 </a> ]</fieldset></center></body></html>");
	}
	$ext=file_ext($userfile_name,$allowedext);
	$savedir="./attachs";
	$savepath=$savedir;
	//createdir($savepath);
	$filename=date("YmdHis").rand(1,999).".".$ext;
	$savepath=$savepath.'/'.$filename;
	if(copy($userfile,$savepath))
	{


		$out="<center><FIELDSET align=center><LEGEND align=center><font color=red>附件上传成功</font></LEGEND><br>[ <a href=# onclick=\"window.close();\">关闭</a> ]</fieldset><center>";

		echo "<html>
			<head>
			<title>图片上传</title>
			<meta http-equiv='Content-Type' content='text/html; charset='>
			<script>
window.opener.myform.attach.value='$filename';
window.opener.myform.attachname.value='$userfile_name';
window.opener.document.getElementById('attachlist').innerHTML='$userfile_name 文件大小：<font color=blue>".c2s(${userfile_size})."</font>';
	 </script>
	 <LINK href=editor/css/default.css rel=stylesheet>
	 </head>
	 <BODY bgColor=menu topmargin=15 leftmargin=15 >".$out."</body></html>";
	 exit();
	 }
	 }
	?>
<html>
	 <head>
	 <meta http-equiv='Content-Type' content='text/html; charset='>
	 <title>附件上传</title>
	 <LINK href="editor/css/default.css" rel=stylesheet>
	 </head>
	 <BODY bgColor=menu topmargin=15 leftmargin=15 >
	 <CENTER>
	 <FIELDSET align=left>
	 <LEGEND align=left>附件上传</LEGEND>
	 <form name='form' method='post' action='' enctype='multipart/form-data' >

		 <input type='hidden' name='MAX_FILE_SIZE' value='2000000'>

	 附件: 
	 <input type='file' name='userfile' size=21><input type='submit' name='submit' value='上传' >
	 </form>
	 </fieldset>
	 </body>
	 </html>";



