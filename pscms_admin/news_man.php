<?php
require('session.inc');
require("news.php") ;
require('createPage.php');
if(empty($_SESSION['log']) || $_SESSION['log']!=true) 
{echo "<script>window.location.replace('error.htm')</script>";
die("没有登陆");}
switch($glo_language)
{
case 'zh_cn':
	require_once('languages/lang_zh_cn.php');
case 'eng':
	require_once('languages/lang_eng.php');
}

?>
<html>
<head>
<title><?php echo $lang['news_man']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="source/function.js"></script>
<style>
.title{ background-color:#66CCFF;
}
</style>
</head>
<body>
<?php 

$Naction=$_GET['news_action'];
if($_GET['type']==NULL)
{
	if($Naction=='cancel')
	{
		$sql="update $T_NEWS set news_placard=0 where news_id = $id";
		$result=mysql_query($sql);
		if($result)
		{
			echo "<script>alert('操作成功!');window.location.replace('news_man.php?delete=yes');</script>";
			exit();
		}
	}
	elseif($Naction == 'gen')
	{
	$paras = array('path' => $glo_web_path,
		'file' => 'article',
		'cat' => $cat,
		'spec' => $spec,
		'id' => $id,
		'doc_root' => $_SERVER['DOCUMENT_ROOT'],
		'builder'=> 'builder/'.$tplMap['article']['builder'],
		'template'=>'template/'.$tplMap['article']['template'],
		'header' => array('title' => $glo_web_name,
		'description' => $glo_web_descript,
		'keywords'=> $glo_web_keywords,
		'copyright' => $glo_web_copyright,),
		'footer' => array(),
	);
	if(buildPage($paras)){
			echo "<script>alert('生成成功!');window.location.replace('news_man.php?delete=yes');</script>";
	}else{
			echo "<script>alert('生成失败!请检查Category目录权限!');window.location.replace('news_man.php?delete=yes');</script>";
	}
			exit();
	}else{
		switch($Naction)
		{
		case 'ann':
			$sql="update $T_NEWS set news_placard=1 where news_id = $id";
			break;
		case 'top':
			$sql="update $T_NEWS set news_placard=2 where news_id = $id";
			break;
		case 'eli':
			$sql="update $T_NEWS set news_placard=3 where news_id = $id";
			break;

		}
		$result=mysql_query($sql);
		if($result) 
		{
			echo "<script>alert('操作成功!');window.location.replace('news_man.php?delete=yes');</script>";
			exit();}

	}
	if(isset($cat)&&$cat!=0){
		$sql="select * from $T_NEWS where news_cat=$cat order by news_date desc";
	}
	else
	{
		$sql="select * from $T_NEWS order by news_date desc";
	}
	$result=mysql_query($sql) or die(mysql_error());
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
	if($page>0) $pagestr=$pagestr."[<a href=".$PATH_INFO."?page=".($page-1)."&delete=yes&cat=".$cat.">上一页</a>] ";
	$pagestr=$pagestr."[第 ";
	for ($i=0;$i<$totalpage;$i++)
	{
		if ($i!=$page) {$pagestr=$pagestr."<a href=".$PATH_INFO."?page=".$i."&delete=yes&cat=".$cat.">".($i+1)."</a> ";}
		else {$pagestr=$pagestr.($i+1)." ";}
	}
	$pagestr=$pagestr."页]";

	if ($page<($totalpage-1)) $pagestr=$pagestr." [<a href=".$PATH_INFO."?&page=".($page+1)."&delete=yes&cat=".$cat.">下一页</a>]";

?><table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<td class="submenu" align=center colspan="2"><?php echo $lang['news_man']?></td>
  </tr>
  <tr>
	<td width="25%"  class="tablerow" ><b><?php echo $lang['manage']?>：</b><a href="news_add.php"><?php echo $lang['news_add']?></a> | <a href="news_man.php?delete=yes"><?php echo $lang['news_man']?>  </a></td>
	<script>
	function cat_see()
	{

		var cat=document.getElementById("catsee").value;
		if(cat==-1) return false;
		window.location.replace('news_man.php?delete=yes&cat='+cat);


	}


	</script>
	<td width="75%"  class="tablerow">	<select name="catsee" id="catsee" onChange="cat_see();">
	<option value="-1"><?php echo $lang['sort_see']?></option>
	<option value="0"><?php echo $lang['sort_def']?></option>
<?php $sql="select * from $T_CAT where cat_parent=0" ;
$result_cat=mysql_query($sql) or die(mysql_error());
while($rows=mysql_fetch_array($result_cat,MYSQL_BOTH))
{
	if($cat&&$cat==$rows['cat_id']){
		echo "<option value=".$rows['cat_id']." selected >".$rows['cat_title']."</option>";
	}

	else
	{
		echo "<option value=".$rows['cat_id'].">".$rows['cat_title']."</option>";
	}
}
?></select>
	</td>
  </tr>
</table>

<table align=top cellpadding="2" cellspacing="1"  style="  border: 0px solid #183789; WIDTH: 100%; BACKGROUND-COLOR: #F2F2F2; ">
  <tr>
	<th colspan=9 class="STYLE1"><?php echo $lang['news_list']?></th>
  </tr>
<tr align=center>
<td width="6%" class="tablerowhighlight"><?php echo $lang['select']?></td>
<td  width="2%" class="tablerowhighlight">ID</td>
<td width="23%" class="tablerowhighlight"><?php echo $lang['n_title']?></td>
<td width="9%" class="tablerowhighlight"><?php echo $lang['n_author']?></td>
<td width="9%" class="tablerowhighlight"><?php echo $lang['n_typein']?></td>
<td width="9%" class="tablerowhighlight">IP</td>
<td width="9%" class="tablerowhighlight"><?php echo $lang['n_date']?></td>
<td width="5%" class="tablerowhighlight"><?php echo $lang['n_click']?></td>
<td width="30%" class="tablerowhighlight"><?php echo $lang['n_manage']?></td>
</tr>
<?php
for ($i=$start; $i<$end; $i++) {
	$news_show[$i][id]=mysql_result($result,$i,"news_id");
	$news_show[$i][news_title]=mysql_result($result,$i,"news_title");
	$news_show[$i][news_cat]=mysql_result($result,$i,"news_cat");
	$news_show[$i][news_author]=mysql_result($result,$i,"news_author");
	$news_show[$i][news_from]=mysql_result($result,$i,"news_from");
	$news_show[$i][news_spec]=mysql_result($result,$i,"news_spec");
	$news_show[$i][news_typein]=mysql_result($result,$i,"news_typein");
	$news_show[$i][news_date]=mysql_result($result,$i,"news_date");
	$news_show[$i][news_click]=mysql_result($result,$i,"news_click");
	$news_show[$i][placard]=mysql_result($result,$i,"news_placard");
	$news_show[$i][news_text]=mysql_result($result,$i,"news_text");
	$news_show[$i][news_ip]=mysql_result($result,$i,"news_ip");
	$url = "../category/". $categoryCache[$news_show[$i]['news_cat']]['ename'];
	$url .= ($news_show[$i]['news_spec'] == 0)? '' : '/'.$categoryCache[$news_show[$i]['news_cat']]['childs'][$news_show[$i]['news_spec']]['ename'];
	$url .= '/'.$news_show[$i]['id'] . '.html';
?>
<tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox"></td>
<td><?php echo $news_show[$i][id]?></td>
<td ><?php echo "<a href='$url' target='_blank'>".$news_show[$i][news_title]."</a>" ?></td>
<td><?php echo $news_show[$i][news_author];?></td>
<td><?php echo $news_show[$i][news_typein];?></td>
<td><?php echo $news_show[$i][news_ip];?></td>
<td><?php echo substr($news_show[$i][news_date],0,10) ;?></td>
<td><?php echo $news_show[$i][news_click] ;?></td>
<td><?php echo "<a href=news_edit.php?id=".$news_show[$i][id].">修改</a>&nbsp;"  ;
if($news_show[$i][placard]==1)
{echo "<a href=news_man.php?id=".$news_show[$i][id]."&news_action=cancel>取消公告</a> " ;} 
else {echo "<a href=news_man.php?id=".$news_show[$i][id]."&news_action=ann>公告</a> " ;}
if($news_show[$i][placard]==2)
{echo "<a href=news_man.php?id=".$news_show[$i][id]."&news_action=cancel>取消固顶</a> " ;} 
else {echo "<a href=news_man.php?id=".$news_show[$i][id]."&news_action=top>固顶</a> "; }
if($news_show[$i][placard]==3)
{echo "<a href=news_man.php?id=".$news_show[$i][id]."&news_action=cancel>取消推荐</a> "; } 
else {echo "<a href=news_man.php?id=".$news_show[$i][id]."&news_action=eli>推荐</a> "; }
echo "<a href='news_man.php?id=".$news_show[$i][id]."&delete=yes' onclick=\"return MakeSure(this.href,'删除".$news_show[$i][news_title]."');\">删除</a> "  ;

if(file_exists($url)){
	echo "<a href='news_man.php?news_action=gen&cat=".$news_show[$i][news_cat]."&spec=".$news_show[$i][news_spec]."&id=".$news_show[$i][id]."'>重新生成</a>";
}else{
	echo "<a href='news_man.php?news_action=gen&cat=".$news_show[$i][news_cat]."&spec=".$news_show[$i][news_spec]."&id=".$news_show[$i][id]."'>生成</a>";
}

if( $id == $news_show[$i]['id'] && $delete=='yes')
{
	$sql="DELETE FROM $T_NEWS WHERE news_id=$id";
	$sql2="DELETE FROM $T_CMT WHERE id=$id";
	mysql_query($sql);
	mysql_query($sql2);
	//删除静态页面
	$cat = $news_show[$i]['news_cat'];
	$spec = $news_show[$i]['news_spec'];
	$spec = (isset($spec) && $spec != 0)? $categoryCache[$cat]['childs'][$spec]['ename'].'/' : '';
	$cat =  (isset($cat) && $cat != 0)? $categoryCache[$cat]['ename'] .'/' : '';
	$d_path = '../category/'.$cat.$spec;
	$d_file = $d_path . $news_show[$i]['id'].'.html';
	$d_page = 1;
	//删除分页静态页面
	while(file_exists($d_file)){
		unlink($d_file);
		$d_file = $d_path . $news_show[$i]['id'] . '-' . ++$d_page . '.html';
	}

	$action="删除新闻".$news_show[$i]['news_title'];
	wLog($_SESSION['loginname'],$date,$action,$ip);
	?><script>alert("<?php echo $news_show[$i]['news_title']?>删除成功!");window.location.reload();</script><?php } }?>
		</td>
		</tr>

		<tr  ><td colspan="9" class="tablerowhighlight" style=" font-weight:normal"><?php echo $pagestr;?></td></tr>

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
<table align=top cellpadding="2" cellspacing="1"  style="  border: 0px solid #183789; WIDTH: 100%; BACKGROUND-COLOR: #ffffff; ">
  <tr>
	<th colspan=8 class="STYLE1"><?php echo $lang['cmt_list']?></th>
  </tr>
<tr align=center>
	 <td  width="7%"class="tablerowhighlight"><?php echo $lang['select']?></td>
	<td width="15%" class="tablerowhighlight"><?php echo $lang['cmt_title']?></td>
	<td width="8%" class="tablerowhighlight"><?php echo $lang['cmt_author']?></td>
	<td width="10%" class="tablerowhighlight"><?php echo $lang['n_date']?></td>
	<td width="10%" class="tablerowhighlight">E_Mail</td>
	<td width="15%" class="tablerowhighlight">IP</td>
	<td width="20%" class="tablerowhighlight"><?php echo $lang['cmt_text']?></td>
	<td width="15%" class="tablerowhighlight"><?php echo $lang['n_manage']?></td>
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
	<td><?php echo "<a href=$REQUEST_URI&id=".$cmt_show[$i][cmtid]."&uname=".$cmt_show[$i][name].">删除</a>"  ;
		if($id==$cmt_show[$i][cmtid])
		{   
			$sql="delete from $T_CMT where cmt_id=$id";
			$ok=mysql_query($sql) or die(mysql_error());
			if ($ok){?>
		<script>alert("<?php echo $cmt_show[$i][title]?>的评论删除成功!");window.location.reload();</script>
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
