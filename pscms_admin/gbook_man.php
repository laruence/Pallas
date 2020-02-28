<?php 
require('session.inc');
if($action != 'add'){
if(empty($_SESSION['log']) && $_SESSION['log']!=true)
{ //check login? 
echo "<script>window.location.replace('error.htm')</script>";
die(0054);
}
}
require_once('news.php');
switch($glo_language)
{
case 'zh_cn':
  require_once('languages/lang_zh_cn.php');
case 'eng':
  require_once('languages/lang_eng.php');
}
if($action==pass&&$commit==yes)
{
$sql="update $T_GBOOK set gb_pass=gb_pass xor 1 where gb_id=$id";
$result=mysql_query($sql) or die(mysql_error());
if($result) echo "<script>alert('操作成功!'); window.location.replace('gbook_man.php');</script>";
die('ok');
}


if($action==delete&&$commit==yes)
{
$sql="delete from $T_GBOOK where gb_id=$id or gb_reply=$id";
$result=mysql_query($sql) or die(mysql_error());
if($result) echo "<script>alert('操作成功!'); window.location.replace('gbook_man.php');</script>";
die('ok');
}


if($action==ans&&$commit==yes)
{
if($ans)
{
$sql="delete from $T_GBOOK where gb_reply=$id";
$result=mysql_query($sql) or die (mysql_error());
}

$sql="update $T_GBOOK set gb_ans=1 ,gb_pass=$passed where gb_id=$id ";
mysql_query($sql) or die(mysql_error());


$date=date(YmdHis);
$ip=$_SERVER['REMOTE_ADDR'];
$sql="insert into $T_GBOOK (gb_name,gb_sex,gb_email,gb_qq,gb_date,gb_msn,gb_tel,gb_add,gb_homepage,gb_title,gb_content,gb_ip,gb_face,gb_reply) values('$loginname','1','1','1','$date','1','1','1','1','1','$content','$ip','1','$id')";
$result=mysql_query($sql) or die(mysql_error());
if($result) echo "<script>alert('操作成功!'); window.location.replace('gbook_man.php');</script>";
die('ok');
}


if($action==add&&$commit==yes)
{//添加留言
 if($authnum==$checkcode)
 {
 
 $date=date(YmdHis);
 $ip=$_SERVER['REMOTE_ADDR'];
 
 $image=$Image.".gif";
 
 $sql="insert into $T_GBOOK (gb_name,gb_sex,gb_email,gb_qq,gb_date,gb_msn,gb_tel,gb_add,gb_homepage,gb_title,gb_content,gb_ip,gb_face) values('$name','$gender','$email','$qq','$date','$msn','$telephone','$address','$homepage','$title','$content','$ip','$image')";
 $result=mysql_query($sql) or die(mysql_error());
if($result)
{
if($refer=="consult")
 echo "<script>alert('您的问题\"".$title."\"已经提交成功，我们会尽快通过Email解答您的问题'); window.history.go(-1);</script>";
 else
 echo "<script>alert('".$title."留言成功!请等待管理员审批!'); window.history.go(-1);</script>";
}
}
else {  
        $msg="验证码错误,请重新填写";
        alert($msg);
		echo "<script> window.history.go(-1)</script>";
		}
} 

if($action==reply&&$commit=yes)
{?>
 
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php echo $lang['site_man']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
<SCRIPT language=javaScript src="gbook/ubb/postcode.js" 
type=text/javascript></SCRIPT>
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
<script language=JavaScript>

// 表单提交检测
function doCheck(){

if (document.myform.content.value=="") {
alert("请输入留言内容");
return false;
}
}
</script>
<body >
<?php $sql="select * from $T_GBOOK where gb_id=$id";
   $result=mysql_query($sql) or die(mysql_error());
   $rows=mysql_fetch_array($result,MYSQL_BOTH);
   ?>

<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2 class="STYLE1"><?php echo $lang['revert_gbook']?></th>
  </tr>
   <form action="?action=ans&id=<?php echo $rows['gb_id']?>&ans=<?php echo $rows['gb_ans']?>&commit=yes" method="post" name="myform" onSubmit="return doCheck();">
    <tr> 
      <td class="tablerowhighlight" colspan=2><?php echo $lang['gbook_theme']?>：<?php echo $rows['gb_title']?> --- <?php echo $rows['gb_date']?></td>
   </td>
    <tr> 
      <td class="tablerow" width="30%">
      <img src="gbook/face/<?php echo $rows['gb_face']?>" width="80" height="90"><br>
     <?php echo $lang['name']?>：<?php echo $rows['gb_name']?><br>
	 <?php echo $lang['sex']?>：<?php echo $rows['gb_sex']? $lang['male']:$lang['female'];?><br>
     E-mail：<?php echo $rows['gb_email']?><br>QQ：<?php echo $rows['gb_qq']?><br>MSN：<?php echo $rows['gb_msn']?><br><?php echo $lang['homepage']?>：<?php echo $rows['gb_homepage']?><br><?php echo $lang['tel']?>：<?php echo $rows['gb_tel']?><br><?php echo $lang['addr']?>：<?php echo $rows['gb_add']?><br>IP：<?php echo $rows['gb_ip']?>      </td>
      <td class="tablerow" valign="top">
<?php echo $rows['gb_content']?>
  <?php if($rows['gb_ans'])
   {
 $sql="select * from $T_GBOOK where gb_reply=$id";
 $result=mysql_query($sql);
 $rows_ans=mysql_fetch_array($result,MYSQL_BOTH);   
    ?>
   <table cellpadding="10" cellspacing="1" border="0" width="96%" bgcolor="#dddddd">
  <tr>
    <td bgcolor="#efefef"><font color=red><b><?php echo $lang['administrator']?>[<?php echo $rows_ans['gb_name']?>]<?php echo $lang['at']?><?php echo $rows_ans['gb_date']?><?php echo $lang['revert']?>：</b></font><br>
          <?php echo $rows_ans['gb_content']?></td>
  </tr>
</table>
<?php } ?>
  
     </td>
    </tr>
    <tr> 
      <td class="tablerow"><?php echo $lang['gbook_content']?>：</td>
      <td class="tablerow">
       
          <SELECT 
      onchange=showfont(this.options[this.selectedIndex].value) size=1 
        name=font> 
            <OPTION value=no selected><?php echo $lang['font']?></OPTION>
            <OPTION 
        value=宋体><?php echo $lang['font_1']?></OPTION>
            <OPTION value=楷体_GB2312><?php echo $lang['font_2']?></OPTION>
            <OPTION 
        value=新宋体><?php echo $lang['font_3']?></OPTION>
            <OPTION value=黑体><?php echo $lang['font_4']?></OPTION>
            <OPTION 
        value=隶书><?php echo $lang['font_5']?></OPTION> 
            <OPTION value=Arial>Arial</OPTION> 
            <OPTION 
        value=Impact>Impact</OPTION> 
            <OPTION value=Tahoma>Tahoma</OPTION> 
            <OPTION value="Times New Roman">Times New Roman</OPTION> 
            <OPTION 
        value=else><?php echo $lang['font_others']?></OPTION>
          </SELECT> 
          <SELECT 
      onchange=showsize(this.options[this.selectedIndex].value) size=1 
        name=size> 
            <OPTION selected><?php echo $lang['font_size']?></OPTION> 
            <OPTION value=9>9</OPTION> 
            <OPTION value=10>10</OPTION> 
            <OPTION value=11>11</OPTION> 
            <OPTION 
        value=12>12</OPTION> 
            <OPTION value=18>18</OPTION> 
            <OPTION 
        value=36>36</OPTION> 
            <OPTION value=72>72</OPTION> 
            <OPTION 
        value=else><?php echo $lang['font_others']?></OPTION>
          </SELECT> 
          <SELECT 
      onchange=showcolor(this.options[this.selectedIndex].value) size=1 
      name=color> 
            <OPTION value=no selected><?php echo $lang['color']?></OPTION> 
            <OPTION 
        style="COLOR: #000000; BACKGROUND-COLOR: #000000" 
        value=#000000>#000000</OPTION> 
            <OPTION 
        style="COLOR: #ffffff; BACKGROUND-COLOR: #ffffff" 
        value=#FFFFFF>#FFFFFF</OPTION> 
            <OPTION 
        style="COLOR: #ff0000; BACKGROUND-COLOR: #ff0000" 
        value=#FF0000>#FF0000</OPTION> 
            <OPTION 
        style="COLOR: #00ff00; BACKGROUND-COLOR: #00ff00" 
        value=#00FF00>#00FF00</OPTION> 
            <OPTION 
        style="COLOR: #0000ff; BACKGROUND-COLOR: #0000ff" 
        value=#0000FF>#0000FF</OPTION> 
            <OPTION 
        style="COLOR: #00ffff; BACKGROUND-COLOR: #00ffff" 
        value=#00FFFF>#00FFFF</OPTION> 
            <OPTION 
        style="COLOR: #ffebcd; BACKGROUND-COLOR: #ffebcd" 
        value=#FFEBCD>#FFEBCD</OPTION> 
            <OPTION 
        style="COLOR: #5f9ea0; BACKGROUND-COLOR: #5f9ea0" 
        value=#5F9EA0>#5F9EA0</OPTION> 
            <OPTION 
        style="COLOR: #6495ed; BACKGROUND-COLOR: #6495ed" 
        value=#6495ED>#6495ED</OPTION> 
            <OPTION><?php echo $lang['font_others']?></OPTION>
          </SELECT> 
         
		  <br>
 <IMG onclick=bold() height=22 alt=粗体字 src="gbook/ubb/bold.gif" 
      width=23> <IMG onclick=italicize() height=22 alt=斜体字 
      src="gbook/ubb/italicize.gif" width=23> <IMG 
      onclick=underline() height=22 alt=下划线 
      src="gbook/ubb/underline.gif" width=23> <IMG onclick=center() 
      height=22 alt=对齐 src="gbook/ubb/center.gif" width=23> <IMG 
      onclick=hyperlink() height=22 alt=插入超级链接 
      src="gbook/ubb/url.gif" width=23><IMG 
      onclick=image() height=22 alt=插入图片 src="gbook/ubb/image.gif" 
      width=23> <IMG onclick=setswf() height=22 alt=插入FLASH 
      src="gbook/ubb/swf.gif" width=23> <IMG onclick=list() height=22 
      alt=插入列表 src="gbook/ubb/list.gif" width=23> <IMG 
      onclick=showcode() height=22 alt=插入代码 src="gbook/ubb/code.gif" 
      width=23> <IMG onclick=setfly() height=22 alt=飞行字 
      src="gbook/ubb/fly.gif" width=23> <IMG onclick=shadow() 
      height=22 alt=阴影字 src="gbook/ubb/shadow.gif" width=23> <br>
      <textarea id=content name=content rows=12 cols=50></textarea></td>
    </tr>
    <tr>
         <td class="tablerow"><?php echo $lang['authorize_or_not']?>：</td>
         <td class="tablerow"><input type='radio' name='passed' value='1' checked > <?php echo $lang['yes']?> <input type='radio' name='passed' value='0' > <?php echo $lang['no']?></td>
   </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="Submit" value=" <?php echo $lang['yes']?>"> 
        &nbsp; <input type="reset" name="Reset" value=" <?php echo $lang['no']?> "> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php }
if($action==NULL)
{
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php echo $lang['site_gbook_man']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
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

$sql="select * from $T_GBOOK where gb_reply=0 order by gb_date desc";
$result=mysql_query($sql) or die(mysql_error());
$total=mysql_num_rows($result);
if(!$page)$page =0;
$eachpage=15;
$start=$page*$eachpage;
$end=$start+$eachpage;
if($end>$total) $end =$total;
$totalpage =$total/$eachpage;
$pagestr="$lang[total]".$total."news ";
if($page>0) $pagestr=$pagestr."[<a href=".$PATH_INFO."?page=".($page-1)."&delete=yes>$lang[previous_page]</a>] ";
$pagestr=$pagestr."[$lang[rank]";
for ($i=0;$i<$totalpage;$i++)
{
 if ($i!=$page) {$pagestr=$pagestr."<a href=".$PATH_INFO."?page=".$i."&delete=yes>".($i+1)."</a> ";}
 else {$pagestr=$pagestr.($i+1)." ";}
}
$pagestr=$pagestr."$lang[page]]";

if ($page<($totalpage-1)) $pagestr=$pagestr." [<a href=".$PATH_INFO."?&page=".($page+1)."&delete=yes>$lang[next_page]</a>]";


?>
<table width="100%" cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=8><?php echo $lang['gbook_man']?></th>
  </tr>
  <tr align=center>
    <td width="8%" class="tablerowhighlight"><?php echo $lang['focus']?></td>
    <td width="5%" class="tablerowhighlight">ID</td>
    <td width="10%" class="tablerowhighlight"><?php echo $lang['name']?></td>
    <td width="20%" class="tablerowhighlight"><?php echo $lang['gbook_theme']?></td>
    <td width="17%" class="tablerowhighlight"><?php echo $lang['gbook_time']?></td>
    <td width="10%" class="tablerowhighlight"><?php echo $lang['already_auditing']?></td>
    <td width="10%" class="tablerowhighlight"><?php echo $lang['already_revert']?></td>
    <td width="22%" class="tablerowhighlight"><?php echo $lang['man_op']?></td>
  </tr>
  <?php
              for ($i=$start; $i<$end; $i++) {
              $news_show[$i][id]=mysql_result($result,$i,"gb_id");
              $news_show[$i][title]=mysql_result($result,$i,"gb_title");
	          $news_show[$i][author]=mysql_result($result,$i,"gb_name");
			  $news_show[$i][email]=mysql_result($result,$i,"gb_email");
			  $news_show[$i][gb_date]=mysql_result($result,$i,"gb_date");
              $news_show[$i][pass]=mysql_result($result,$i,"gb_pass");
              $news_show[$i][ans]=mysql_result($result,$i,"gb_ans");
              $news_show[$i][ip]=mysql_result($result,$i,"gb_ip");
			  ?>
  <tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
    <td><input type="checkbox" name="gid[]"  id="gid[]" value="<?php echo $i?>"></td>
    <td><?php echo $news_show[$i][id]?></td>
    <td><?php echo $news_show[$i][author]?></td>
    <td ><a href='?action=reply&id=<?php echo $news_show[$i][id]?>&commit=yes'><?php echo $news_show[$i][title]?></a></td>
    <td><?php echo substr($news_show[$i][gb_date],0,10)?></td>
    <td>
<?php echo ($news_show[$i][pass])? "√" :  "<font color=red>×</font>";?>
</td>
    <td>
<?php echo ($news_show[$i][ans])? "√" : "<font color=red>×</font>";?>
</td>
    <td><a href="sendmail.php?sendto=<?php echo $news_show[$i][email]?>&replytitle=<?php echo $news_show[$i][title]?>"><?php echo $lang['revert']?></a> | 
<a href="?action=pass&id=<?php echo $news_show[$i][id]?>&commit=yes"><?php echo  ($news_show[$i][pass])?$lang['cancel']:$lang['authorize'];?></a>
 | <a href="?action=delete&id=<?php echo $news_show[$i][id]?>&commit=yes"><?php echo $lang['delete']?></a></td>
  </tr>

 <?php }?>
<tr><td colspan="8" class="tablerowhighlight" ><?php echo $pagestr?></td></tr>
</table>

</body>
</html>
<?php } ?>
