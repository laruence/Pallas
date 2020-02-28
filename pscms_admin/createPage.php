<?php

$tplMap = array('index' => array('builder' => 'index.php', 'template' => 'index.html'),
	'category' => array('builder' => 'category.php', 'template' => 'detail.html'),
	'article' => array('builder' => 'news.php', 'template' => 'news.html'),
);

function buildPage($paraArr){
	global $categoryCache;
	$file = $paraArr['file'];
	$cat  = @$paraArr['cat'];
	$spec = @$paraArr['spec'];
	$id	  = @$paraArr['id'];
	//$path = $paraArr['doc_root'].$paraArr['path'];
	$path = "../";
	$spec = (isset($spec) && $spec != 0)? $categoryCache[$cat]['childs'][$spec]['ename'].'/' : '';
	$cat =  (isset($cat) && $cat != 0)? $categoryCache[$cat]['ename'] .'/' : '';

	include_once($path.$paraArr['builder']);
	$html = generateMarkUp($paraArr);
	if($html !== FALSE){
		switch($file){
		case 'index':
			$dstFilePath = $path.'index.html';
			$fp = fopen($dstFilePath, 'w');
			if(!$fp){
				return FALSE;
			}
			$result = fwrite($fp, $html);
			if($result === FALSE)
				return FALSE;
			break;
		case 'category':
			if(empty($cat)){
				return FALSE;
			}
			$dstPath = $path.'category/';
			$dstPath .= $cat.$spec;
			mkdirs('../category/'.$cat.$spec);
			$orginFiles = scandir('../category/'.$cat.$spec);
			if(is_array($orginFiles)){
				foreach($orginFiles as $file){
					if(strstr($file ,'index') !== FALSE){
						@unlink('../category/'.$cat.$spec.$file);
					}
				}
			}
			$page = 1;
			foreach($html as $sort){
				if($page == 1)
					$dstFilePath = $dstPath.'index.html';
				else
					$dstFilePath = $dstPath . 'index-'.$page.'.html';
				$fp = fopen($dstFilePath, 'w');
				if(!$fp){
					return FALSE;
				}
				$result = fwrite($fp, $sort);
				if($result === FALSE)
					return FALSE;
			}
			break;
		case 'article':
			if(empty($cat)){
				return FALSE;
			}
			$dstFilePath =  $path.'/category/'.$cat.$spec;
			mkdirs('../category/'.$cat.$spec);
			$page = 1;
			foreach($html as $news){
				if($page < 2)
					$filePath = $dstFilePath.$id.'.html';
				else
					$filePath = $dstFilePath.$id.'-'.$page.'.html';
				++$page;
				$fp = fopen($filePath, 'w');
				if(!$fp){
					return FALSE;
				}
				$result = fwrite($fp, $news);
				if($result === FALSE)
					return FALSE;
			}
			break;
		default:
		}
	}
	return TRUE;
}
?>
