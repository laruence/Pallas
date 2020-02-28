<?php
require('session.inc');
if(empty($_SESSION['log']) || $_SESSION['log']!=true){
	echo "<script>window.location.replace('error.htm')</script>";
	die($lang['unlogged']);
}
require('news.php');
switch($glo_language){
case 'zh_cn':
	require_once('languages/lang_zh_cn.php');
case 'eng':
	require_once('languages/lang_eng.php');
}
$dir='./data/';
$dir= @opendir($dir);
if(!$dir) 
	exit($lang['db_unexist']);
function c2s($bs){
	if ($bs < 964){ 
		return round($bs) . " Bytes"; 
	}else if($bs < 1000000){
		return round($bs/1024,2) . " KB";
   	}else{
		return round($bs/1048576,2) . " MB";
   	}
}

function check($file){
	global $T_NEWS,$T_VOTE,$T_USERS,$T_CMT,$T_GBOOK,$T_CAT;
	$fp = fopen($file,"r");
	$str = fread($fp,filesize($file));

	$table="";
	$flag=0;
	if(strpos($str,$T_NEWS)!==false)
	{ 
		$table.=$T_NEWS." ";$flag++;
	}
	if(strpos($str,$T_USERS)!==false)
	{ $table .=$T_USERS." ";$flag++;
	}
	if(strpos($str,$T_CMT)!==false)
	{ $table .=$T_CMT." ";$flag++;
	}
	if(strpos($str,$T_VOTE)!==false)
	{ $table .=$T_VOTE." ";$flag++;
	}
	if(strpos($str,$T_GBOOK)!==false)
	{ $table .=$T_GBOOK." ";$flag++;
	}

	if(strpos($str,$T_CAT)!==false)
	{ $table .=$T_CAT." ";$flag++;
	}
	if($flag==6) $table="全部表";

	return $table;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $lang['db_restore']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="source/function.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #333333; font-weight:normal;}
-->
</style>
<Script>
function checkAll()
{  
	var a = document.getElementsByName("t_name[]");
	var b = document.getElementById('check_all');

	if(b.checked==false){
		for (var i=0; i<a.length; i++)
			if (a[i].type == "checkbox") a[i].checked = false;

	}
	else
	{
		for (var i=0; i<a.length; i++)
			if (a[i].type == "checkbox") a[i].checked = true;
	}
}

</Script>
</head><body><form name="tables" id="tables" method="post" action="database_op.php?op=backup">
  <table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
	<tr>
	  <th colspan=7><?php echo $lang['db_restore']?></th>
	</tr>
	<tr align=center>
	  <td width="19%" class="tablerowhighlight"><?php echo $lang['db_re_name']?></td>
	  <td width="13%" class="tablerowhighlight"><?php echo $lang['db_re_size']?></td>
	  <td width="21%" class="tablerowhighlight"><?php echo $lang['db_re_table']?></td>
	  <td width="20%" class="tablerowhighlight"> <?php echo $lang['db_re_found']?></td>
	  <td width="13%" class="tablerowhighlight" ><?php echo $lang['db_re_type']?></td>
	  <td width="14%" class="tablerowhighlight"><?php echo $lang['db_re_op']?></td>
	</tr>
<?php
while($file=readdir($dir))
{
	if($file!="." && $file!="..")
	{
		$filename="./data/".$file;
		echo "<tr onMouseOut=\"this.style.backgroundColor='#F1F3F5'\" onMouseOver=\"this.style.backgroundColor='#BFDFFF'\" bgColor='#F1F3F5'><td align='center'> ";
		echo $file;
		echo "</td>\n<td align='center'>";
		echo c2s( filesize($filename));
		echo "</td>\n<td align='center'>";
		echo  check($filename);
		echo "</td>\n<td align='center'>";
		echo  date("F j, Y, g:i a",filemtime($filename));
		echo "</td>\n<td align='center'>";
		echo  "sql文件";
		echo "</td>\n<td align='center'>";
		echo  "<a href='download.php?filename=".$file."' >".$lang[db_re_download]."</a> <a href='database_op.php?op=restore&restorefile=".$file."' onClick=\"return MakeSure(this.href,'".$lang[db_re_backup].$file."');\">$lang[db_re]</a> <a href='database_op.php?op=del&restorefile=".$file."' onClick=\"return MakeSure(this.href,'".$lang['db_re_delete'].$file."');\">$lang[db_re_de]</a> ";
		echo "</td></tr>";

	}
}

?>
	<tr>
	  <th colspan=7 align="left"> <span class="STYLE2">
	 &nbsp;&nbsp; <?php echo $lang['db_re_tip']?>
	  </span></th>
	</tr>
  </table>
</form>
</body>
</html>
