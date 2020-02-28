<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>留言本</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="gbook/style.css" type=text/css rel=stylesheet>
</HEAD>
<STYLE>
TD {
	FONT-SIZE: 12px; COLOR: #FFFFFF; LINE-HEIGHT: 150%
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none
}
A:link {
	COLOR: #000000; TEXT-DECORATION: none
}
A:hover {
	COLOR: #ff0000; TEXT-DECORATION: none
}
TEXTAREA {
	BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid; BACKGROUND-COLOR: #efefef
}
SELECT {
	FONT-SIZE: 9pt
}
.TableLine {
	BORDER-COLLAPSE: collapse
}
</STYLE>
<BODY bgcolor="#303880" leftMargin=0  topMargin=0 >

<TABLE width="783" border=0 align="center" cellPadding=0 cellSpacing=0>
  <TBODY>
    <TR>
      <TD background="../sources/head-main.jpg" align="center" ><img src="../sources/BANNER.jpg" width="755" height="70"></TD>
    </TR>
    <TR>
      <TD height=30 align="right" bgColor=#303880>
        <DIV align=left>
          <TABLE cellSpacing=0 cellPadding=0 width=100% align=center border=0>
            <TBODY>
              <TR>
                <TD align="right" class="announce">
                <DIV align=center><TABLE width=762 border=0 align=center cellPadding=0 cellSpacing=0 >
        <TBODY>
        <TR>
          <TD>
     
        <SCRIPT language=javascript src="../sources/menu_gb.js"></SCRIPT></TD></TR></TBODY></TABLE></DIV></TD>
              </TR>
            </TBODY>
          </TABLE>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>

<A name=top>
<?php if($action==add)
{
?>
<SCRIPT language=javaScript src="gbook/ubb/postcode.js" 
type=text/javascript></SCRIPT>

<SCRIPT language=JavaScript type=text/javascript>
function storeCaret(textEl) {if(textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();}
function HighlightAll(theField) {
var tempval=eval('document.'+theField)
tempval.focus()
tempval.select()
therange=tempval.createTextRange()
therange.execCommand('Copy')
}
function DoTitle(addTitle) {
var revisedTitle;var currentTitle = document.myform.intopictitle.value;revisedTitle = addTitle+currentTitle;document.myform.intopictitle.value=revisedTitle;document.myform.intopictitle.focus();
return;
}
function checklength(theform){alert('您的留言内容目前有'+theform.content.value.length+'字节');}
function enable(btn){btn.filters.gray.enabled=0;}
function disable(btn){btn.filters.gray.enabled=1;}
function showimage()
{document.images.tus.src='gbook/face/'+document.myform.headportrait.options[document.myform.headportrait.selectedIndex].value+'.gif';}
</SCRIPT>

<SCRIPT language=JavaScript>
function changeimage()
{
  document.myform.headimg.value=document.myform.Image.value;
  document.myform.showimages.src='gbook/face/'+document.myform.Image.value+'.gif';
}
function CheckForm()
{
    if(document.myform.name.value==''){
      alert('姓名不能为空！');
      document.myform.name.focus();
      return(false) ;
    }
  if(document.myform.name.value.length>30){
    alert('!nametoolang!');
    document.myform.name.focus();
    return(false);
  }
  if(document.myform.title.value==''){
    alert('主题不能为空！');
    document.myform.title.focus();
    return(false);
  }
  if(document.myform.title.value.length>100){
    alert('主题不能超过30字符！');
    document.myform.title.focus();
    return(false);
  }
  if(document.myform.content.value==''){
    alert('内容不能为空！');
    document.myform.content.focus();
    return(false);
  }
  if(document.myform.content.value.length>65536){
    alert('内容不能超过64K！');
    document.myform.content.focus();
    return(false);
  }
  if(document.myform.checkcode.value==''){
    alert('请输入您的验证码！');
    document.myform.checkcode.focus();
    return(false);
  }
}
</SCRIPT>

<TABLE class=line2 cellSpacing=0 cellPadding=0 width=783 align=center 
  border=0><TBODY>
  <TR>
    <TD height=30>&nbsp;&nbsp;<A 
      href="?action=add"><IMG 
      height=24 src="gbook/home.gif" width=76 
      border=0></A>&nbsp;&nbsp;&nbsp;&nbsp;<A 
      href="gbook.php"><IMG height=24 
      src="gbook/add.gif" width=76 border=0></A></TD></TR>
  <TR>
    <TD class=bg_main height=1></TD></TR></TBODY></TABLE>
<TABLE class=line2 cellSpacing=0 cellPadding=2 width=783 align=center 
  border=0><FORM name=myform onSubmit="return CheckForm()" action="gbook_man.php?action=add&commit=yes" 
  method=post>
  <TBODY>
  <TR>
    <TD align=right width="14%" height=25><FONT color=red>*</FONT> <font color="#000000">姓名：</font></TD>
    <TD colspan="2"><input id=name size=25 name=name></TD>
  </TR>
  <TR>
    <TD align=right height=25><font color="#000000">性别：</font></TD>
    <TD colspan="2"><input 
      style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 0px" 
      type=radio checked value=1 name=gender> 
     <font color="#000000"> 男 </font>
      <INPUT 
      style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 0px" 
      type=radio value=0 name=gender><font color="#000000"> 女</font></TD></TR>
  <TR>
    <TD align=right height=25><font color="#000000">E-mail：</font></TD>
    <TD colspan="2"><INPUT id=email size=25 name=email></TD></TR>
  <TR>
    <TD align=right height=25><font color="#000000">QQ：</font></TD>
    <TD colspan="2"><INPUT id=qq size=25 name=qq> </TD></TR>
  <TR>
    <TD align=right height=25><font color="#000000">Msn：</font></TD>
    <TD colspan="2"><INPUT id=msn size=25 name=msn></TD></TR>
  <TR>
    <TD align=right height=25><font color="#000000">电话：</font></TD>
    <TD colspan="2"><INPUT id=telephone size=25 name=telephone></TD></TR>
  <TR>
    <TD align=right height=25><font color="#000000">地址：</font></TD>
    <TD colspan="2"><INPUT id=address size=25 name=address></TD></TR>
  <TR>
    <TD align=right height=25><font color="#000000">主页：</font></TD>
    <TD colspan="2"><INPUT id=homepage size=25 name=homepage></TD></TR>
  <TR>
    <TD align=right height=25><FONT color=red>*</FONT><font color="#000000">留言主题：</font></TD>
    <TD colspan="2"><INPUT id=title size=50 name=title></TD></TR>
  <TR>
    <TD align=right height=25>『<A 
      href="javascript:checklength(document.myform);">查看长度</A>』<BR>『<A 
      href="javascript:HighlightAll('myform.content')">复制文本</A>』<BR>『<A 
      href="javascript:replac()">替换文本</A>』 </TD>
    <TD colspan="2">&nbsp; <SELECT 
      onchange=showfont(this.options[this.selectedIndex].value) size=1 
        name=font> <OPTION value=no selected>字体</OPTION><OPTION 
        value=宋体>宋体</OPTION><OPTION value=楷体_GB2312>楷体</OPTION><OPTION 
        value=新宋体>新宋体</OPTION><OPTION value=黑体>黑体</OPTION><OPTION 
        value=隶书>隶书</OPTION> <OPTION value=Arial>Arial</OPTION> <OPTION 
        value=Impact>Impact</OPTION> <OPTION value=Tahoma>Tahoma</OPTION> 
        <OPTION value="Times New Roman">Times New Roman</OPTION> <OPTION 
        value=else>其他</OPTION></SELECT>
      <select 
      onChange=showsize(this.options[this.selectedIndex].value) size=1 
        name=size>
        <option selected>字号</option>
        <option value=9>9</option>
        <option value=10>10</option>
        <option value=11>11</option>
        <option 
        value=12>12</option>
        <option value=18>18</option>
        <option 
        value=36>36</option>
        <option value=72>72</option>
        <option 
        value=else>其他</option>
      </select>
      <SELECT 
      onchange=showcolor(this.options[this.selectedIndex].value) size=1 
      name=color> <OPTION value=no selected>颜色</OPTION> <OPTION 
        style="COLOR: #000000; BACKGROUND-COLOR: #000000" 
        value=#000000>#000000</OPTION> <OPTION 
        style="COLOR: #ffffff; BACKGROUND-COLOR: #ffffff" 
        value=#FFFFFF>#FFFFFF</OPTION> <OPTION 
        style="COLOR: #ff0000; BACKGROUND-COLOR: #ff0000" 
        value=#FF0000>#FF0000</OPTION> <OPTION 
        style="COLOR: #00ff00; BACKGROUND-COLOR: #00ff00" 
        value=#00FF00>#00FF00</OPTION> <OPTION 
        style="COLOR: #0000ff; BACKGROUND-COLOR: #0000ff" 
        value=#0000FF>#0000FF</OPTION> <OPTION 
        style="COLOR: #00ffff; BACKGROUND-COLOR: #00ffff" 
        value=#00FFFF>#00FFFF</OPTION> <OPTION 
        style="COLOR: #ffebcd; BACKGROUND-COLOR: #ffebcd" 
        value=#FFEBCD>#FFEBCD</OPTION> <OPTION 
        style="COLOR: #5f9ea0; BACKGROUND-COLOR: #5f9ea0" 
        value=#5F9EA0>#5F9EA0</OPTION> <OPTION 
        style="COLOR: #6495ed; BACKGROUND-COLOR: #6495ed" 
        value=#6495ED>#6495ED</OPTION> <OPTION>其他</OPTION></SELECT> <BR>&nbsp; 
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
      height=22 alt=阴影字 src="gbook/ubb/shadow.gif" width=23> </TD></TR>
  <TR>
    <TD align=middle><FONT color=red>*</FONT> 留言内容：<BR><BR><INPUT type=hidden 
      value=01 name=headimg> <IMG title=点击选择头像 
      height=90 src="gbook/face/01.gif" width=80 border=0 
      name=showimages><BR><BR><SELECT onchange=changeimage(); size=1 name=Image> 
        <OPTION value=01 selected>01</OPTION> <OPTION value=02>02</OPTION> 
        <OPTION value=03>03</OPTION> <OPTION value=04>04</OPTION> <OPTION 
        value=05>05</OPTION> <OPTION value=06>06</OPTION> <OPTION 
        value=07>07</OPTION> <OPTION value=08>08</OPTION> <OPTION 
        value=09>09</OPTION> <OPTION value=10>10</OPTION> <OPTION 
        value=11>11</OPTION> <OPTION value=12>12</OPTION> <OPTION 
        value=13>13</OPTION> <OPTION value=14>14</OPTION> <OPTION 
        value=15>15</OPTION> <OPTION value=16>16</OPTION> <OPTION 
        value=17>17</OPTION> <OPTION value=18>18</OPTION> <OPTION 
        value=19>19</OPTION> <OPTION value=20>20</OPTION> <OPTION 
        value=21>21</OPTION> <OPTION value=22>22</OPTION> <OPTION 
        value=23>23</OPTION></SELECT></TD>
    <TD colspan="2"><TEXTAREA id=content name=content rows=12 cols=50></TEXTAREA> </TD></TR>
  <TR>
    <TD align=right height=25><FONT color=red>*</FONT> 验证码：</TD>
    <TD width="5%"   height="20" valign="bottom" ><INPUT id=checkcode size=5 name=checkcode  maxlength="4"></TD>
    <TD width="81%" valign="bottom" ><img src="auth.php" height="20" ></TD>
  </TR>
  <TR>
    <TD align=right height=25>&nbsp;</TD>
    <TD colspan="2"><INPUT type=submit value=" 确定 " name=submit> <INPUT type=reset value=" 重置 " name=submit></TD></TR></FORM></TBODY></TABLE>
<?php }

else { ?>

<?php require('news.php');
    if(!$page) $page=1;
	$pagestart=($page-1)*10; 
	$sqlnum="select count(*) as gb_total from $T_GBOOK where gb_reply=0 and gb_pass=1";
	$sql="select * from $T_GBOOK where gb_reply=0 and gb_pass=1 order by gb_date desc limit $pagestart,10";
	$resultnum=mysql_query($sqlnum) or die (mysql_error());
	$result=mysql_query($sql) or die (mysql_error());
	$totalnews=mysql_result($resultnum,0,'gb_total');
	$totalpage=(int)($totalnews/10);
    if($totalpage>0 && $totalnews%10!=0) $totalpage++;
	?>
<table width="783"  border="0" cellspacing="0" cellpadding="0" align="center" class=line2>
  <tr>
    <td height="30">&nbsp;&nbsp;<a href="?action=add"><img src="gbook/home.gif" width="76" height="24" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="gbook.php"><img src="gbook/add.gif" width="76" height="24" border="0"></a></td>
  </tr>
</table>
<?php 
$i=$pagestart+1;
while($rows=mysql_fetch_array($result,MYSQL_BOTH))
{
?>
<table width="783"  border="0" cellspacing="0" cellpadding="0" align="center" class=line2>
      <tr>
        <td class="bg_main" height="20" width="90%">&nbsp;&nbsp;<b>留言主题 :  </b><?php=$rows['gb_title']?> ---- <?php=$rows['gb_date']?></td>
<td class="bg_main" height="20" width="10%" align=right>No:<?php=$i?>;</td>
</tr>
</table>
 <table width="783"  border="0" cellspacing="0" cellpadding="0" align="center" class=line2>
  <tr>
    <td width="160" class=line1 valign=top>
      <table width="98%"  border="0" cellspacing="3" cellpadding="3" align="center">
   <tr>
<td align=center><img src="gbook/face/<?php=$rows['gb_face']?>" width="80" height="90"></td>
   <tr>
     <td align=center><b><font color="#000000"><?php=$rows['gb_name']?></font></b></td>
   </tr>
   <tr>
     <td height=25>
        
<?php if($rows['gb_homepage']!="") { ?><a href="<?php=$rows['gb_homepage']?>" target="_blank"><img src="gbook/url.gif" width="45" height="16" border="0" alt="Homepage:<?php=$rows['gb_homepage']?>"></a><?php } 
else {
?><img src="gbook/nourl.gif" width="45" height="16" border="0" alt="Homepage"><?php } ?>
<?php if($rows['gb_email']!="") { ?>
<a href="mailto:<?php=$rows['gb_email']?>" target="_blank"><img src="gbook/email.gif" width="45" height="16" border="0" alt="Email:<?php=$rows['gb_email']?>"></a><?php } 
else
{
?><img src="gbook/noemail.gif" width="45" height="16" border="0" alt="Email">
<?php } ?>
<?php if($rows['gb_qq']!="") { ?><a target=blank href=http://wpa.qq.com/msgrd?V=1&Uin=<?php=$rows['gb_qq']?>&Site=纵横天下&Menu=yes><img src="gbook/oicq.gif" width="45" height="16" border="0" alt="QQ:<?php=$rows['gb_qq']?>"></a>
<?php } 
else {
?><img src="gbook/nooicq.gif" width="45" height="16" border="0" alt="QQ">
<?php } ?>

        </td>
   </tr>
   </table>
</td>
    <td  valign="top">
 <table width="98%"  border="0" cellspacing="3" cellpadding="3" align="center">
 <tr>
 <td colspan="3"><font color="#000000"><?php=$rows['gb_content']?></font></td>
     </tr>

<?php if($rows['gb_ans'])
{
 $id=$rows['gb_id'];
 $sql_ans="select * from $T_GBOOK where gb_reply=$id";
 $result_ans=mysql_query($sql_ans);
 $rows_ans=mysql_fetch_array($result_ans,MYSQL_BOTH);   
?>
     <tr><td>&nbsp;&nbsp;</td>
     <td><font color=red><b>管理员[<?php=$rows_ans['gb_name']?>]于<?php=$rows_ans['gb_date']?>回复：</b></font></td>
 <td>&nbsp;&nbsp;</td></tr>
 <tr>
 <td >&nbsp;&nbsp;</td>
 <td class=pane ><font color="#000000"><?php=$rows_ans['gb_content']?></font></td>
  <td >&nbsp;&nbsp;</td></tr><?php }//if ?>
 </table>
</td>
  </tr>
 </table>
<?php $i++; }//while ?>
<table width="783"  border="0" cellspacing="0" cellpadding="0" align="center" class=line2>

</tr>
<tr><td class="bg_main" height="20" align="right" colspan="3"><?php if($page-1>=1){  ?> <a href="?page=<?php=$page-1?>">上一页</a> <?php } else echo "上一页";?>&nbsp;<?php for($i=1;$i<=$totalpage;$i++){ if($i!=$page) echo "&nbsp;[<a href=?page=".$i.">".$i."</a>]&nbsp;"; else echo "&nbsp;".$i."&nbsp;"; }?>&nbsp;<?php if ($page*10<$totalnews) { ?> <a href="?page=<?php=$page+1?>">下一页</a><?php } else echo "下一页"; ?></td>
</tr>
</table>
<?php } ?>
<TABLE cellSpacing=0 cellPadding=0 width=783 align=center 
background="../sources/ng_index_foot_2.gif" border=0>
  <TBODY>
    <TR>
      <TD vAlign=center align=middle height=56>
        <DIV align=center><font color="#000000">地址：北京市海淀区坡上村12号 电话：010－62877037 邮编：100091 <IMG 
      height=9 src="../sources/hit_index_mail.gif" width=14> web@uir.edu.cn<BR>
        Copyright(2006) 国际关系学院招生办<br>
      教育技术中心网络文化办公室制作 程序设计：惠新宸 页面设计：王明坤</font> </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE cellSpacing=0 cellPadding=0 align=center border=0>
  <TBODY>
  <TR>
    <TD height=18>
<DIV align=center><IMG height=18 
      src="../sources/ng_index_foot_4.gif" 
  width=783></DIV></TD></TR></TBODY></TABLE></BODY></HTML>
