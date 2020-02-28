<?php
require('config.php');
require('left.php');
define("laruence" , 1);
function generateMarkUp($tplVars){
	global $T_NEWS, $db, $glo_web_path, $categoryCache;
	$newsSql = <<<SQL
		select * from $T_NEWS where news_id = {$tplVars['id']} limit 1;
SQL;
	$result = mysql_query($newsSql) or die (mysql_error());
	$news = mysql_fetch_assoc($result);
	if(empty($news))
		return '';
	$cat = $tplVars['cat'];
	$spec = $tplVars['spec'];
	$spec = (isset($spec) && $spec != 0)? $categoryCache[$cat]['childs'][$spec]['ename'].'/' : '';
	$cat =  (isset($cat) && $cat != 0)? $categoryCache[$cat]['ename'] .'/' : '';
	$split = "[*next*]";
	$pagination = '';
	$contents = explode($split, $news['news_text']);
	$tplVars['header']['title'] = $news['news_title'] .'-'. $tplVars['header']['title'];
	$tplVars['header']['keywords'] = $news['news_keywords'] .','. $tplVars['header']['keywords'];
//	$path = $tplVars['doc_root'].$tplVars['path'];
	$path = '../';
	$LEFT_CONTENT = getLeftContent(array('path' => $path, 'type' => 'article', 'cat' => $tplVars['cat'], 'spec'=>$tplVars['spec']));
	$newsArr = array();
	for($page = 1; $page <= count($contents) ; ++$page){
		if(count($contents) > 1){
			if($page == 1){
				$news['news_text'] = $contents[0];
				$pagination = <<<A
			<a href="{$glo_web_path}category/{$cat}{$spec}{$tplVars['id']}-2.html">下一页</a>
A;
			}else{
				$news['news_text'] = $contents[$page-1];
				if($page == 2){
					$pagination = <<<A
			<a href="{$glo_web_path}category/{$cat}{$spec}{$tplVars['id']}.html">上一页</a>
A;
				}else{
					$p = $page -1;
					$pagination = <<<A
			<a href="{$glo_web_path}category/{$cat}{$spec}{$tplVars['id']}-{$p}.html">上一页</a>
A;
				}
				if($page < count($contents)){
					$p = $page + 1;
					$pagination .= <<<A
			<a href="{$glo_web_path}category/{$cat}{$spec}{$tplVars['id']}-{$p}.html">下一页</a>
A;
				}
			}
		}
		$header = include($path.'template/header.html');
		$footer = include($path.'template/footer.html');
		$body =   include($path.'template/news.html');
		$html = $header.$body.$footer;
		if(defined('TIDY_TAG_UNKNOWN')){
			$config = array('indent' => TRUE,
				'output-xhtml' => TRUE,
				'wrap' => 200);
			$html = tidy_parse_string($html, $config, 'UTF8');
			$html->cleanRepair();
			$html = $html->value;
		}
		$newsArr[$page] = $html;
	}
	return $newsArr;
}
?>
