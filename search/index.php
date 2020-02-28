<?php
require('../pscms_admin/config.php');
require('../builder/config.php');
require('../builder/left.php');
$tplVars =  array('path' => $glo_web_path,
	'file' => 'index',
	'cat' => '',
	'spec' => '',
	'id' => '',
	'doc_root' => $_SERVER['DOCUMENT_ROOT'],
	'builder'=> 'builder/'.$tplMap['index']['builder'],
	'template'=>'template/'.$tplMap['index']['template'],
	'header' => array('title' => '搜索结果-'.$glo_web_name,
	'description' => $glo_web_descript,
	'keywords'=> $glo_web_keywords,
	'copyright' => $glo_web_copyright,),
	'footer' => array(),
);
$path = $tplVars['doc_root'].$tplVars['path'];
$keywords = empty($keywords)? '' : $keywords;
$page = empty($page)? 1 : $page;
$prodCat = 2;

$pageSize = 10;
$pageStart = ($page - 1) * $pageSize;

$sql = <<<SQL
	select count(*) as total from $T_NEWS where news_cat = $prodCat and news_title like '%{$keywords}%'
SQL;

$result = mysql_query($sql) or die(mysql_error());

$total =  mysql_fetch_assoc($result);
$total = $total['total'];

$totalPage = ceil($total/$pageSize);

$sql =<<<SQL
	select * from $T_NEWS where news_cat = $prodCat and news_title like '%{$keywords}%' limit $pageStart, $pageSize
SQL;

$result = mysql_query($sql) or die (mysql_error());
$row = array();
while($rows = mysql_fetch_assoc($result)){
	$row[count($row)] = $rows;
}
$pagination = '';
if($totalPage > 1){
	if($page == 1){
		$pagination = <<<HTML
	<a href="{$urlPre}index-2.html">下一页</a>
HTML;
	}elseif($page<$totalPage){
		$_pre = $page - 1;
		$_next =  $page + 1;
		$pagination = <<<HTML
	<a href="{$urlPre}index-{$_pre}.html">下一页</a> <a href="{$urlPre}index-{$_next}.html">下一页</a>
HTML;
	}else{
		$pagination = <<<HTML
	 <a href="{$urlPre}index-{$totalPage}.html">下一页</a>
HTML;
		$pagination.= " {$page}/{$totalPage}";
	}
}

$navImg = $glo_web_path.'source/index_21.jpg';
$LEFT_CONTENT = getLeftContent(array('path' => $path, 'type' => 'index'));
$header = include('../template/header.html');
$footer = include('../template/footer.html');
$body =   include('../template/category.html');
$html = $header.$body.$footer;
if(defined('TIDY_TAG_UNKNOWN')){
	$config = array('indent' => TRUE,
		'output-xhtml' => TRUE,
		'wrap' => 200);
	$html = tidy_parse_string($html, $config, 'UTF8');
	$html->cleanRepair();
	$html = $html->value;
}
print_r($html);
?>
