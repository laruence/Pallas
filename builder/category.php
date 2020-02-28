<?php
require('config.php');
require('left.php');
function generateMarkUp($tplVars){
	global $T_NEWS,$T_CAT, $db, $glo_web_path, $categoryCache;
	$atSale = 8;//特价产品ID
	$cat = $tplVars['cat'];
	$spec = $tplVars['spec'];
	if($spec){
		$newsSql = <<<SQL
		select * from $T_CAT where cat_id = {$tplVars['spec']} limit 1;
SQL;
	}else{
		$spec = 0;
		$newsSql = <<<SQL
		select * from $T_CAT where cat_id = {$tplVars['cat']} limit 1;
SQL;
	}
	$result = mysql_query($newsSql) or die (mysql_error());
	$cat = mysql_fetch_assoc($result);
	if(empty($cat))
		return '';
	$tplVars['header']['title'] = $cat['cat_title'] .'-'. $tplVars['header']['title'];
	//$tplVars['header']['keywords'] = $tplVars['header']['keywords'];
	$tplVars['header']['description'] = $cat['cat_content'];
	//$path = $tplVars['doc_root'].$tplVars['path'];
	$path = '../';
	$LEFT_CONTENT = getLeftContent(array('path'=>$path, 'type' => 'category' , 'cat' => $tplVars['cat'], 'spec'=>$tplVars['spec']));
	$html = '';
	$htmlArr = array();
	if($cat['cat_attr'] == 1){
		$sql = <<<SQL
		select * from $T_NEWS where news_cat = {$tplVars['cat']}
SQL;
		if($spec)
			$sql .= " and news_spec = {$tplVars['spec']}";
		$sql .= ' limit 1';
		$result = mysql_query($sql) or die (mysql_error());
		$news = mysql_fetch_assoc($result);
		$pagination = '';
		if(empty($news))
			return '';
		//$path = $tplVars['doc_root'].$tplVars['path'];
		$path = '../';
		$header = include($path.'template/header.html');
		$footer = include($path.'template/footer.html');
		$body =   include($path.'template/news.html');
		$html = $header.$body.$footer;
		$htmlArr[0] = $html;
	}else{
		$sql = <<<SQL
select * from $T_NEWS where news_cat = {$tplVars['cat']}
SQL;
		if($tplVars['spec'])
			$sql .= <<<SQL
	and news_spec = {$tplVars['spec']}
SQL;
		if($tplVars['cat'] == $atSale){
			$sql = <<<WHERE
	select * from $T_NEWS where news_placard = 3 or news_cat = {$atSale} 
WHERE;
		}
		$sql .= ' order by news_date desc';

		$result = mysql_query($sql) or die (mysql_error());
		$total =  mysql_num_rows($result);
		$newsArr  = array();
		$pagesize = 10;
		$totalPage = ceil($total / $pagesize);
		while($row = mysql_fetch_assoc($result)){
			$newsArr[count($newsArr)] = $row;
		}
		$newsStore = array_chunk($newsArr, 10);
		$page = 1;
		$urlPre = <<<A
			{$glo_web_path}category/{$categoryCache[$tplVars['cat']]['ename']}/
A;
		if($tplVars['spec']){
			$urlPre .= $categoryCache[$tplVars['cat']]['ename']['childs'][$tplVars['spec']]['ename'].'/';
		}
		
		$navImg = $glo_web_path.'source/index_07_03.jpg';

		foreach($newsStore as $row){
			if($totalPage > 1){
				if($page == 1){
					$pagination = <<<HTML
	<a href="{$urlPre}index-2.html">下一页</a>
HTML;
				}else if($page<$totalPage){
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
			//$path = $tplVars['doc_root'].$tplVars['path'];
			$path = '../';
			$header = include($path.'template/header.html');
			$footer = include($path.'template/footer.html');
			$body =   include($path.'template/category.html');
			$html = $header.$body.$footer;
			if(defined('TIDY_TAG_UNKNOWN')){
				$config = array('indent' => TRUE,
					'output-xhtml' => TRUE,
					'wrap' => 200);
				$html = tidy_parse_string($html, $config, 'UTF8');
				$html->cleanRepair();
				$html = $html->value;
			}
			$htmlArr[count($htmlArr)] = $html;
			++$page;
		}
	}
	return $htmlArr;
}
?>
