<?php
require('session.inc');
require('news.php');
switch($glo_language)
{
case zh_cn:
  require_once('languages/lang_zh_cn.php');
case eng:
  require_once('languages/lang_eng.php');
}
if(empty($_SESSION['log']) || $_SESSION['log']!=true) 
{echo "<script>window.location.replace('error.htm')</script>";
die("<?php echo $lang['unlogged']?>");}

?>
<style>



/***************forms***************************/
input {
	font-size: 12px;
	border: 1px solid #CCCCCC;
	background-color: #F9F9F9;
	vertical-align: middle;
	height : 20px;
	color: #666666;
}
textarea {
	font-size: 12px;
	border: 1px solid #CCCCCC;
	background-color: #F9F9F9;
	vertical-align: middle;
	color: #666666;
}
select {
	font-size: 12px;
	height: 20px;
	background-color: #F9F9F9;
	vertical-align: middle;
}
.radio { border: none; } /* 单选框样式定义 */
.button { font-size: 12px; height: 22px; } /* 按钮样式定义 */

/******************************************new**************************************************/

</style>
<script>
function doCheck(){
// 检测表单的有效性
// 如：标题不能为空，内容不能为空，等等....
if (myform.lusername.value=="") {
alert("请输入姓名!");
return false;
}

if (myform.content.value=="") {
alert("请输入评论内容!");
return false;
}

if (myform.email.value=="") {
alert("请输入邮箱地址!");
return false;
}
else if(myform.email.value.indexOf("@")==-1||(myform.email.value.indexOf("@")+1)==myform.email.value.length)
{ 
alert("请输入正确的邮箱地址");
return false;
}

return true;
}
</script>
<?php 
require('news.php');
$id=$_GET['id'];
if(!$cmtpage) $cmtpage=0;
$pagenum=$cmtpage*5;
$sql="select * from $T_CMT where cmt_newsid=$id order by cmt_date desc limit $pagenum,5";
$result=mysql_query($sql)or die( mysql_error());
$totalnum=$total=mysql_num_rows($result);
?>
<STYLE type=text/css>A {
	TEXT-DECORATION: none
}
A:hover {
	COLOR: #cc0000
}
A:link {
	COLOR: #000000
}
A:visited {
	COLOR: #000000
}
BODY {
	FONT-SIZE: 9pt; BACKGROUND-IMAGE: url(third.files/tdbg.gif); FONT-FAMILY: "宋体"; TEXT-DECORATION: none
}
TD {
	FONT-SIZE: 9pt; LINE-HEIGHT: 150%; FONT-FAMILY: 宋体
}
INPUT {
	BORDER-RIGHT: #bfbfbf 1px solid; BORDER-TOP: #bfbfbf 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: #bfbfbf 1px solid; COLOR: #000000; BORDER-BOTTOM: #bfbfbf 1px solid; HEIGHT: 18px; BACKGROUND-COLOR: #f6f6f6
}
BUTTON {
	FONT-SIZE: 9pt; HEIGHT: 20px
}
SELECT {
	FONT-SIZE: 9pt; HEIGHT: 20px
}
.border {
	BORDER-RIGHT: #bfbfbf 1px solid; BORDER-TOP: #bfbfbf 1px solid; BORDER-LEFT: #bfbfbf 1px solid; BORDER-BOTTOM: #bfbfbf 1px solid
}
.border2 {
	BACKGROUND: #ffffff; BORDER-BOTTOM: #bfbfbf 1px solid
}
.title_txt {
	BACKGROUND: #dfe8df
}
.title {
	BACKGROUND: #f0f0f0
}
.tdbg {
	BACKGROUND: #ffffff
}
.txt_css {
	BACKGROUND: url(Skin/4/txt_css.gif); HEIGHT: 36px
}
.title_lefttxt {
	
}
.title_left {
	BACKGROUND: url(Skin/4/title_left.gif); HEIGHT: 34px
}
.tdbg_left {
	BACKGROUND: url(SKIN/4/tdbg_left.gif)
}
.title_left2 {
	BACKGROUND: url(SKIN/4/tdbg_left2.gif); HEIGHT: 26px
}
.tdbg_left2 {
	BACKGROUND: url(SKIN/4/bg_1.gif)
}
.tdbg_leftall {
	BACKGROUND: #f7f7f7
}
.title_maintxt {
	FILTER: DropShadow(Color=#ffffff, OffX=1, OffY=1, Positive=1)
}
.title_main {
	BACKGROUND: url(Skin/4/title_main.gif); HEIGHT: 27px
}
.tdbg_main {
	BACKGROUND: url(Skin/4/tdbg_main2.GIF); LINE-HEIGHT: 100%
}
.title_main2 {
	BACKGROUND: url(Skin/4/maintop.gif); HEIGHT: 202px
}
.tdbg_main2 {
	BACKGROUND: url(Skin/4/tdbg_main3.GIF); HEIGHT: 27px
}
.tdbg_mainall {
	BACKGROUND: url(Skin/4/kt01-p1.GIF); HEIGHT: 27px
}
.title_righttxt {
	FILTER: Glow(Color=#ffffff, Strength=5)
}
.title_right {
	BACKGROUND: url(Skin/4/title_right.gif); FILTER: glow(color=#ffffff,strength=3); COLOR: #333333; HEIGHT: 20px
}
.tdbg_right {
	BACKGROUND: url(SKIN/4/bg_1.gif)
}
.title_right2 {
	BACKGROUND: url(Skin/4/title_main.gif); HEIGHT: 27px
}
.tdbg_right2 {
	BACKGROUND: url(Skin/4/title_main.gif); HEIGHT: 27px
}
.tdbg_rightall {
	BORDER-RIGHT: #b0b8b0 1px solid; BORDER-TOP: #b0b8b0 1px solid; BACKGROUND: #f6f6f6; BORDER-LEFT: #b0b8b0 1px solid
}
.topborder {
	BACKGROUND-IMAGE: url(Skin/4/topborder.gif)
}
.nav_top {
	BACKGROUND-IMAGE: url(Skin/4/nav_top.gif); HEIGHT: 25px
}
.nav_main {
	BACKGROUND: url(Skin/4/nav_main.gif); LINE-HEIGHT: 150%; HEIGHT: 134px
}
.nav_bottom {
	BACKGROUND-IMAGE: url(Skin/4/nav_bottom.gif)
}
.nav_menu {
	BACKGROUND-IMAGE: url(Skin/4/nav_menu.gif); HEIGHT: 24px
}
.menu {
	BORDER-RIGHT: 1px; BORDER-TOP: 1px; BORDER-LEFT: 1px; WIDTH: 97%; BORDER-BOTTOM: 1px; BACKGROUND-COLOR: #eeeeee
}
TD.MenuBody {
	BACKGROUND-COLOR: #f6f6f6
}
</STYLE>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" bgcolor="#f5f5f5">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="3%" ><img src="source/book.gif" width="26" height="20"></td>
 <td width="17%" ><span class="color_red"><?php echo $lang['relative_cmt']?></span></td>
 <td width="60%" ></td>
                <td width="20%" >&nbsp;</td>
              </tr>
            </table>
</td>
          </tr>
         
 
        </table>
</td>
      </tr>

      <tr>
        <td valign="top">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td><table width="95%"  border="0" cellpadding="0" cellspacing="0" align="center">
 <?php while($total>0&&$rows=mysql_fetch_array($result,MYSQL_BOTH))
 {
 ?>
<tr>
<td height="30" style="padding-left:5px">
<span style="color:red;"><img src="source/dot.gif" border="0"><?php echo $lang['commenter']?>: </span>
[ <a href="#" title="<?php echo $lang['sex']?><?php echo($rows['cmt_sex']?<?php echo $lang['male']?>:<?php echo $lang['female']?>);?>E-mail <?php echo $rows['cmt_email'];?> QQ<?php echo
$rows['cmt_qq'];?>  MSN<?php echo $rows['cmt_msn'];?> <?php echo $lang['homepage']?><?php echo $rows['cmt_homepage'];?> "><span style="color: blue;"><?php echo $rows['cmt_name'];?>
</span></a> ]　　<?php echo $lang['release_time']?>: <span style="color:blue;"><?php echo $rows['cmt_date'];?> </span>　　<?php echo $lang['mark']?>: <span style="color:red;"><?php echo $rows['cmt_mark'];?></span></td>
              </tr>
              <tr>
                <td style="BORDER-RIGHT: #c0c0c0 1px dotted;
				BORDER-TOP: #c0c0c0 1px dotted;
				BORDER-LEFT: #c0c0c0 1px dotted;
				BORDER-BOTTOM: #c0c0c0 1px dotted;
				padding-left:5px;
				padding-right:5px;
				padding-top:5px;
				padding-bottom:5px;"><?php echo $rows['cmt_content'];?></td>
              </tr>
			  <?php $total--;} ?>
             

 <tr>
<td height="30" align="right">
 <?php if($cmtpage-1>=0){  ?> <a href="?id=<?php echo $id?>&cmtpage=<?php echo $cmtpage-1?>"><?php echo $lang['previous_page']?></a> <?php } ?>&nbsp;&nbsp;<?php if (($cmtpage+1)*5<$totalnum) { ?><a href="?id=<?php echo $id?>&cmtpage=<?php echo $cmtpage+1?>"><?php echo $lang['next_page']?></a><?php } ?></td>
</tr>
            </table></td>
          </tr>

          <tr><!-------------------发表评论--------------------------------->
            <td>
<a name="comment">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td  valign="middle"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#f5f5f5" height="25"  width="3%"><img  src="source/book.gif" width="26" height="20"></td>
<td bgcolor="#f5f5f5" height="25"  width="97%"><span class="color_red"><?php echo $lang['release_cmt']?></span></td>
        </tr>
    </table>
</td>
  </tr>
  <tr>
    <td valign="top" style="padding-top:10px">
<!-------------------form--------------------------------->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" align="center"><table width="456"  border="0" cellspacing="0" cellpadding="0">
          <form name="myform" method="post" action="news_add.php?type=comment&action=add&articleid=<?php echo $id;?>" onSubmit="return doCheck();">
            <tr>
              <td width="65" height="25" align="right"><?php echo $lang['name']?> &nbsp;</td>
              <td width="160" align="left"><input name="lusername" type="text" id="lusername" size="25" maxlength="30"></td>
              <td width="45" align="right">QQ &nbsp;</td>
              <td width="186"><input name="qq" type="text" id="qq" size="25" maxlength="20"></td>
            </tr>
            <tr>
              <td height="25" align="right"><?php echo $lang['sex']?> &nbsp;</td>
              <td align="left"><input name="gender" type="radio" class="radio" value="1" checked>
        <?php echo $lang['male']?>
          <input name="gender" type="radio" class="radio" value="0">
        <?php echo $lang['female']?></td>
              <td align="right">MSN &nbsp;</td>
              <td><input name="msn" type="text" id="msn" size="25" maxlength="50"></td>
            </tr>
            <tr>
              <td height="25" align="right">E-mail &nbsp;</td>
              <td align="left"><input name="email" type="text" id="email" size="25"></td>
              <td align="right"><?php echo $lang['homepage']?> &nbsp;</td>
              <td><input name="homepage" type="text" id="homepage" size="25" maxlength="255"></td>
            </tr>
            <tr>
              <td height="25" align="right"><?php echo $lang['mark']?> &nbsp;</td>
              <td colspan="3" align="left"><input name="score" type="radio" class="radio" value="1">
        1
          <input name="score" type="radio" class="radio" value="2">
        2
        <input name="score" type="radio" class="radio" value="3" checked>
        3
        <input name="score" type="radio" class="radio" value="4">
        4
        <input name="score" type="radio" class="radio" value="5">
        5</td>
            </tr>
            <tr>
              <td align="right"><?php echo $lang['content']?> &nbsp;</td>
              <td colspan="3" align="left"><textarea name="content" cols="60" rows="8" id="content"></textarea></td>
            </tr>
            <tr>
             
            </tr>
            <tr>
              <td height="35"> </td>
              <td colspan="3" align="left"><input name="submit" type="submit" class="button" value=" <?php echo $lang['submit']?> ">
&nbsp;&nbsp;
        <input name="reset" type="reset" class="button" value=" <?php echo $lang['clear']?> "></td>
            </tr>
          </form>
        </table></td>
        <td width="40%" valign="top" style="padding-top:10px"><LI><?php echo $lang['rules']?><FONT color=red><?php echo $lang['rules_name']?></FONT><?php echo $lang['rules_1']?>。<BR><LI><?php echo $lang['rules_2']?>。<BR><LI><?php echo $lang['rules_3']?>。<BR><LI><?php echo $lang['rules_4']?>。<BR><LI><?php echo $lang['rules_5']?>。</LI></td>
      </tr>
    </table></td>
  </tr>
</table>

          </td>
          </tr>

        </table></td>
      </tr>

    </table>
    </td>
  </tr>
</table>
