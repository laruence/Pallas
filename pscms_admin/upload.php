<?php
require('session.inc');
require('config.php');
require('common.php');

if(empty($_SESSION['log']) && $_SESSION['log']!=true){ //check login? 
	echo "<script>window.location.replace('error.htm')</script>";
	exit();
}

function file_ext($attach_name,$allowedext){
	$pos=strrpos($attach_name,".");
	if($pos === false){
		$attach_ext="";
	}else{
		$attach_ext=strtolower(substr($attach_name,$pos+1));
	}
	if(eregi($allowedext,$attach_ext)){
		return $attach_ext;
	}else{
		return false;
	}
}


$ext_echo = str_replace('|', ',', $glo_allowedext);
$allowedext = "(".$glo_allowedext.")";


if(isset($_POST['submit'])){
	foreach($_FILES as $k => $v){
		$$k = $v;
	}
	if(empty($userfile)){
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgcolor=#DBDBDB topmargin=15 leftmargin=15 >
			<center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>对不起，您没有上传文件 [ <a href='upload.php' > 返回 </a> ]</fieldset><center>
			</body></html>");
	}
	if($userfile['size'] == 0){
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgcolor=#DBDBDB topmargin=15 leftmargin=15 ><center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>  对不起，您的文件大小为零 [ <a href='upload.php' >返回 </a> ]</fieldset><center></body></html>");
	}
	if(!is_uploaded_file($userfile['tmp_name'])){
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgcolor=#DBDBDB topmargin=15 leftmargin=15 ><center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>上传失败[ <a href='upload.php' > 返回 </a> ]</fieldset><center></body></html>");
	}
	if(!$ext = file_ext($userfile['name'], $allowedext))
	{
		exit("<html><head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>图片上传</title>
			<LINK href=editor/css/default.css rel=stylesheet>
			</head>
			<BODY bgcolor=#DBDBDB topmargin=15 leftmargin=15 ><center><FIELDSET><LEGEND align=center><font color=red>文件上传失败</font></LEGEND><br>文件格式不和要求,容许的格式有:<br>".$ext_echo."[ <a href='upload.php' > 返回 </a> ]</fieldset></center></body></html>");
	}

	$ext = file_ext($userfile['name'], $allowedext);
	$savedir="../uploads";
	$savepath=$savedir;
	//createdir($savepath);
	$filename=date("YmdHis").rand(1,999).".".$ext;
	$savepath=$savepath.'/'.$filename;

	$path = $glo_web_path."uploads/".$filename;
	$thumb_path= $glo_web_path."uploads/";
	$picext="gif|jpg|png|jpeg|";

	if(copy($userfile['tmp_name'], $savepath)){
		if(strstr($picext,$ext)){
			if($water == 1){
				addwater($savepath,$watercontent,$savepath,$wateralpha);
			}
			if($width && $height){ 
				$thumb_name=explode(".",$filename);
				$thumb_name=$thumb_name[0];
				$thumb_name="thumb_".$width."_".$height."_".$thumb_name.".jpg";
				$thumb_path=$thumb_path.$thumb_name;
				$srcFile="../uploads/".$filename;
				$dstFile="../uploads/".$thumb_name;
				makethumb($filename,$srcFile,$dstFile,"",$width,$height);
			}
			$out="<center><FIELDSET align=center><LEGEND align=center><font color=red>图片上传成功</font></LEGEND><br>[ <a href=# onclick=\"Addpic('$thumb_path','$filename','$path','$note','$width','$height','${userfile['name']}')\">点击这里添加图片到编辑框</a> ]</fieldset><center>";
		}elseif(strstr($ext, 'swf')){
			$out="<center><FIELDSET align=center><LEGEND align=center><font color=red>FLASH上传成功 </font></LEGEND><br>[ <a href=# onclick=\"Addswf('$path','$width','$height')\">Click Here Add To Editor</a> ]</fieldset><center>";
		}else{
			$out="<center><FIELDSET align=center><LEGEND align=center><font color=red>文件上传成功</font></LEGEND><br>[ <a href=# onclick=\"Addfile('${userfile['name']}','$path','$note')\">Click Here Add To Editor</a> ]</fieldset><center>";
		}
	}
	else
	{
		$out="<center><FIELDSET align=center><LEGEND align=center><font color=red>文件类型不符合要求</font></LEGEND></fieldset><center>";
	}
	echo "<html>
		<head>
		<title>图片上传</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<script  language='JavaScript'>
<!--
function Addfile(filename,savepath,note){

	window.opener.document.getElementById('message').focus();
	window.opener.document.getElementById('message').contentWindow.document.body.innerHTML+='<a href='+savepath+' target=_blank>'+filename+'</a>[点击下载](说明: '+note+')';
	window.close();
}
function Addswf(swfPath,width,height){	
	window.opener.document.getElementById('message').focus();
	window.opener.document.getElementById('message').contentWindow.document.body.innerHTML+='<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0 width='+width+' height='+height+'><param name=movie value='+swfPath+'><param name=quality value=high><param name=wmode value=transparent><embed src='+swfPath+' width='+width+' height='+height+' quality=high pluginspage=http://www.macromedia.com/go/getflashplayer type=application/x-shockwave-flash wmode=transparent></embed></object>';
	window.close();
}
function Addpic(thumb_path,filename,imagePath,note,width,height,userfilename){	
	window.opener.document.getElementById('message').focus();	
	if(width==0 || height==0)
	{
		window.opener.document.getElementById('message').contentWindow.document.body.innerHTML+='<a href='+imagePath+'><img src='+imagePath+' alt=\"'+note+'&#10点击看原图\" border=0></a>';	
}
else
{
	window.opener.document.getElementById('message').contentWindow.document.body.innerHTML+='<a href='+imagePath+'><img src='+thumb_path+'  alt=\"'+note+'&#10点击看原图\" border=0></a>';	
}						
//window.opener.document.getElementById('message').contentWindow.document.execCommand('InsertImage', false, imagePath);
//window.opener.document.getElementById('message').contentWindow.document.body.innerHTML+='<br>'+note;
window.opener.myform.originalfilename.value=window.opener.myform.originalfilename.value+'|'+imagePath;
window.opener.myform.savefilename.value=window.opener.myform.savefilename.value+'|'+imagePath;
window.opener.myform.savepathfilename.value=window.opener.myform.savepathfilename.value+'|'+imagePath;
window.opener.myform.defaultpicurl.value=filename;
window.opener.myform.pictrues.value+='|'+filename+','+userfilename;
opener.addoption(userfilename,filename);
window.close();
}
-->
	 </script>
	 <LINK href=editor/css/default.css rel=stylesheet>
	 </head>
	 <BODY bgcolor=#DBDBDB topmargin=15 leftmargin=15 >".$out."</body></html>";

	 }
	 else{

	 //$tsize = $maxsize/1000;

	 echo "<html>
	 <head>
	 <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	 <title>图片上传</title>
	 <LINK href=editor/css/default.css rel=stylesheet>
	 </head>
	 <BODY bgcolor=#DBDBDB topmargin=15 leftmargin=15 >
<script>
function show()
{
	document.getElementById('waterarear').style.display='inline';
	 }
function hide()
{
	document.getElementById('waterarear').style.display='none';
	 }

function keep()
{
	if(document.form.remain.checked==true)
	{
		document.form.width.value='';
		document.form.width.readOnly='readonly';
		document.form.height.value='';
		document.form.height.readOnly='readonly';
	 }
	 else
	 {
		 document.form.width.value='500';
		 document.form.width.readOnly=false;
		 document.form.height.value='300';
		 document.form.height.readOnly=false;

	 }
	 }
</script>
	 <CENTER>
	 <FIELDSET align=left>
	 <LEGEND align=left>文件上传</LEGEND>
	 <form name='form' method='post' action='' enctype='multipart/form-data' >
	   <p>
		 <input type='hidden' name='MAX_FILE_SIZE' value='2000000'>
		 <br> 
	 文件: 
	 <input type='file' name='userfile' size=21>
	 <br> 
	 说明: 
	 <input type='text' name='note' size=25 > 
	 <input type='submit' name='submit' value='上传' >
	 <br> 
	 宽度: 
	 <input type='text' name='width' size=5 value=500> 
	 高度: 
	 <input type='text' name='height' size=5 value=300> 
	 保持高度<input type='checkbox' name='remain' id='remain' onClick='keep()'><br> 
	 如果是图片,是否要填加水印  是:<input type='radio' name='water' value=1 onClick='show()'> 
	 否:<input type='radio' name='water' value='0' checked onClick='hide()'> <br>      
	<div id='waterarear' name='waterarear' align='center' style='display:none'> 填加的水印内容: <input type='text' name='watercontent' maxlength='10' value='$glo_web_name' size='22'><br>
	 水印透明度: 
	   <input type='text' maxlength='3' name='wateralpha' size='4' value='70'> 
	   范围:0-127(0为不透明)</div>
	 </form>
	 </fieldset>
	 </body>
	 </html>";

	 }
?>
