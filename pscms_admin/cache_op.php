<?php 
require('session.inc');
require('news.php');
require('createPage.php');

if(empty($_SESSION['log']) && $_SESSION['log']!=true)
{ //check login? 
	echo "<script>window.location.replace('error.htm')</script>";
	exit();
}
switch($glo_language)
{
case 'zh_cn':
	require_once('languages/lang_zh_cn.php');
case 'eng':
	require_once('languages/lang_eng.php');
}

$alert = FALSE;
switch($action){
case "all":
	break;
case "index":
	$paras = array('path' => $glo_web_path,
		'file' => 'index',
		'cat' => '',
		'spec' => '',
		'id' => '',
		'doc_root' => $_SERVER['DOCUMENT_ROOT'],
		'builder'=> 'builder/'.$tplMap['index']['builder'],
		'template'=>'template/'.$tplMap['index']['template'],
		'header' => array('title' => $glo_web_name,
		'description' => $glo_web_descript,
		'keywords'=> $glo_web_keywords,
		'copyright' => $glo_web_copyright,),
		'footer' => array(),
	);
	$alert = TRUE;
	if(buildPage($paras)){
		$msg = '更新首页成功!';
	}else{
		$msg = '更新失败，请检查服务器权限!';
	};
	break;
case "category":
	$alert = TRUE;
	$flag = TRUE;
	if(isset($categoryCache[$id]['childs'])){
		foreach($categoryCache[$id]['childs'] as $key => $child){
			$paras = array('path' => $glo_web_path,
				'file' => 'category',
				'cat' => $id,
				'spec' => $key,
				'id' => '',
				'doc_root' => $_SERVER['DOCUMENT_ROOT'],
				'builder'=> 'builder/'.$tplMap['category']['builder'],
				'header' => array('title' => $glo_web_name,
				'description' => $glo_web_descript,
				'keywords'=> $glo_web_keywords,
				'copyright' => $glo_web_copyright,),
				'footer' => array(),
			);
			if(!buildPage($paras))
				$flag = FALSE;
		}
		$paras = array('path' => $glo_web_path,
			'file' => 'category',
			'cat' => $id,
			'spec' => 0,
			'id' => '',
			'doc_root' => $_SERVER['DOCUMENT_ROOT'],
			'builder'=> 'builder/'.$tplMap['category']['builder'],
			'header' => array('title' => $glo_web_name,
			'description' => $glo_web_descript,
			'keywords'=> $glo_web_keywords,
			'copyright' => $glo_web_copyright,),
			'footer' => array(),
		);
		if(!buildPage($paras))
			$flag = FALSE;
	}else{
		$paras = array('path' => $glo_web_path,
			'file' => 'category',
			'cat' => $id,
			'spec' => 0,
			'id' => '',
			'doc_root' => $_SERVER['DOCUMENT_ROOT'],
			'builder'=> 'builder/'.$tplMap['category']['builder'],
			'header' => array('title' => $glo_web_name,
			'description' => $glo_web_descript,
			'keywords'=> $glo_web_keywords,
			'copyright' => $glo_web_copyright,),
			'footer' => array(),
		);
		if(!buildPage($paras))
			$flag = FALSE;
	}
	if($flag){
		$msg = '更新栏目成功';
	}else{
		$msg = '更新失败，请检查服务器category目录权限!';
	}
	break;
case "article":
	break;
default:
}
?>
 <html>
<head>
<title><?php echo $lang['cacheop']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="source/function.js"></script>
<script language="javascript">
function showMsg(){
<?php 
if($alert){
	echo "showHint('$msg');";
}
?>
return true;
}
</script>
<style>
.title{ background-color:#66CCFF;
}
</style>
</head>
<body onLoad="showMsg()">
 <table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
	<td class="submenu" align=center>更新缓存</td>
  </tr>
  <tr>
	<td class="tablerow">
	<form action="?action=category" method="post">
	<b>更新选项：</b><a href="cache_op.php?action=all" onClick="return MakeSure(this.href,'确定删除全站的静态页面?');">更新全站</a> | <select name="id" id="id">
	<option value="NULL">请选择要更新的栏目</option>
<?php $sql="select * from $T_CAT where cat_parent=0 and cat_static=1" ;
$result_cat=mysql_query($sql) or die(mysql_error());
while($rows=mysql_fetch_array($result_cat,MYSQL_BOTH)){
	if(isset($cat)&&$cat==$rows['cat_id'])
	{
		echo "<option value=".$rows['cat_id']." selected >".$rows['cat_title']."</option>";
	}

	else
	{
		echo "<option value=".$rows['cat_id'].">".$rows['cat_title']."</option>";
	}
}
?></select>

	<input type="submit" value="更新选定栏目" onClick="this.form.action='?action=category';" />| <a href="cache_op.php?action=index" onClick="return MakeSure(this.href,'确定删除首页的静态页面?');">更新首页</a>
	</form>

	注意:
	这项操作会删除所有已经生成的静态页面,如果全站数据量较大,可能会需要较长时间;</td>
	</tr>
	</table>
	</body>
	</html>
