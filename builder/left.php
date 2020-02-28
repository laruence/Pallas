<?php
function getLeftContent($tplVars){
	global $T_NEWS, $glo_web_path, $categoryCache;
	switch($tplVars['type']){
	case 'category':
		if(isset($categoryCache[$tplVars['cat']]['childs']) && count($categoryCache[$tplVars['cat']]['childs']) > 0){
			$count = count($categoryCache[$tplVars['cat']]['childs']);
			switch($count){
			case 2:
				$limit = 10;
				break;
			case 3:
				$limit = 6;
				break;
			case 4:
				$limit = 5;
				break;
			case 5:
				$limit = 4;
				break;
			default:
				$limit = 15;
			}
			foreach($categoryCache[$tplVars['cat']]['childs'] as $key => $child){
				$sql = <<<HTML
			select * from $T_NEWS where news_spec = $key order by news_date desc limit $limit; 
HTML;
				$result = mysql_query($sql);
				$news = array();
				while($row = mysql_fetch_assoc($result)){
					array_push($news, $row);
				}
				$tplVars['contents'][$categoryCache[$tplVars['cat']]['childs'][$key]['cname']] = $news;
				$tplVars['contents'][$categoryCache[$tplVars['cat']]['childs'][$key]['cname']]['cat_url'] = $glo_web_path.'category/'.$categoryCache[$tplVars['cat']]['ename'].'/'.$categoryCache[$tplVars['cat']]['childs'][$key]['ename'].'/';
			}
			break;
		}
	case 'article':
	case 'index':
	default:
		$newsSql = <<<SQL
	select * from $T_NEWS where news_placard = 1  and news_cat = 2 order by news_date desc limit 10;
SQL;
		$newsShow = array();
		$result = mysql_query($newsSql) or die (mysql_error());
		while($row = mysql_fetch_assoc($result)){
			array_push($newsShow, $row);
		}
		$newsListSql = <<<SQL
		select * from $T_NEWS where news_placard = 2 and news_cat = 2 order by news_date desc limit 20;
SQL;

		$newsList = array();
		$result = mysql_query($newsListSql) or die (mysql_error());
		while($row = mysql_fetch_assoc($result)){
			array_push($newsList, $row);
		}
		$tplVars['contents']['推荐产品'] = $newsShow;
		$tplVars['contents']['热门产品'] = $newsList;
		break;
	}
	return include('../template/left.html');
}
?>
