<?php
require('config.php');
require('left.php');
function generateMarkUp($tplVars){
	global $T_NEWS, $db, $glo_web_path, $categoryCache;
	$notice = 6;//站内快讯ID
	$recom = 4; //推荐新闻type
	$sql =<<<SQL
		select * from $T_NEWS where news_cat = $notice order by news_date limit 5
SQL;
	$result = mysql_query($sql) or die(mysql_error());
	$tplVars['notice'] = array();
	while($row = mysql_fetch_assoc($result)){
		$tplVars['notice'][count($tplVars['notice'])] = $row;
	}
	$sql =<<<SQL
		select * from $T_NEWS where news_placard = $recom order by news_date limit 12
SQL;
	$result = mysql_query($sql) or die(mysql_error());
	$tplVars['products'] = array();
	while($row = mysql_fetch_assoc($result)){
		$tplVars['products'][count($tplVars['products'])] = $row;
	}
	$path = '../';
	$LEFT_CONTENT = getLeftContent(array('path' => $path, 'type' => 'index'));
	$header = include($path.'template/header.html');
	$footer = include($path.'template/footer.html');
	$body =   include($path.'template/index.html');
	$html = $header.$body.$footer;
	if(defined('TIDY_TAG_UNKNOWN')){
		$config = array('indent' => TRUE,
			'output-xhtml' => TRUE,
			'wrap' => 200);
		$html = tidy_parse_string($html, $config, 'UTF8');
		$html->cleanRepair();
		$html = $html->value;
	}
	return $html;
}
?>
