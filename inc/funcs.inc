<?php
function printLinkPre($category,$spec=''){
	global $glo_web_path;
	$linkStr = "/";
	$linkStr .= ($glo_web_path)?$glo_web_path:"";
	$linkStr .= "category/".$category."/";
	$linkStr .= $spec?$spec.'/':"";
	$linkStr .= "index.html";
	print($linkStr);
	return;
}
function getDstCatPath(){
	$category = (isset($_REQUEST['cat']))?$_REQUEST['cat']:'';
	$spec = (isset($_REQUEST['spec']))?$_REQUEST['spec']:'';
	$page = (isset($_REQUEST['page']))?$_REQUEST['page']:'';
	$dstFile = "category/".$category."/";
	$dstFile .= ($spec)?$spec."/":'';
	$dstFile .= ($page)?"index-".$page.".html":"index.html";
	return $dstFile;
}
function getDstFilePath(){
	$category = (isset($_REQUEST['cat']))?$_REQUEST['cat']:'';
	$spec = (isset($_REQUEST['spec']))?$_REQUEST['spec']:'';
	$newsId=(isset($_REQUEST['id']))?$_REQUEST['id']:'';
	$page = (isset($_REQUEST['page']))?$_REQUEST['page']:'';
	$dstFile = "category/".$category."/";
	$dstFile .= ($spec)?$spec."/":'';
	$dstFile .= ($page)?$newsId."-".$page.".html":$newsId.".html";
	return $dstFile;
}
function getCategoryName(&$catname,&$specname){
	global $db,$T_CAT;
	$category = (isset($_REQUEST['cat']))?$_REQUEST['cat']:'';
	$spec = (isset($_REQUEST['spec']))?$_REQUEST['spec']:'';
	if($category == '')
	{
		$catname = "Undefined";
		return false;
	}
	$sql = "select cat_title from $T_CAT where cat_id = $category";
	$result = $db->query($sql) or die($db->error);
	$row = $result -> fetch_object();
	$catname = $row -> cat_title;
	return true;
}
function getPaginationStr($page,$totalpage){
	$str = "[<a href='index.html'>��ҳ</a>]&nbsp;"; 
	if($page>5&&$page<$totalpage-5)
		$i=$page-5;
	else{
		if($page>=$totalpage-5)
			$i=$totalpage-9 ;
		else 
			$i=1;
	}
	if($totalpage<=10) $i=1;
	$count=10;
	for($i;$i<=$totalpage&&$totalpage>1&&$count>0;$i++)
	{ 
		if($i!=$page)
			$str .= "&nbsp;[<a href='index-".$i.".html'>".$i."</a>]&nbsp;"; 
		else
			$str .=  "&nbsp;".$i."&nbsp;";
		$count--;
	}
	if($totalpage != 0)
	{
		$str .= "[<a href='index-".$totalpage.".html'>βҳ</a>]&nbsp;";
	}
	else 
	{
		$str .= "[<a href='index.html'>βҳ</a>]&nbsp;";
	}
	return $str;
}
function &fetchOneNewsObject(){
	global $db,$T_NEWS;
	$newsId=(isset($_REQUEST['id']))?$_REQUEST['id']:'';
	if($newsId == '') 
		return "Undefined";
	$sql = "select * from $T_NEWS where news_id = $newsId";
	$result = $db -> query($sql);
	return $result->fetch_object();
}
?>
