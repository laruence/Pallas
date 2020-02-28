<html>
<head>
<title>新闻列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<?php require("news.php") ;
if($_GET['type']==NULL)
{
$sql="select * from $T_NEWS order by news_date desc";
$result=mysql_query($sql);

$total= mysql_num_rows($result);

//temp
//$start=0;
//$end=$total;

if(!$page)$page =0;

$eachpage=15;
$start=$page*$eachpage;
$end=$start+$eachpage;
if($end>$total) $end =$total;
$totalpage =$total/$eachpage;

$pagestr="共有".$total."篇新闻 ";
if($page>0) $pagestr=$pagestr."[<a href=".$PATH_INFO."?page=".($page-1)."&delete=yes>上一页</a>] ";
$pagestr=$pagestr."[第 ";
for ($i=0;$i<$totalpage;$i++)
{
 if ($i!=$page) {$pagestr=$pagestr."<a href=".$PATH_INFO."?page=".$i."&delete=yes>".($i+1)."</a> ";}
 else {$pagestr=$pagestr.($i+1)." ";}
}
$pagestr=$pagestr."页]";

if ($page<($totalpage-1)) $pagestr=$pagestr." [<a href=".$PATH_INFO."?&page=".($page+1)."&delete=yes>下一页</a>]";

?>
<table cellpadding="2" cellspacing="1"  style="  border: 1px solid #183789; WIDTH: 100%; BACKGROUND-COLOR: #ffffff; ">
  <tr>
    <th colspan=7 class="STYLE1">新闻列表</th>
  </tr>
<tr align=center>
<td class="tablerowhighlight">选择</td>
<td class="tablerowhighlight">文章ID</td>
<td width="20%" class="tablerowhighlight">标题</td>
<td width="18%" class="tablerowhighlight">录入</td>
<td width="18%" class="tablerowhighlight">发表时间</td>
<td width="12%" class="tablerowhighlight">浏览次数</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
              for ($i=$start; $i<$end; $i++) {
              $news_show[$i][id]=mysql_result($result,$i,"news_id");
              $news_show[$i][news_title]=mysql_result($result,$i,"news_title");
			  $news_show[$i][news_cat]=mysql_result($result,$i,"news_cat");
              $news_show[$i][news_author]=mysql_result($result,$i,"news_author");
			  $news_show[$i][news_from]=mysql_result($result,$i,"news_from");
              $news_show[$i][news_spec]=mysql_result($result,$i,"news_spec");
			  $news_show[$i][news_date]=mysql_result($result,$i,"news_date");
              $news_show[$i][news_click]=mysql_result($result,$i,"news_click");
              $news_show[$i][news_text]=mysql_result($result,$i,"news_text");
              ?>
<tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox"></td>
<td><?php echo $news_show[$i][id]?></td>
<td ><?php echo "<a href=../show_news.php?id=".$news_show[$i][id]." target='_blank'>".$news_show[$i][news_title]."</a>" ?></td>
<td><?php echo $news_show[$i][news_author];?></td>
<td><?php echo substr($news_show[$i][news_date],0,10) ;?></td>
<td><?php echo $news_show[$i][news_click] ;?></td>
<td><?php echo "<a href=$REQUEST_URI&id=".$news_show[$i][id].">删除</a>"  ;
if($id==$news_show[$i][id])
{
	$sql="DELETE FROM $T_NEWS WHERE news_id=$id";
	$sql2="DELETE FROM $T_CMT WHERE id=$id";
    mysql_query($sql);
	mysql_query($sql2);
	?><script>alert("<?php=$news_show[$i][news_title]?>删除成功!");window.location.reload();</script><?php } }?>
</td>
</tr>

<tr  ><td colspan="7" class="tablerowhighlight"><?php echo $pagestr;?></td></tr>

</table> 
<?php
}
else
{

$sql="select $T_CMT.*,$T_NEWS.news_title from $T_CMT,$T_NEWS where $T_CMT.cmt_newsid=$T_NEWS.news_id order by cmt_date desc";
$result=mysql_query($sql) or die(mysql_error());
$total=mysql_num_rows($result);

//temp
//$start=0;
//$end=$total;

if(!$page)$page =0;

$eachpage=15;
$start=$page*$eachpage;
$end=$start+$eachpage;
if($end>$total) $end =$total;
$totalpage =$total/$eachpage;

$pagestr="共有".$total."篇新闻 ";
if($page>0) $pagestr=$pagestr."[<a href=".$PATH_INFO."?page=".($page-1)."&delete=yes&type=comment>上一页</a>] ";
$pagestr=$pagestr."[第 ";
for ($i=0;$i<$totalpage;$i++)
{
 if ($i!=$page) {$pagestr=$pagestr."<a href=".$PATH_INFO."?page=".$i."&delete=yes&type=comment>".($i+1)."</a> ";}
 else {$pagestr=$pagestr.($i+1)." ";}
}
$pagestr=$pagestr."页]";

if ($page<($totalpage-1)) $pagestr=$pagestr." [<a href=".$PATH_INFO."?&page=".($page+1)."&delete=yes&type=comment>下一页</a>]";

?>
<table cellpadding="2" cellspacing="1"  style="  border: 1px solid #183789; WIDTH: 100%; BACKGROUND-COLOR: #ffffff; ">
  <tr>
    <th colspan=8><span class="STYLE1">评论列表</span></th>
  </tr>
  <tr align=center>
     <td  width="5%"class="tablerowhighlight">选择</td>
    <td width="17%" class="tablerowhighlight">所属文章</td>
    <td width="8%" class="tablerowhighlight">发表者</td>
    <td width="10%" class="tablerowhighlight">发表时间</td>
    <td width="10%" class="tablerowhighlight">E_Mail</td>
    <td width="15%" class="tablerowhighlight">发表者IP</td>
	<td width="20%" class="tablerowhighlight">内容</td>
    <td width="15%" class="tablerowhighlight">管理操作</td>
  </tr>
  <?php
              for ($i=$start; $i<$end; $i++) {
              $cmt_show[$i][id]=mysql_result($result,$i,"cmt_newsid");
			  $cmt_show[$i][cmtid]=mysql_result($result,$i,"cmt_id");
              $cmt_show[$i][title]=mysql_result($result,$i,"news_title");
			  $cmt_show[$i][date]=mysql_result($result,$i,"cmt_date");
              $cmt_show[$i][name]=mysql_result($result,$i,"cmt_name");
			  $cmt_show[$i][content]=mysql_result($result,$i,"cmt_content");
              $cmt_show[$i][email]=mysql_result($result,$i,"cmt_email");
			  $cmt_show[$i][ip]=mysql_result($result,$i,"cmt_ip");
			  ?>
  <tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor='#F1F3F5'>
    <td><input type="checkbox"></td>
	<td><?php echo "<a href=../show_news.php?id=".$cmt_show[$i][id]." target='_blank'>".$cmt_show[$i][title]."</a>" ?></td>
    <td><?php echo $cmt_show[$i][name];?></td>
    <td><?php echo substr($cmt_show[$i][date],0,10) ;?></td>
    <td><?php echo $cmt_show[$i][email] ;?></td>
	<td><?php echo $cmt_show[$i][ip] ;?></td>
    <td><?php echo $cmt_show[$i][content] ;?></td>
	<td><?php echo "<a href=$REQUEST_URI&id=".$cmt_show[$i][cmtid].">删除</a>"  ;
if($id==$cmt_show[$i][cmtid])
{   
	$sql="delete from $T_CMT where cmt_id=$id";
    $ok=mysql_query($sql) or die(mysql_error());
	if ($ok){?>
        <script>alert("<?php=$cmt_show[$i][title]?>的评论删除成功!");window.location.reload();</script>
        <?php } }}?>
    </td>
  </tr>
  <tr  >
    <td colspan="8" class="tablerowhighlight"><?php echo $pagestr;?></td>
  </tr>
</table>
<?php }
?></body>
</html>
