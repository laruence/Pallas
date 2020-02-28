<?php 
require_once('config.php');
require_once('pscms_admin/includes/Class_html.php');
require_once('Functions.php');
$dstFile = getDstFilePath();
$rows = fetchOneNewsObject();
getCategoryName($catname,$specname);
$html=new PtH($dstFile,false);
$html->Start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><title><?=$rows -> news_title?>-<?=$glo_web_name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta content="all" name="robots" />
<meta name="author" content="laruence@yahoo.com.cn,Laruence" />
<meta name="Copyright" content="国际关系学院外办" />
<meta name="keywords" content="<?=$glo_web_descript?>">
<meta name="description" content="<?=$glo_web_descript?>">

<LINK href="/<?=$glo_web_path?$glo_web_path:""?>source.files/zju.css" type=text/css rel=stylesheet>
<STYLE>TD {
	FONT-SIZE: 9pt; COLOR: #575757; LINE-HEIGHT: 20px; FONT-FAMILY: "Arial", "宋体"
}
</STYLE>

<META content="MSHTML 6.00.2900.3059" name=GENERATOR></HEAD>
<BODY bottomMargin=0 background=/<?=$glo_web_path?$glo_web_path:""?>source.files/bg.gif topMargin=0>
<DIV align=center>
<TABLE cellSpacing=0 cellPadding=0 border=0>
  <TBODY>
  <TR>
    <TD vAlign=top align=right width=777 background=/<?=$glo_web_path?$glo_web_path:""?>source.files/news_1.jpg 
    height=113><A href="http://bbs.uir.cn/waiban">首页</A> | <A 
      href="javascript:window.external.AddFavorite('http://bbs.uir.cn/waiban','国际关系学院外事办')">加入收藏</A> 
      | 搜索 
      <FORM 
      style="BORDER-RIGHT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: 0px; DISPLAY: inline; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; BORDER-LEFT: 0px; PADDING-TOP: 0px; BORDER-BOTTOM: 0px" 
      action=http://www.google.com/custom method=get target=_blank><INPUT 
      style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; LEFT: 0px; BORDER-LEFT: 1px solid; WIDTH: 90px; BORDER-BOTTOM: 1px solid; TOP: 0px; HEIGHT: 15px" 
      maxLength=200 size=15 name=q> <INPUT type=hidden value=zh-CN name=hl> 
      <INPUT type=hidden value=GB2312 name=ie> <INPUT type=hidden value=GB2312 
      name=oe> &nbsp; <INPUT type=image alt=站内搜索 src="/<?=$glo_web_path?$glo_web_path:""?>source.files/search_2.gif" 
      align=absMiddle value="Google Search" border=0 name=sa> <INPUT type=hidden 
      value=AH:left; name=cof> <!--这里需要你做一些设置，让结果看起来漂亮一些--><INPUT type=hidden 
      value=zju.edu.cn name=domains> <INPUT type=hidden value=zju.edu.cn 
      name=sitesearch> </FORM>&nbsp;</TD></TR>
  <TR>
    <TD vAlign=top width=777 background=/<?=$glo_web_path?$glo_web_path:""?>source.files/news_2.png height=24>
      <TABLE width=775 height="29" border=0 cellPadding=0 cellSpacing=0>
        <TBODY>
        <TR>
          <TD width=34></TD>
          <TD vAlign=top width=741><FONT color=#ffffff><STRONG>&gt; 
            &gt;</STRONG>&nbsp;&nbsp;<A href="http://bbs.uir.cn/waiban"><FONT 
            color=#ffffff><STRONG>国际关系学院外事办</STRONG></FONT></A>&nbsp;<STRONG>&gt;</STRONG>&nbsp;<STRONG><?=$catname?></STRONG>&nbsp;<STRONG>&gt;</STRONG>&nbsp;<STRONG><?=$rows -> news_title?></STRONG></FONT></TD>
        </TR></TBODY></TABLE></TD>
  </TR>
  <TR>
    <TD align=middle width=777 background=/<?=$glo_web_path?$glo_web_path:""?>source.files/bg_sub1.gif height=400>
      <TABLE width="85%">
        <TBODY>
        <TR>
          <TD vAlign=top height=400>
            <TABLE width="100%" align=center>
              <TBODY>
              <TR>
                <TD height=20></TD></TR>
              <TR>
                <TD class=main_title align=middle><?=$rows -> news_title?></TD></TR>
              <TR>
                <TD align=middle>
                  <HR width=400>
                </TD></TR>
              <TR>
                <TD>
				  <?
	   $news_text=$rows->news_text;
	   $news_text=explode("[*next*]",$news_text);
	   if(count($news_text)==1)
	   {
        $needpage=false;
	    echo $news_text[0];
	   }
	   else
	   {
	   $needpage=true;
	   $total_page=count($news_text);
	   if($page==NULL) $page=1;
	   echo $news_text[$page-1];
	   }
	   ?>
				
				</TD></TR>
              <TR>
                <TD height=20> <? if($page-1>0)
{  ?>
              <a href="/<?=$glo_web_path?$glo_web_path:""?>category/<?=$cat?><?=$spec?"/".$spec:""?>/<?=$rows -> news_id?>-<?=$page-1?>.html" class="STYLE19">上一页</a>
              <? }
?>
          &nbsp;
          <?
for($i=1;$i<=$total_page;$i++)
{ 
if($i!=$page) 
{?>

&nbsp;[<a href="/<?=$glo_web_path?$glo_web_path:""?>category/<?=$cat?><?=$spec?"/".$spec:""?>/<?=$rows -> news_id?>-<?=$i?>.html" class='style19'><?=$i?></a>]&nbsp;
 <? } 
 else 
 {
 ?>
&nbsp;<?=$i?>&nbsp;
 <? }
 
 }?>
          &nbsp;
          <? if ($page<$total_page) { ?>
              <a href="/<?=$glo_web_path?$glo_web_path:""?>category/<?=$cat?><?=$spec?"/".$spec:""?>/<?=$rows -> news_id?>-<?=$page+1?>.html" class="STYLE19">下一页</a>
          <? }?></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD vAlign=top align=middle>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR>
                <TD>
                  <HR width=500>
                </TD></TR>
              <TR>
                <TD align=middle>意见建议 | 教育科研网 | 合作单位</TD></TR>
              <TR>
                <TD 
                  align=middle>∷&nbsp;&nbsp;国际关系学院&nbsp;&nbsp;∷&nbsp;&nbsp;V2.0&nbsp;2004&nbsp;&nbsp;Copyright&nbsp;&nbsp;&copy;&nbsp;&nbsp;All 
                  Rights Reserved.</TD></TR>
              <TR>
                <TD align=middle>国际关系学院网络文化办公室维护 
         国际关系学院网络文化办公室维护 制作</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
<?php
$html->Build();
$html->End();
?>
