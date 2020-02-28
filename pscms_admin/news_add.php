<?php 
require('session.inc');
require("news.php");
switch($glo_language)
{
case 'zh_cn':
	require_once('languages/lang_zh_cn.php');
case 'eng':
	require_once('languages/lang_eng.php');
}

if(isset($_SESSION['log']) && $_SESSION['log']==true||$type!=NULL){ 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang['news_add']?></title>

<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="source/ajax.js">//加载ajax框架</script>
</head>
<body onLoad="init();">
<script language=JavaScript>
var message;
function init(){
		message = document.getElementById('message');
		message.contentWindow.document.designMode = "On";
		loadcatid();
}
function doChange(objText, objDrop){
		if (!objDrop) return;
		var str = objText.value;
		var arr = str.split("|");
		var nIndex = objDrop.selectedIndex;
		objDrop.length=1;
		for (var i=0; i<arr.length; i++){
			objDrop.options[objDrop.length] = new Option(arr[i], arr[i]);
		}
		objDrop.selectedIndex = nIndex;
	}

function addoption(text,value)
{
	myform.news_pic.options[myform.news_pic.length]=new Option(text,value,true,true);

}

// 表单提交检测
function doCheck(){
	// 如：标题不能为空，内容不能为空，等等....
	document.myform.news_text.value = encodeURIComponent(message.contentWindow.document.body.innerHTML);
	//document.myform.news_text.value = message.contentWindow.document.body.innerHTML;
	if (document.myform.catid.value=='0'){
		alert('请选择所属选择栏目');
		document.myform.catid.focus();
		return false;
	}
	if(myform.abstract.value.length > 200)
	{
		alert("新闻主题不应过长!");
		return false;
	}


	if(myform.abstract.value=="一句话简介 字数不要超过100字" || myform.abstract.value=="")
	{
		alert("请输入新闻主题!");
		return false;
	}

	if (myform.news_title.value=="") {
		alert("请输入标题");
		document.myform.news_title.focus();
		return false;
	}
	if (message.contentWindow.document.body.innerHTML=="") {
		alert("请输入内容");
		return false;
	}
}
</script>
	<script language = 'JavaScript'>
	function ruselinkurl(){
		if(document.myform.uselinkurl.checked==true){
			document.myform.linkurl.disabled=false;
			article.style.display='none';
		}else{
			document.myform.linkurl.disabled=true;
			article.style.display='';
		}
	}

var titlechangedcolor=0;
var titlechangedstyle=0;
function changetitlestyle(style)
{
	if(!titlechangedstyle)
	{document.myform.orititlestyle.value=document.myform.news_title.value;}
	titlechangedstyle=1;

	switch(style)
	{
	case '1':
		document.myform.news_title.value="<b>"+document.myform.orititlestyle.value+"</b>";
		break;
	case '2':
		document.myform.news_title.value="<i>"+document.myform.orititlestyle.value+"</i>";
		break;
	case '3':
		document.myform.news_title.value="<i><b>"+document.myform.orititlestyle.value+"</b></i>";
		break;
	case '0':
		document.myform.news_title.value=document.myform.orititlestyle.value;
		break;
	}
}
function changetitlecolor(color)
{
	if(!titlechangedcolor)
	{document.myform.orititle.value=document.myform.news_title.value;}
	document.myform.news_title.value="<font color="+color+">"+document.myform.orititle.value+"</font>";
	titlechangedcolor=1;
}

function  cleanWordString()  {  

	var html=message.contentWindow.document.body.innerHTML;
	if(confirm("确定要删除所有WORD格式么?"))
	{
		html  =  html.replace(/<\/?SPAN[^>]*>/gi,  ""  );//  Remove  all  SPAN  tags  
		html  =  html.replace(/<(\w[^>]*)  class=([^|>]*)([^>]*)/gi,  "<$1$3")  ;  //  Remove  Class  attributes  
		html  =  html.replace(/<(\w[^>]*)  style="([^"]*)"([^>]*)/gi,  "<$1$3")  ;  //  Remove  Style  attributes  
		html  =  html.replace(/<(\w[^>]*)  lang=([^|>]*)([^>]*)/gi,  "<$1$3")  ;//  Remove  Lang  attributes  
		html  =  html.replace(/<\\?\?xml[^>]*>/gi,  "")  ;//  Remove  XML  elements  and  declarations  
		html  =  html.replace(/<\/?\w+:[^>]*>/gi,  "")  ;//  Remove  Tags  with  XML  namespace  declarations:  <o:p></o:p>  
		html  =  html.replace(/&nbsp;/,  " ");//  Replace  the  &nbsp;  
		//  Transform  <P>  to  <DIV>  
		var  re  =  new  RegExp("(<P)([^>]*>.*?)(<\/P>)","gi")  ;            //  Different  because  of  a  IE  5.0  error  
		html  =  html.replace(re,  "<div$2</div>");  
		//insertHTML(  html  );  
	}
	message.contentWindow.document.body.innerHTML = html;  
}  
</script>
<?php

	if ($action == 'add'){
		if ($type==NULL){
			$news_date=date('YmdHis');
			//$news_text=str_replace(' ','&nbsp;',$news_text);
			//$news_text=str_replace('
			//','<br>',$news_text);
			//$news_text=htmlspecialchars($news_text);
			/* echo "<script>alert(".$specialid.")</script>";*/
			$picnews=1;
			if($defaultpicurl=='nopic.gif') 
				$picnews=0;
			if(empty($cmt))
			   	$cmt=0;
			$ip = $_SERVER['REMOTE_ADDR'];//recrod the author's address!
 /* 
  自动分页功能
  if($paginationtype==1)
   {
	  $news_text_len=strlen($news_text);
	  if($maxcharperpage<$news_text_len)
	  {

	  $test_text=$news_text;

	  while($temp_pos=stristr($test_text,'<br>'))
	  {
	   echo "<script> alert(".$temp_pos.");</script>";
	   $insertpos[count($insertpos)]=$temp_pos;
	   }//while
	  $pos_len=count($insertpos);
	  for($i=0;$i<$pos_len;$i++)
	  {
	  $temp_text=substr($news_text,0,$insertpos[$i]);
	  $rest_text=substr($news_text,$insertpos[$i]+1);
	  $news_text=$temp_text."[*next*]".$rest_text;
	  } //for



	  }//if

   }//if
  */
			$news_text = urldecode($news_text);
			$sql="insert into $T_NEWS(news_title,news_cat,news_spec,news_author,news_from,news_date,news_text,news_cmt,news_picnews,news_picurl,news_placard,news_ip,news_type,news_abstract,news_keywords,news_pictrues,news_typein,news_type1,news_type2) values ('$news_title','$catid','$specid','$author','$copyfromname','$news_date','$news_text','$cmt','$picnews','$defaultpicurl','$placard','$ip','$newstype','$abstract','$keywords','$pictrues','$typein','$type1','$type2')";
			$result=mysql_query($sql,$db) or die(mysql_error());
			if($result) {
				$action="添加新闻: ".$news_title;
				wLog($_SESSION['loginname'],$date,$action,$ip);
				echo  "<script>alert('新闻添加成功!'); window.location.replace('news_add.php');</script>";}
			else 
				echo "erro";
			exit; 
		}


			else
			{
				$cmt_id = $articleid;
				$date=date('YmdHis');
				$ip=$_SERVER['REMOTE_ADDR'];
				$sql="insert into $T_CMT(cmt_newsid,cmt_name,cmt_sex,cmt_mark,cmt_qq,cmt_email,cmt_msn,cmt_homepage,cmt_date,cmt_content,cmt_ip ) values ('$cmt_id','$lusername','$gender','$score','$qq','$email','$msn','$homepage','$date','$content','$ip')";
				$result=mysql_query($sql,$db ) or die(mysql_error());
				if($result){
?>
				<script>alert("评论添加成功");
				window.history.go(-1);
</script>
<?php 
		}}} 
?>

<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style>
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<td class="submenu" align=center><?php echo $lang['news_man']?></td>
  </tr>
  <tr>
	<td class="tablerow"><b><?php echo $lang['manage']?>：</b><a href="news_add.php"><?php echo $lang['news_add']?></a> | <a href="news_man.php?delete=yes"><?php echo $lang['news_man']?></a></td>
  </tr>
</table>
<table  width="100%" align="center" border="0" cellspacing="0" cellpadding="0">

  <form action="<?php $PHP_SELF ?>?action=add" method="post" name="myform" onSubmit="return doCheck();">
	<tr>
	  <td width="8%" class="tablerow STYLE2">
	  <?php echo $lang['n_sort']?></td>
	  <td class="tablerow" width="92%">
		<select onChange="loadspecid(this.value);" name='catid' id='catid'>
		<option value='0'><?php echo $lang['n_sort_s']?></option>
	  </select> <span class="STYLE2">*</span></td>
	</tr>
	<tr>
	  <td width="8%" class="tablerow"><?php echo $lang['n_spec']?></td>
	  <td  id="0" name="0" class="tablerow"  width="92%" style="display:inline ">
	  <select name='specid' id='specid'  disabled>
		<option value='0'><?php echo $lang['n_spec_s']?></option>
	  </select></td>
	</tr>

	<tr>
	  <td width="8%" class="tablerow STYLE2"><?php echo $lang['n_title']?></td>
	  <td width="92%" class="tablerow"><table width='80%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
		  <td class="tablerow"><input type="hidden" name="orititle" id="orititle" />
				<input type="hidden" name="orititlestyle" id="orititlestyle" />
				<select name="newstype" id='newstype'>
				<option value='0'><?php echo $lang['n_type']?></option>
				<option value='1'><?php echo $lang['n_type_1']?></option>
				<option value='2'><?php echo $lang['n_type_2']?></option>
				<option value='3'><?php echo $lang['n_type_3']?></option>
			  </select>
				<input name='news_title' type='text' id='news_title' value='' size='40' maxlength='40' />
				<font color='#FF0000'>*</font>
				<select name='titlefontcolor' id='titlefontcolor' onChange="changetitlecolor(this.value);">
				  <option value='' selected ><?php echo $lang['n_color']?></option>
				  <option value=''><?php echo $lang['default']?></option>
				  <option value='#000000' style='background-color:#000000'></option>
				  <option value='#FFFFFF' style='background-color:#FFFFFF'></option>
				  <option value='#008000' style='background-color:#008000'></option>
				  <option value='#800000' style='background-color:#800000'></option>
				  <option value='#808000' style='background-color:#808000'></option>
				  <option value='#000080' style='background-color:#000080'></option>
				  <option value='#800080' style='background-color:#800080'></option>
				  <option value='#808080' style='background-color:#808080'></option>
				  <option value='#FFFF00' style='background-color:#FFFF00'></option>
				  <option value='#00FF00' style='background-color:#00FF00'></option>
				  <option value='#00FFFF' style='background-color:#00FFFF'></option>
				  <option value='#FF00FF' style='background-color:#FF00FF'></option>
				  <option value='#FF0000' style='background-color:#FF0000'></option>
				  <option value='#0000FF' style='background-color:#0000FF'></option>
				  <option value='#008080' style='background-color:#008080'></option>
				</select>
				<select name='titlefonttype' id='titlefonttype' onChange="changetitlestyle(this.value);">
				  <option value='0' selected><?php echo $lang['n_font']?></option>
				   <option value='0'><?php echo $lang['default']?></option>
				  <option value='1'><?php echo $lang['n_font_1']?></option>
				  <option value='2'><?php echo $lang['n_font_2']?></option>
				  <option value='3'><?php echo $lang['n_font_3']?></option>

				</select>
		  </td>
		</tr>
	  </table></td>
	</tr>
	  <td class="tablerow"><?php echo $lang['n_attr']?></td>
	  <td class="tablerow">
	  <?php echo $lang['n_attr_1']?>:
	  <input type='text' name="type1">
	  <?php echo $lang['n_attr_2']?>: 
	  <input name="type2" type="text"></td>
	</tr>
	<tr>
	  <td class="tablerow STYLE2"><?php echo $lang['n_abstract']?></td>
	  <td class="tablerow"><textarea name="abstract" cols="70" rows="3" wrap="virtual"   style="color:#666666; overflow:hidden;" onClick="this.value=''; this.style.color='#000000';" ><?php echo $lang['n_ab_value']?></textarea></td>
	</tr>
	<tr>
	  <td class="tablerow " width="8%"> <?php echo $lang['n_keywords']?></td>
	  <td class="tablerow " width="92%"> <input name="keywords" type="text"   style="color:#666666; overflow:hidden;" onClick="this.value=''; this.style.color='#000000';"  size="70" maxlength="70" value="<?php echo $lang['n_key_value']?>" /></td>
	</tr>
	<tbody style="display:''" id="article">
	  <tr>
		<td class="tablerow"><?php echo $lang['n_author']?></td>
		<td class="tablerow"><input name='author' type='text' id='author'  size='30' maxlength='30' >
		   &nbsp;&nbsp;&nbsp;<?php echo $lang['n_typein']?> <input type="text" name="typein" id="typein" value='<?php echo $loginname?>' size=20 maxlength="20">
		   <font color='blue'><=[<a href='#' onClick="document.myform.typein.value='佚名'"><font color='green'>佚名</font></a>] [<a href='#' onClick="document.myform.typein.value='<?php echo $loginname?>'"><font color='green'><?php echo $loginname?></font></a>]</font></td>
	  </tr>
	  <tr>
		<td class="tablerow"><?php echo $lang['n_from']?></td>
		<td class="tablerow"><table width='100%' border='0' cellpadding='0' cellspacing='0'>
		  <tr>
			<td width='29%'><?php echo $lang['n_from_1']?>
			  <input name='copyfromname' type='text' id='copyfromname' value='' size='15' maxlength='50'>
			  <font color='blue'><=[<a href='#' onClick="document.myform.copyfromname.value='本站原创'"><font color='green'>本站原创</font></a>]</font> </td>
			<td width="71%" class="tablerow"> <?php echo $lang['n_from_2']?>
			  <input name='copyfromurl' type='text' id='copyfromurl' value='' size='30' maxlength='200'>            </td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td class="tablerow STYLE2"><?php echo $lang['n_text']?> </td>
		<td class="tablerow"><input type=hidden name=originalfilename />
			<input type=hidden name=savefilename />
			<input type=hidden name=savepathfilename />
			<textarea name="news_text" style="display:none" wrap="soft"></textarea>
<script language="javascript">
function fortable()
{

	var arr = showModalDialog("./editor/dialog/table.htm", "", "dialogWidth:25em; dialogHeight:12em; status:0");
	if (arr != null){
		var tmp=arr.split("*");
		row=tmp[0];
		col=tmp[1];
		var string;
		string="<table style='WIDTH: "+tmp[2]+"px;' border="+tmp[3]+" bgcolor="+tmp[6]+" cellspacing="+tmp[5]+" cellpadding="+tmp[4]+">";
		for(i=1;i<=row;i++){
			string=string+"<tr>";
			for(j=1;j<=col;j++){
				string=string+"<td>&nbsp;</td>";
			}
			string=string+"</tr>";
		}
		string=string+"</table>";
		content=message.contentWindow.document.body.innerHTML;
		content=content+string;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}

function insertpage()
{
	var sel = message.contentWindow.document.selection;
	if (sel){
		var rng = sel.createRange();
		if (rng)
			rng.text = '[*next*]';
	}else{
		message.contentWindow.document.body.innerHTML += '[*next*]';
	}
}

function swf()
{
	var arr = showModalDialog("./editor/dialog/flash.htm", "", "dialogWidth:30em; dialogHeight:10em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			path=ss[0];
		row=ss[1];
		col=ss[2];
		var string;
		string="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'  codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width="+row+" height="+col+"><param name=movie value="+path+"><param name=quality value=high><embed src="+path+" pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width="+row+" height="+col+"></embed></object>"
			content=message.contentWindow.document.body.innerHTML;
		content=content+string;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}

function wmv()
{
	var arr = showModalDialog("./editor/dialog/media.htm", "", "dialogWidth:30em; dialogHeight:10em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			path=ss[0];
		row=ss[1];
		col=ss[2];
		var string;
		string="<object classid='clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95' width="+row+" height="+col+"><param name=Filename value="+path+"><param name='BufferingTime' value='5'><param name='AutoSize' value='-1'><param name='AnimationAtStart' value='-1'><param name='AllowChangeDisplaySize' value='-1'><param name='ShowPositionControls' value='0'><param name='TransparentAtStart' value='1'><param name='ShowStatusBar' value='1'></object>"

			//string="<EMBED src="+path+" width="+row+" height="+col+" type=audio/x-pn-realaudio-plugin console='Clip1' controls='IMAGEWINDOW,ControlPanel,StatusBar' autostart='true'></EMBED>"
			content=message.contentWindow.document.body.innerHTML;
		content=content+string;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}


function rm()
{
	var arr = showModalDialog("./editor/dialog/rm.htm", "", "dialogWidth:30em; dialogHeight:10em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			path=ss[0];
		row=ss[1];
		col=ss[2];
		var string;
		string="<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width="+row+" height="+col+"><param name='CONTROLS' value='ImageWindow'><param name='CONSOLE' value='Clip1'><param name='AUTOSTART' value='-1'><param name=src value="+path+"><br><param name='CONTROLS' value='ControlPanel,StatusBar'><param name='CONSOLE' value='Clip1'><embed SRC type='audio/x-pn-realaudio-plugin' CONSOLE='Clip1' CONTROLS='ImageWindow' HEIGHT='288' WIDTH='352' AUTOSTART='false'></object>"

			//string
			//="<EMBED src="+path+" width="+row+" height="+col+" type=audio/x-pn-realaudio-plugin console='Clip1' controls='IMAGEWINDOW,ControlPanel,StatusBar' autostart='true'></EMBED>"

			content=message.contentWindow.document.body.innerHTML;
		content=content+string;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}


function pic()
{
	var arr = showModalDialog("./editor/dialog/pic.htm", "", "dialogWidth:30em; dialogHeight:15em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		e=ss[4];
		f=ss[5];
		g=ss[6];
		h=ss[7];
		i=ss[8];

		var str1;
		str1="<img src='"+a+"' alt='"+b+"'"
			if(d.value!='')str1=str1+"width='"+d+"'"
			if(e.value!='')str1=str1+"height='"+e+"' "
			str1=str1+" border='"+i+"' align='"+h+"' vspace='"+f+"' hspace='"+g+"'  style='"+c+"'"
			str1=str1+">"
			content=message.contentWindow.document.body.innerHTML;
		content=content+str1;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}

function FIELDSET()
{
	var arr = showModalDialog("./editor/dialog/fieldset.htm", "", "dialogWidth:25em; dialogHeight:10em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		var str1;
		str1="<FIELDSET "
			str1=str1+"align="+a+""
			str1=str1+" style='"
			if(c.value!='')str1=str1+"color:"+c+";"
			if(d.value!='')str1=str1+"background-color:"+d+";"
			str1=str1+"'><Legend"
			str1=str1+" align="+b+""
			str1=str1+">标题</Legend>内容</FIELDSET>"
			content=message.contentWindow.document.body.innerHTML;
		content=content+str1;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}

function iframe()
{
	var arr = showModalDialog("./editor/dialog/iframe.htm", "", "dialogWidth:30em; dialogHeight:13em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		e=ss[4];
		f=ss[5];
		g=ss[6];
		var str1;
		str1="<iframe src='"+a+"'"
			str1+=" scrolling="+b+""
			str1+=" frameborder="+c+""
			if(d!='')str1+=" marginheight="+d
			if(e!='')str1+=" marginwidth="+e
			if(f!='')str1+=" width="+f
			if(g!='')str1+=" height="+g
			str1=str1+"></iframe>"
			content=message.contentWindow.document.body.innerHTML;
		content=content+str1;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}

function hr()
{
	var arr = showModalDialog("./editor/dialog/hr.htm", "", "dialogWidth:30em; dialogHeight:12em; status:0;help:0");

	if (arr != null){
		var ss;
		ss=arr.split("*")
			a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		e=ss[4];
		var str1;
		str1="<hr"
			str1=str1+" color='"+a+"'"
			str1=str1+" size="+b+"'"
			str1=str1+" "+c+""
			str1=str1+" align="+d+""
			str1=str1+" width="+e
			str1=str1+">"
			content=message.contentWindow.document.body.innerHTML;
		content=content+str1;
		message.contentWindow.document.body.innerHTML=content;
	}
	else message.focus();
}





function IsDigit()
{
	return ((event.keyCode >= 48) && (event.keyCode <= 57));
}

//Function to format text in the text box
function FormatText(command, option){

	message.contentWindow.document.execCommand(command, true, option);
	message.focus();
}

//Function to add image
function AddImage(){	
	imagePath = prompt('请输入图片地址', 'http://');				

	if ((imagePath != null) && (imagePath != "")){					
		message.contentWindow.document.execCommand('InsertImage', false, imagePath);
		message.focus();
	}
	message.focus();			
}

//Function to clear form
function ResetForm(){

	if (window.confirm('确认要清空对话框内容?')){
		message.contentWindow.document.body.innerHTML = ''; 
		return true;
	} 
	return false;		
}

//Function to open pop up window
function openWin(theURL,winName,features) {
	window.open(theURL,winName,features);
}

function setMode(newMode)
{
	bTextMode = newMode;
	var cont;
	if (bTextMode) {
		cleanHtml();
		cleanHtml();

		cont = message.contentWindow.document.body.innerHTML;
		message.contentWindow.document.body.innerText=cont;
	} else {
		cont=message.contentWindow.document.body.innerText;
		message.contentWindow.document.body.innerHTML=cont;
	}
	message.focus();
}

function cleanHtml()
{
	var fonts = message.contentWindow.document.body.all.tags("FONT");
	var curr;
	for (var i = fonts.length - 1; i >= 0; i--) {
		curr = fonts[i];
		if (curr.style.backgroundColor == "#ffffff") curr.outerHTML	= curr.innerHTML;
	}

}

function help()
{
	var helpmess;
	helpmess="---------------填写帮助---------------\r\n\r\n"+
		"1.请不要发表有危险性的脚本。\r\n\r\n"+
		"2.如果要书写源代码，请选中\r\n\r\n"+
		"　查看HTML源代码书写.\r\n\r\n"+
		"3.需要你自己运行,才能看效果.\r\n\r\n"+
		"4.如果书写js，尽量不要在这儿书写.\r\n\r\n";
	alert(helpmess);
}


function na_select_form (fname, type_name) 
{
	document.forms[fname].elements[type_name].select()
		document.forms[fname].elements[type_name].focus()
}

function checkdata(theform)
{
	if (theform.title.value=="")
	{
		alert("对不起，请输入文章标题！")
			theform.title.focus()
			return false
	}
	if (theform.viewhtml.checked == true)
	{
		alert("对不起，请取消“查看HTML源代码”后再添加！")
			theform.viewhtml.focus()
			return false
	}
}
</script>
			<select name="selectFont" onChange="FormatText('fontname', selectFont.options[selectFont.selectedIndex].value);document.myform.selectFont.options[0].selected = true;"  style="font-family: 宋体; font-size: 9pt" onmouseover="window.status='选择选定文字的字体。';return true;" onmouseout="window.status='';return true;">
			  <option selected>选择字体</option>
			  <option value="宋体">宋体</option>
			  <option value="楷体_GB2312">楷体</option>
			  <option value="新宋体">新宋体</option>
			  <option value="黑体">黑体</option>
			  <option value="隶书">隶书</option>
			  <option value="幼圆">幼圆</option>
			  <option value="Andale Mono">Andale Mono</option>
			  <option value=Arial>Arial</option>
			  <option value="Arial Black">Arial Black</option>
			  <option value="Book Antiqua">Book Antiqua</option>
			  <option value="Century Gothic">Century Gothic</option>
			  <option value="Comic Sans MS">Comic Sans MS</option>
			  <option value="Courier New">Courier New</option>
			  <option value=Georgia>Georgia</option>
			  <option value=Impact>Impact</option>
			  <option value=Tahoma>Tahoma</option>
			  <option value="Times New Roman" >Times New Roman</option>
			  <option value="Trebuchet MS">Trebuchet MS</option>
			  <option value="Script MT Bold">Script MT Bold</option>
			  <option value=Stencil>Stencil</option>
			  <option value=Verdana>Verdana</option>
			  <option value="Lucida Console">Lucida Console</option>
			</select>
			<select name="selectColour" onChange="FormatText('ForeColor',selectColour.options[selectColour.selectedIndex].value);document.myform.selectColour.options[0].selected = true;" onmouseover="window.status='选择选定文字的颜色。';return true;" onmouseout="window.status='';return true;">
			  <option value="0" selected>选择文字颜色</option>
			  <option style="background-color:#F0F8FF;color: #F0F8FF" value="#F0F8FF">#F0F8FF</option>
			  <option style="background-color:#FAEBD7;color: #FAEBD7" value="#FAEBD7">#FAEBD7</option>
			  <option style="background-color:#00FFFF;color: #00FFFF" value="#00FFFF">#00FFFF</option>
			  <option style="background-color:#7FFFD4;color: #7FFFD4" value="#7FFFD4">#7FFFD4</option>
			  <option style="background-color:#F0FFFF;color: #F0FFFF" value="#F0FFFF">#F0FFFF</option>
			  <option style="background-color:#F5F5DC;color: #F5F5DC" value="#F5F5DC">#F5F5DC</option>
			  <option style="background-color:#FFE4C4;color: #FFE4C4" value="#FFE4C4">#FFE4C4</option>
			  <option style="background-color:#000000;color: #000000" value="#000000">#000000</option>
			  <option style="background-color:#FFEBCD;color: #FFEBCD" value="#FFEBCD">#FFEBCD</option>
			  <option style="background-color:#0000FF;color: #0000FF" value="#0000FF">#0000FF</option>
			  <option style="background-color:#8A2BE2;color: #8A2BE2" value="#8A2BE2">#8A2BE2</option>
			  <option style="background-color:#A52A2A;color: #A52A2A" value="#A52A2A">#A52A2A</option>
			  <option style="background-color:#DEB887;color: #DEB887" value="#DEB887">#DEB887</option>
			  <option style="background-color:#5F9EA0;color: #5F9EA0" value="#5F9EA0">#5F9EA0</option>
			  <option style="background-color:#7FFF00;color: #7FFF00" value="#7FFF00">#7FFF00</option>
			  <option style="background-color:#D2691E;color: #D2691E" value="#D2691E">#D2691E</option>
			  <option style="background-color:#FF7F50;color: #FF7F50" value="#FF7F50">#FF7F50</option>
			  <option style="background-color:#6495ED;color: #6495ED" value="#6495ED">#6495ED</option>
			  <option style="background-color:#FFF8DC;color: #FFF8DC" value="#FFF8DC">#FFF8DC</option>
			  <option style="background-color:#DC143C;color: #DC143C" value="#DC143C">#DC143C</option>
			  <option style="background-color:#00FFFF;color: #00FFFF" value="#00FFFF">#00FFFF</option>
			  <option style="background-color:#00008B;color: #00008B" value="#00008B">#00008B</option>
			  <option style="background-color:#008B8B;color: #008B8B" value="#008B8B">#008B8B</option>
			  <option style="background-color:#B8860B;color: #B8860B" value="#B8860B">#B8860B</option>
			  <option style="background-color:#A9A9A9;color: #A9A9A9" value="#A9A9A9">#A9A9A9</option>
			  <option style="background-color:#006400;color: #006400" value="#006400">#006400</option>
			  <option style="background-color:#BDB76B;color: #BDB76B" value="#BDB76B">#BDB76B</option>
			  <option style="background-color:#8B008B;color: #8B008B" value="#8B008B">#8B008B</option>
			  <option style="background-color:#556B2F;color: #556B2F" value="#556B2F">#556B2F</option>
			  <option style="background-color:#FF8C00;color: #FF8C00" value="#FF8C00">#FF8C00</option>
			  <option style="background-color:#9932CC;color: #9932CC" value="#9932CC">#9932CC</option>
			  <option style="background-color:#8B0000;color: #8B0000" value="#8B0000">#8B0000</option>
			  <option style="background-color:#E9967A;color: #E9967A" value="#E9967A">#E9967A</option>
			  <option style="background-color:#8FBC8F;color: #8FBC8F" value="#8FBC8F">#8FBC8F</option>
			  <option style="background-color:#483D8B;color: #483D8B" value="#483D8B">#483D8B</option>
			  <option style="background-color:#2F4F4F;color: #2F4F4F" value="#2F4F4F">#2F4F4F</option>
			  <option style="background-color:#00CED1;color: #00CED1" value="#00CED1">#00CED1</option>
			  <option style="background-color:#9400D3;color: #9400D3" value="#9400D3">#9400D3</option>
			  <option style="background-color:#FF1493;color: #FF1493" value="#FF1493">#FF1493</option>
			  <option style="background-color:#00BFFF;color: #00BFFF" value="#00BFFF">#00BFFF</option>
			  <option style="background-color:#696969;color: #696969" value="#696969">#696969</option>
			  <option style="background-color:#1E90FF;color: #1E90FF" value="#1E90FF">#1E90FF</option>
			  <option style="background-color:#B22222;color: #B22222" value="#B22222">#B22222</option>
			  <option style="background-color:#FFFAF0;color: #FFFAF0" value="#FFFAF0">#FFFAF0</option>
			  <option style="background-color:#228B22;color: #228B22" value="#228B22">#228B22</option>
			  <option style="background-color:#FF00FF;color: #FF00FF" value="#FF00FF">#FF00FF</option>
			  <option style="background-color:#DCDCDC;color: #DCDCDC" value="#DCDCDC">#DCDCDC</option>
			  <option style="background-color:#F8F8FF;color: #F8F8FF" value="#F8F8FF">#F8F8FF</option>
			  <option style="background-color:#FFD700;color: #FFD700" value="#FFD700">#FFD700</option>
			  <option style="background-color:#DAA520;color: #DAA520" value="#DAA520">#DAA520</option>
			  <option style="background-color:#808080;color: #808080" value="#808080">#808080</option>
			  <option style="background-color:#008000;color: #008000" value="#008000">#008000</option>
			  <option style="background-color:#ADFF2F;color: #ADFF2F" value="#ADFF2F">#ADFF2F</option>
			  <option style="background-color:#F0FFF0;color: #F0FFF0" value="#F0FFF0">#F0FFF0</option>
			  <option style="background-color:#FF69B4;color: #FF69B4" value="#FF69B4">#FF69B4</option>
			  <option style="background-color:#CD5C5C;color: #CD5C5C" value="#CD5C5C">#CD5C5C</option>
			  <option style="background-color:#4B0082;color: #4B0082" value="#4B0082">#4B0082</option>
			  <option style="background-color:#FFFFF0;color: #FFFFF0" value="#FFFFF0">#FFFFF0</option>
			  <option style="background-color:#F0E68C;color: #F0E68C" value="#F0E68C">#F0E68C</option>
			  <option style="background-color:#E6E6FA;color: #E6E6FA" value="#E6E6FA">#E6E6FA</option>
			  <option style="background-color:#FFF0F5;color: #FFF0F5" value="#FFF0F5">#FFF0F5</option>
			  <option style="background-color:#7CFC00;color: #7CFC00" value="#7CFC00">#7CFC00</option>
			  <option style="background-color:#FFFACD;color: #FFFACD" value="#FFFACD">#FFFACD</option>
			  <option style="background-color:#ADD8E6;color: #ADD8E6" value="#ADD8E6">#ADD8E6</option>
			  <option style="background-color:#F08080;color: #F08080" value="#F08080">#F08080</option>
			  <option style="background-color:#E0FFFF;color: #E0FFFF" value="#E0FFFF">#E0FFFF</option>
			  <option style="background-color:#FAFAD2;color: #FAFAD2" value="#FAFAD2">#FAFAD2</option>
			  <option style="background-color:#90EE90;color: #90EE90" value="#90EE90">#90EE90</option>
			  <option style="background-color:#D3D3D3;color: #D3D3D3" value="#D3D3D3">#D3D3D3</option>
			  <option style="background-color:#FFB6C1;color: #FFB6C1" value="#FFB6C1">#FFB6C1</option>
			  <option style="background-color:#FFA07A;color: #FFA07A" value="#FFA07A">#FFA07A</option>
			  <option style="background-color:#20B2AA;color: #20B2AA" value="#20B2AA">#20B2AA</option>
			  <option style="background-color:#87CEFA;color: #87CEFA" value="#87CEFA">#87CEFA</option>
			  <option style="background-color:#778899;color: #778899" value="#778899">#778899</option>
			  <option style="background-color:#B0C4DE;color: #B0C4DE" value="#B0C4DE">#B0C4DE</option>
			  <option style="background-color:#FFFFE0;color: #FFFFE0" value="#FFFFE0">#FFFFE0</option>
			  <option style="background-color:#00FF00;color: #00FF00" value="#00FF00">#00FF00</option>
			  <option style="background-color:#32CD32;color: #32CD32" value="#32CD32">#32CD32</option>
			  <option style="background-color:#FAF0E6;color: #FAF0E6" value="#FAF0E6">#FAF0E6</option>
			  <option style="background-color:#FF00FF;color: #FF00FF" value="#FF00FF">#FF00FF</option>
			  <option style="background-color:#800000;color: #800000" value="#800000">#800000</option>
			  <option style="background-color:#66CDAA;color: #66CDAA" value="#66CDAA">#66CDAA</option>
			  <option style="background-color:#0000CD;color: #0000CD" value="#0000CD">#0000CD</option>
			  <option style="background-color:#BA55D3;color: #BA55D3" value="#BA55D3">#BA55D3</option>
			  <option style="background-color:#9370DB;color: #9370DB" value="#9370DB">#9370DB</option>
			  <option style="background-color:#3CB371;color: #3CB371" value="#3CB371">#3CB371</option>
			  <option style="background-color:#7B68EE;color: #7B68EE" value="#7B68EE">#7B68EE</option>
			  <option style="background-color:#00FA9A;color: #00FA9A" value="#00FA9A">#00FA9A</option>
			  <option style="background-color:#48D1CC;color: #48D1CC" value="#48D1CC">#48D1CC</option>
			  <option style="background-color:#C71585;color: #C71585" value="#C71585">#C71585</option>
			  <option style="background-color:#191970;color: #191970" value="#191970">#191970</option>
			  <option style="background-color:#F5FFFA;color: #F5FFFA" value="#F5FFFA">#F5FFFA</option>
			  <option style="background-color:#FFE4E1;color: #FFE4E1" value="#FFE4E1">#FFE4E1</option>
			  <option style="background-color:#FFE4B5;color: #FFE4B5" value="#FFE4B5">#FFE4B5</option>
			  <option style="background-color:#FFDEAD;color: #FFDEAD" value="#FFDEAD">#FFDEAD</option>
			  <option style="background-color:#000080;color: #000080" value="#000080">#000080</option>
			  <option style="background-color:#FDF5E6;color: #FDF5E6" value="#FDF5E6">#FDF5E6</option>
			  <option style="background-color:#808000;color: #808000" value="#808000">#808000</option>
			  <option style="background-color:#6B8E23;color: #6B8E23" value="#6B8E23">#6B8E23</option>
			  <option style="background-color:#FFA500;color: #FFA500" value="#FFA500">#FFA500</option>
			  <option style="background-color:#FF4500;color: #FF4500" value="#FF4500">#FF4500</option>
			  <option style="background-color:#DA70D6;color: #DA70D6" value="#DA70D6">#DA70D6</option>
			  <option style="background-color:#EEE8AA;color: #EEE8AA" value="#EEE8AA">#EEE8AA</option>
			  <option style="background-color:#98FB98;color: #98FB98" value="#98FB98">#98FB98</option>
			  <option style="background-color:#AFEEEE;color: #AFEEEE" value="#AFEEEE">#AFEEEE</option>
			  <option style="background-color:#DB7093;color: #DB7093" value="#DB7093">#DB7093</option>
			  <option style="background-color:#FFEFD5;color: #FFEFD5" value="#FFEFD5">#FFEFD5</option>
			  <option style="background-color:#FFDAB9;color: #FFDAB9" value="#FFDAB9">#FFDAB9</option>
			  <option style="background-color:#CD853F;color: #CD853F" value="#CD853F">#CD853F</option>
			  <option style="background-color:#FFC0CB;color: #FFC0CB" value="#FFC0CB">#FFC0CB</option>
			  <option style="background-color:#DDA0DD;color: #DDA0DD" value="#DDA0DD">#DDA0DD</option>
			  <option style="background-color:#B0E0E6;color: #B0E0E6" value="#B0E0E6">#B0E0E6</option>
			  <option style="background-color:#800080;color: #800080" value="#800080">#800080</option>
			  <option style="background-color:#FF0000;color: #FF0000" value="#FF0000">#FF0000</option>
			  <option style="background-color:#BC8F8F;color: #BC8F8F" value="#BC8F8F">#BC8F8F</option>
			  <option style="background-color:#4169E1;color: #4169E1" value="#4169E1">#4169E1</option>
			  <option style="background-color:#8B4513;color: #8B4513" value="#8B4513">#8B4513</option>
			  <option style="background-color:#FA8072;color: #FA8072" value="#FA8072">#FA8072</option>
			  <option style="background-color:#F4A460;color: #F4A460" value="#F4A460">#F4A460</option>
			  <option style="background-color:#2E8B57;color: #2E8B57" value="#2E8B57">#2E8B57</option>
			  <option style="background-color:#FFF5EE;color: #FFF5EE" value="#FFF5EE">#FFF5EE</option>
			  <option style="background-color:#A0522D;color: #A0522D" value="#A0522D">#A0522D</option>
			  <option style="background-color:#C0C0C0;color: #C0C0C0" value="#C0C0C0">#C0C0C0</option>
			  <option style="background-color:#87CEEB;color: #87CEEB" value="#87CEEB">#87CEEB</option>
			  <option style="background-color:#6A5ACD;color: #6A5ACD" value="#6A5ACD">#6A5ACD</option>
			  <option style="background-color:#708090;color: #708090" value="#708090">#708090</option>
			  <option style="background-color:#FFFAFA;color: #FFFAFA" value="#FFFAFA">#FFFAFA</option>
			  <option style="background-color:#00FF7F;color: #00FF7F" value="#00FF7F">#00FF7F</option>
			  <option style="background-color:#4682B4;color: #4682B4" value="#4682B4">#4682B4</option>
			  <option style="background-color:#D2B48C;color: #D2B48C" value="#D2B48C">#D2B48C</option>
			  <option style="background-color:#008080;color: #008080" value="#008080">#008080</option>
			  <option style="background-color:#D8BFD8;color: #D8BFD8" value="#D8BFD8">#D8BFD8</option>
			  <option style="background-color:#FF6347;color: #FF6347" value="#FF6347">#FF6347</option>
			  <option style="background-color:#40E0D0;color: #40E0D0" value="#40E0D0">#40E0D0</option>
			  <option style="background-color:#EE82EE;color: #EE82EE" value="#EE82EE">#EE82EE</option>
			  <option style="background-color:#F5DEB3;color: #F5DEB3" value="#F5DEB3">#F5DEB3</option>
			  <option style="background-color:#FFFFFF;color: #FFFFFF" value="#FFFFFF">#FFFFFF</option>
			  <option style="background-color:#F5F5F5;color: #F5F5F5" value="#F5F5F5">#F5F5F5</option>
			  <option style="background-color:#FFFF00;color: #FFFF00" value="#FFFF00">#FFFF00</option>
			  <option style="background-color:#9ACD32;color: #9ACD32" value="#9ACD32">#9ACD32</option>
			</select>
			<select name="selectbgColour" onChange="FormatText('BackColor',selectbgColour.options[selectbgColour.selectedIndex].value);document.myform.selectbgColour.options[0].selected = true;" onmouseover="window.status='选择选定文字的背景颜色。';return true;" onmouseout="window.status='';return true;">
			  <option value="0" selected>选择文字背景颜色</option>
			  <option style="background-color:#F0F8FF;color: #F0F8FF" value="#F0F8FF">#F0F8FF</option>
			  <option style="background-color:#FAEBD7;color: #FAEBD7" value="#FAEBD7">#FAEBD7</option>
			  <option style="background-color:#00FFFF;color: #00FFFF" value="#00FFFF">#00FFFF</option>
			  <option style="background-color:#7FFFD4;color: #7FFFD4" value="#7FFFD4">#7FFFD4</option>
			  <option style="background-color:#F0FFFF;color: #F0FFFF" value="#F0FFFF">#F0FFFF</option>
			  <option style="background-color:#F5F5DC;color: #F5F5DC" value="#F5F5DC">#F5F5DC</option>
			  <option style="background-color:#FFE4C4;color: #FFE4C4" value="#FFE4C4">#FFE4C4</option>
			  <option style="background-color:#000000;color: #000000" value="#000000">#000000</option>
			  <option style="background-color:#FFEBCD;color: #FFEBCD" value="#FFEBCD">#FFEBCD</option>
			  <option style="background-color:#0000FF;color: #0000FF" value="#0000FF">#0000FF</option>
			  <option style="background-color:#8A2BE2;color: #8A2BE2" value="#8A2BE2">#8A2BE2</option>
			  <option style="background-color:#A52A2A;color: #A52A2A" value="#A52A2A">#A52A2A</option>
			  <option style="background-color:#DEB887;color: #DEB887" value="#DEB887">#DEB887</option>
			  <option style="background-color:#5F9EA0;color: #5F9EA0" value="#5F9EA0">#5F9EA0</option>
			  <option style="background-color:#7FFF00;color: #7FFF00" value="#7FFF00">#7FFF00</option>
			  <option style="background-color:#D2691E;color: #D2691E" value="#D2691E">#D2691E</option>
			  <option style="background-color:#FF7F50;color: #FF7F50" value="#FF7F50">#FF7F50</option>
			  <option style="background-color:#6495ED;color: #6495ED" value="#6495ED">#6495ED</option>
			  <option style="background-color:#FFF8DC;color: #FFF8DC" value="#FFF8DC">#FFF8DC</option>
			  <option style="background-color:#DC143C;color: #DC143C" value="#DC143C">#DC143C</option>
			  <option style="background-color:#00FFFF;color: #00FFFF" value="#00FFFF">#00FFFF</option>
			  <option style="background-color:#00008B;color: #00008B" value="#00008B">#00008B</option>
			  <option style="background-color:#008B8B;color: #008B8B" value="#008B8B">#008B8B</option>
			  <option style="background-color:#B8860B;color: #B8860B" value="#B8860B">#B8860B</option>
			  <option style="background-color:#A9A9A9;color: #A9A9A9" value="#A9A9A9">#A9A9A9</option>
			  <option style="background-color:#006400;color: #006400" value="#006400">#006400</option>
			  <option style="background-color:#BDB76B;color: #BDB76B" value="#BDB76B">#BDB76B</option>
			  <option style="background-color:#8B008B;color: #8B008B" value="#8B008B">#8B008B</option>
			  <option style="background-color:#556B2F;color: #556B2F" value="#556B2F">#556B2F</option>
			  <option style="background-color:#FF8C00;color: #FF8C00" value="#FF8C00">#FF8C00</option>
			  <option style="background-color:#9932CC;color: #9932CC" value="#9932CC">#9932CC</option>
			  <option style="background-color:#8B0000;color: #8B0000" value="#8B0000">#8B0000</option>
			  <option style="background-color:#E9967A;color: #E9967A" value="#E9967A">#E9967A</option>
			  <option style="background-color:#8FBC8F;color: #8FBC8F" value="#8FBC8F">#8FBC8F</option>
			  <option style="background-color:#483D8B;color: #483D8B" value="#483D8B">#483D8B</option>
			  <option style="background-color:#2F4F4F;color: #2F4F4F" value="#2F4F4F">#2F4F4F</option>
			  <option style="background-color:#00CED1;color: #00CED1" value="#00CED1">#00CED1</option>
			  <option style="background-color:#9400D3;color: #9400D3" value="#9400D3">#9400D3</option>
			  <option style="background-color:#FF1493;color: #FF1493" value="#FF1493">#FF1493</option>
			  <option style="background-color:#00BFFF;color: #00BFFF" value="#00BFFF">#00BFFF</option>
			  <option style="background-color:#696969;color: #696969" value="#696969">#696969</option>
			  <option style="background-color:#1E90FF;color: #1E90FF" value="#1E90FF">#1E90FF</option>
			  <option style="background-color:#B22222;color: #B22222" value="#B22222">#B22222</option>
			  <option style="background-color:#FFFAF0;color: #FFFAF0" value="#FFFAF0">#FFFAF0</option>
			  <option style="background-color:#228B22;color: #228B22" value="#228B22">#228B22</option>
			  <option style="background-color:#FF00FF;color: #FF00FF" value="#FF00FF">#FF00FF</option>
			  <option style="background-color:#DCDCDC;color: #DCDCDC" value="#DCDCDC">#DCDCDC</option>
			  <option style="background-color:#F8F8FF;color: #F8F8FF" value="#F8F8FF">#F8F8FF</option>
			  <option style="background-color:#FFD700;color: #FFD700" value="#FFD700">#FFD700</option>
			  <option style="background-color:#DAA520;color: #DAA520" value="#DAA520">#DAA520</option>
			  <option style="background-color:#808080;color: #808080" value="#808080">#808080</option>
			  <option style="background-color:#008000;color: #008000" value="#008000">#008000</option>
			  <option style="background-color:#ADFF2F;color: #ADFF2F" value="#ADFF2F">#ADFF2F</option>
			  <option style="background-color:#F0FFF0;color: #F0FFF0" value="#F0FFF0">#F0FFF0</option>
			  <option style="background-color:#FF69B4;color: #FF69B4" value="#FF69B4">#FF69B4</option>
			  <option style="background-color:#CD5C5C;color: #CD5C5C" value="#CD5C5C">#CD5C5C</option>
			  <option style="background-color:#4B0082;color: #4B0082" value="#4B0082">#4B0082</option>
			  <option style="background-color:#FFFFF0;color: #FFFFF0" value="#FFFFF0">#FFFFF0</option>
			  <option style="background-color:#F0E68C;color: #F0E68C" value="#F0E68C">#F0E68C</option>
			  <option style="background-color:#E6E6FA;color: #E6E6FA" value="#E6E6FA">#E6E6FA</option>
			  <option style="background-color:#FFF0F5;color: #FFF0F5" value="#FFF0F5">#FFF0F5</option>
			  <option style="background-color:#7CFC00;color: #7CFC00" value="#7CFC00">#7CFC00</option>
			  <option style="background-color:#FFFACD;color: #FFFACD" value="#FFFACD">#FFFACD</option>
			  <option style="background-color:#ADD8E6;color: #ADD8E6" value="#ADD8E6">#ADD8E6</option>
			  <option style="background-color:#F08080;color: #F08080" value="#F08080">#F08080</option>
			  <option style="background-color:#E0FFFF;color: #E0FFFF" value="#E0FFFF">#E0FFFF</option>
			  <option style="background-color:#FAFAD2;color: #FAFAD2" value="#FAFAD2">#FAFAD2</option>
			  <option style="background-color:#90EE90;color: #90EE90" value="#90EE90">#90EE90</option>
			  <option style="background-color:#D3D3D3;color: #D3D3D3" value="#D3D3D3">#D3D3D3</option>
			  <option style="background-color:#FFB6C1;color: #FFB6C1" value="#FFB6C1">#FFB6C1</option>
			  <option style="background-color:#FFA07A;color: #FFA07A" value="#FFA07A">#FFA07A</option>
			  <option style="background-color:#20B2AA;color: #20B2AA" value="#20B2AA">#20B2AA</option>
			  <option style="background-color:#87CEFA;color: #87CEFA" value="#87CEFA">#87CEFA</option>
			  <option style="background-color:#778899;color: #778899" value="#778899">#778899</option>
			  <option style="background-color:#B0C4DE;color: #B0C4DE" value="#B0C4DE">#B0C4DE</option>
			  <option style="background-color:#FFFFE0;color: #FFFFE0" value="#FFFFE0">#FFFFE0</option>
			  <option style="background-color:#00FF00;color: #00FF00" value="#00FF00">#00FF00</option>
			  <option style="background-color:#32CD32;color: #32CD32" value="#32CD32">#32CD32</option>
			  <option style="background-color:#FAF0E6;color: #FAF0E6" value="#FAF0E6">#FAF0E6</option>
			  <option style="background-color:#FF00FF;color: #FF00FF" value="#FF00FF">#FF00FF</option>
			  <option style="background-color:#800000;color: #800000" value="#800000">#800000</option>
			  <option style="background-color:#66CDAA;color: #66CDAA" value="#66CDAA">#66CDAA</option>
			  <option style="background-color:#0000CD;color: #0000CD" value="#0000CD">#0000CD</option>
			  <option style="background-color:#BA55D3;color: #BA55D3" value="#BA55D3">#BA55D3</option>
			  <option style="background-color:#9370DB;color: #9370DB" value="#9370DB">#9370DB</option>
			  <option style="background-color:#3CB371;color: #3CB371" value="#3CB371">#3CB371</option>
			  <option style="background-color:#7B68EE;color: #7B68EE" value="#7B68EE">#7B68EE</option>
			  <option style="background-color:#00FA9A;color: #00FA9A" value="#00FA9A">#00FA9A</option>
			  <option style="background-color:#48D1CC;color: #48D1CC" value="#48D1CC">#48D1CC</option>
			  <option style="background-color:#C71585;color: #C71585" value="#C71585">#C71585</option>
			  <option style="background-color:#191970;color: #191970" value="#191970">#191970</option>
			  <option style="background-color:#F5FFFA;color: #F5FFFA" value="#F5FFFA">#F5FFFA</option>
			  <option style="background-color:#FFE4E1;color: #FFE4E1" value="#FFE4E1">#FFE4E1</option>
			  <option style="background-color:#FFE4B5;color: #FFE4B5" value="#FFE4B5">#FFE4B5</option>
			  <option style="background-color:#FFDEAD;color: #FFDEAD" value="#FFDEAD">#FFDEAD</option>
			  <option style="background-color:#000080;color: #000080" value="#000080">#000080</option>
			  <option style="background-color:#FDF5E6;color: #FDF5E6" value="#FDF5E6">#FDF5E6</option>
			  <option style="background-color:#808000;color: #808000" value="#808000">#808000</option>
			  <option style="background-color:#6B8E23;color: #6B8E23" value="#6B8E23">#6B8E23</option>
			  <option style="background-color:#FFA500;color: #FFA500" value="#FFA500">#FFA500</option>
			  <option style="background-color:#FF4500;color: #FF4500" value="#FF4500">#FF4500</option>
			  <option style="background-color:#DA70D6;color: #DA70D6" value="#DA70D6">#DA70D6</option>
			  <option style="background-color:#EEE8AA;color: #EEE8AA" value="#EEE8AA">#EEE8AA</option>
			  <option style="background-color:#98FB98;color: #98FB98" value="#98FB98">#98FB98</option>
			  <option style="background-color:#AFEEEE;color: #AFEEEE" value="#AFEEEE">#AFEEEE</option>
			  <option style="background-color:#DB7093;color: #DB7093" value="#DB7093">#DB7093</option>
			  <option style="background-color:#FFEFD5;color: #FFEFD5" value="#FFEFD5">#FFEFD5</option>
			  <option style="background-color:#FFDAB9;color: #FFDAB9" value="#FFDAB9">#FFDAB9</option>
			  <option style="background-color:#CD853F;color: #CD853F" value="#CD853F">#CD853F</option>
			  <option style="background-color:#FFC0CB;color: #FFC0CB" value="#FFC0CB">#FFC0CB</option>
			  <option style="background-color:#DDA0DD;color: #DDA0DD" value="#DDA0DD">#DDA0DD</option>
			  <option style="background-color:#B0E0E6;color: #B0E0E6" value="#B0E0E6">#B0E0E6</option>
			  <option style="background-color:#800080;color: #800080" value="#800080">#800080</option>
			  <option style="background-color:#FF0000;color: #FF0000" value="#FF0000">#FF0000</option>
			  <option style="background-color:#BC8F8F;color: #BC8F8F" value="#BC8F8F">#BC8F8F</option>
			  <option style="background-color:#4169E1;color: #4169E1" value="#4169E1">#4169E1</option>
			  <option style="background-color:#8B4513;color: #8B4513" value="#8B4513">#8B4513</option>
			  <option style="background-color:#FA8072;color: #FA8072" value="#FA8072">#FA8072</option>
			  <option style="background-color:#F4A460;color: #F4A460" value="#F4A460">#F4A460</option>
			  <option style="background-color:#2E8B57;color: #2E8B57" value="#2E8B57">#2E8B57</option>
			  <option style="background-color:#FFF5EE;color: #FFF5EE" value="#FFF5EE">#FFF5EE</option>
			  <option style="background-color:#A0522D;color: #A0522D" value="#A0522D">#A0522D</option>
			  <option style="background-color:#C0C0C0;color: #C0C0C0" value="#C0C0C0">#C0C0C0</option>
			  <option style="background-color:#87CEEB;color: #87CEEB" value="#87CEEB">#87CEEB</option>
			  <option style="background-color:#6A5ACD;color: #6A5ACD" value="#6A5ACD">#6A5ACD</option>
			  <option style="background-color:#708090;color: #708090" value="#708090">#708090</option>
			  <option style="background-color:#FFFAFA;color: #FFFAFA" value="#FFFAFA">#FFFAFA</option>
			  <option style="background-color:#00FF7F;color: #00FF7F" value="#00FF7F">#00FF7F</option>
			  <option style="background-color:#4682B4;color: #4682B4" value="#4682B4">#4682B4</option>
			  <option style="background-color:#D2B48C;color: #D2B48C" value="#D2B48C">#D2B48C</option>
			  <option style="background-color:#008080;color: #008080" value="#008080">#008080</option>
			  <option style="background-color:#D8BFD8;color: #D8BFD8" value="#D8BFD8">#D8BFD8</option>
			  <option style="background-color:#FF6347;color: #FF6347" value="#FF6347">#FF6347</option>
			  <option style="background-color:#40E0D0;color: #40E0D0" value="#40E0D0">#40E0D0</option>
			  <option style="background-color:#EE82EE;color: #EE82EE" value="#EE82EE">#EE82EE</option>
			  <option style="background-color:#F5DEB3;color: #F5DEB3" value="#F5DEB3">#F5DEB3</option>
			  <option style="background-color:#FFFFFF;color: #FFFFFF" value="#FFFFFF">#FFFFFF</option>
			  <option style="background-color:#F5F5F5;color: #F5F5F5" value="#F5F5F5">#F5F5F5</option>
			  <option style="background-color:#FFFF00;color: #FFFF00" value="#FFFF00">#FFFF00</option>
			  <option style="background-color:#9ACD32;color: #9ACD32" value="#9ACD32">#9ACD32</option>
			</select>
			<select language="javascript"  id="FontSize" title="字号大小" onChange="FormatText('fontsize',this[this.selectedIndex].value);" name="select" onmouseover="window.status='选择选定文字的字号大小。';return true;" onmouseout="window.status='';return true;">
			  <option class="heading" selected>字号 </option>
			  <option value="7">一号 </option>
			  <option value="6">二号 </option>
			  <option value="5">三号 </option>
			  <option value="4">四号 </option>
			  <option value="3">五号 </option>
			  <option value="2">六号 </option>
			  <option value="1">七号</option>
			</select>
			<input onClick="setMode(this.checked);"type="checkbox" name="viewhtml"  value="ON" />
		  <?php echo $lang['n_html']?><br />
		  <img src=./editor/image/s.gif /><br />
		  <img src="./editor/image/selectall.gif" align="absmiddle" border="0" alt="全部选择" onClick="FormatText('selectall')" style="cursor: hand;" /> <img src="./editor/image/cut.gif"  align="absmiddle" onClick="FormatText('cut')" style="cursor: hand;" alt="剪切" /> <img src="./editor/image/copy.gif"  align="absmiddle" onClick="FormatText('copy')" style="cursor: hand;" alt="复制" /> <img src="./editor/image/paste.gif"  align="absmiddle" onClick="FormatText('paste')" style="cursor: hand;" alt="粘贴" /> <img src="./editor/image/del.gif" align="absmiddle" border="0" alt="删除" onClick="FormatText('DELETE')" style="cursor: hand;" /> <img src="./editor/image/undo.gif" align="absmiddle" border="0" alt="撤消" onClick="FormatText('undo')" style="cursor: hand;" /> <img src="./editor/image/redo.gif" align="absmiddle" border="0" alt="恢复" onClick="FormatText('redo')" style="cursor: hand;" /> <img src="./editor/image/bold.gif" align="absmiddle" alt="粗体" onClick="FormatText('bold', '')" style="cursor: hand;" /> <img src="./editor/image/italic.gif" align="absmiddle" alt="斜体" onClick="FormatText('italic', '')" style="cursor: hand;" /> <img src="./editor/image/underline.gif" align="absmiddle" alt="下划线" onClick="FormatText('underline', '')" style="cursor: hand;" /> <img src="./editor/image/Aleft.gif" align="absmiddle" onClick="FormatText('Justifyleft', '')" style="cursor: hand;" alt="左对齐" /> <img src="./editor/image/Acenter.gif" align="absmiddle" border="0" alt="居中" onClick="FormatText('JustifyCenter', '')" style="cursor: hand;" /> <img src="./editor/image/Aright.gif" align="absmiddle" onClick="FormatText('JustifyRight', '')" style="cursor: hand;" alt="右对齐" /> <img src="./editor/image/list.gif" align="absmiddle" border="0" alt="项目符号" onClick="FormatText('InsertUnorderedList', '')" style="cursor: hand;" /> <img src="./editor/image/num.gif" align="absmiddle" alt="编号" border="0" onClick="FormatText('insertorderedlist', '')" style="cursor: hand;" /> <img src="./editor/image/outdent.gif" align="absmiddle" onClick="FormatText('Outdent', '')" style="cursor: hand;" alt="回退" /> <img src="./editor/image/indent.gif" align="absmiddle" border="0" alt="缩进" onClick="FormatText('indent', '')" style="cursor: hand;" /> <img src="./editor/image/line.gif" align="absmiddle" alt="普通水平线" border="0" onClick="FormatText('InsertHorizontalRule', '')"  style="cursor: hand;" /> <img src="./editor/image/sline.gif" align="absmiddle" alt="特殊水平线" border="0" onClick="hr()"  style="cursor: hand;" /> <img src="./editor/image/sup.gif" align="absmiddle" border="0" alt="上标" onClick="FormatText('superscript')" style="cursor: hand;" /> <img src="./editor/image/sub.gif" align="absmiddle" border="0" alt="下标" onClick="FormatText('subscript')" style="cursor: hand;" /> <img src="./editor/image/clear.gif" align="absmiddle" border="0" alt="删除文字格式" onClick="FormatText('RemoveFormat')" style="cursor: hand;" /> <br />
		  <img src=./editor/image/s.gif /><br /><img src="./editor/image/clearword.gif" align="absmiddle" border="0" alt="删除文字WORD格式" onClick="cleanWordString()" style="cursor: hand;" />
		  <img src="./editor/image/url.gif" align="absmiddle" border="0" alt="超级链接" onClick="FormatText('createLink')" style="cursor: hand;" /> <img src="./editor/image/nourl.gif" align="absmiddle" border="0" alt="取消超级链接" onClick="FormatText('unLink')" style="cursor: hand;" /> <img src="./editor/image/fieldset.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入栏目框" language="javascript" onClick="FIELDSET()" /> <img src="./editor/image/htm.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入网页" language="javascript" onClick="iframe()" /> <img src="./editor/image/table.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入表格" language="javascript" onClick="fortable()" /> <img src="./editor/image/flash.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入FLASH" language="javascript" onClick="swf()" /> <img src="./editor/image/wmv.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入视频文件，支持格式为：avi、wmv、asf" language="javascript" onClick="wmv()" /> <img src="./editor/image/rm.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入RealPlay文件，支持格式为：rm、ra、ram" language="javascript" onClick="rm()" /> <img src="./editor/image/img.gif" align="absmiddle" border="0" style="cursor:hand;" alt="插入网上图片，支持格式为：gif、jpg、png、bmp" language="javascript" onClick="pic()" /> <img src="./editor/image/help.gif" align="absmiddle" border="0" style="cursor:hand;" alt="使用帮助" language="javascript" onClick="help()" /> <a href="javascript:openWin('upload.php','upload','toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=228')"><img src="./editor/image/upfile.gif" align="absmiddle" border="0" alt="上传文件" style="cursor: hand;" onMouseOver="window.status='使用系统自带的上传程序上传文件';return true;" onMouseOut="window.status='';return true;" /></a> <img src="./editor/image/insertpage.gif" alt="插入分页符"  border="0" align="absmiddle" style="cursor: hand;" onMouseOver="window.status='插入分页符';return true;" onMouseOut="window.status='';return true;" onClick="insertpage()" /> <br />
		  <img src=./editor/image/s.gif /><br />
<script language="javascript">
document.write ('<iframe id="message" width="550" height="275" src="./editor/textarea.htm"></iframe>')
</script>
		</td>
	  </tr>
 <tr>
		<td class="tablerow"><?php echo $lang['n_pics']?></td>
		<td class="tablerow"> 
		<input  type="hidden" name="pictrues" id="pictrues">
		<input name="defaultpicurl" type='text' id='defaultpicurl' value="nopic.gif" size='50' maxlength='255' readonly />&nbsp;<select name="news_pic" id="news_pic" onChange="myform.defaultpicurl.value=this.value;"> <option value="nopic.gif"><?php echo $lang['n_nopics']?></option></select></td>
	  </tr>
	  <tr>
		<td class="tablerow"><?php echo $lang['n_other']?></td>
		<td class="tablerow"> <?php echo $lang['n_cmt']?>
	   <input  type="checkbox" name="cmt"  value="1" />&nbsp;<?php echo $lang['n_type2']?> &nbsp;
		  <select id='placard' name='placard' >
			<option  value="0" selected="selected"><?php echo $lang['n_type2_0']?></option>
			<option value="1"><?php echo $lang['n_type2_1']?></option>
			<option  value="2"><?php echo $lang['n_type2_2']?></option>
			<option  value="3"><?php echo $lang['n_type2_3']?></option>
			<option  value="4"><?php echo $lang['n_type2_4']?></option>
		  </select>
		</td>
	  </tr>
	</tbody>
	<tr>
	  <td class="tablerow"></td>
	  <td class="tablerow"><input type="submit" name="Submit" value="<?php echo $lang['submit']?>" />
		&nbsp;
		<input type="reset" name="Reset" value="<?php echo $lang['reset']?>" />
	  </td>
	</tr>
  </form>
</table>
<?php 
}
else 
{ echo "<script> location.href='error.htm';</script>";}
?>
</body>
</html>
