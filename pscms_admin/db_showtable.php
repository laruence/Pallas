<?php
require('session.inc');
if(empty($_SESSION['log']) || $_SESSION['log']!=true) 
{echo "<script>window.location.replace('error.htm')</script>";
die($lang['unlogged']);}
require('news.php');
switch($glo_language)
{
case 'zh_cn':
  require_once('languages/lang_zh_cn.php');
case 'eng':
  require_once('languages/lang_eng.php');
}
$sql="SHOW TABLES FROM $db_data_base like '$db_data_base%'";
//echo $sql;
if (!$result = mysql_query($sql))

 { die ('Error getting table list (' . $sql . ' :: ' . mysql_error() . ')'); }

$tablerow = array();

while ($row = mysql_fetch_array($result))
 { 
   
 	$tablerow[] = $row;
 }

$total_tables       = count($tablerow);
$statrow            = array();
$total_rows         = 0;
$total_rows_average = 0;
$sizeo              = 0;

for ($i = 0; $i < count($tablerow); $i++) {

$sql = "SHOW TABLE STATUS LIKE '{$tablerow[$i][0]}';";

if (!$result = mysql_query($sql)) 
	{ 
	die ('Error getting table status (' . $sql . ' :: ' . mysql_error() . ')'); 
	}

$table_info = mysql_fetch_array($result);
//var_dump($table_info);
$total_rows         += $table_info["Rows"];
$tablerow[$i][rows]  =$table_info["Rows"];
$total_rows_average += $table_info[4];
$sizeo              += $table_info[5];
$tablerow[$i][size]  =$table_info[5];
$tablerow[$i][uptime]=$table_info['Update_time'];
$tablerow[$i][type]=$table_info['1'];
$tablerow[$i][charset]=$table_info['Collation'];
}
// Function to calculate size of the file
function c2s($bs) {
if ($bs < 964)     { return round($bs)           . " Bytes"; }
else if ($bs < 1000000) { return round($bs/1024,2)    . " KB"   ; }
else                    { return round($bs/1048576,2) . " MB"   ; }
}

mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $lang['db_showtable']?></title>
<link href="style.css" rel="stylesheet" type="text/css">
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

function change_all( check )
{
if(!check)
{
var b = document.getElementById('check_all');
b.checked=false;
} 

}

</Script>
</head><body><form name="tables" id="tables" method="post" action="database_op.php?op=backup">
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8><?php echo $lang['db_showtable']?></th>
  </tr>
<tr align=center>
<td width="4%" class="tablerowhighlight"><?php echo $lang['db_select']?></td>
<td width="12%" class="tablerowhighlight"><?php echo $lang['db_table']?></td>
<td width="10%" class="tablerowhighlight"><?php echo $lang['db_num']?></td>
<td width="14%" class="tablerowhighlight"> <?php echo $lang['db_size']?></td>
<td width="10%" class="tablerowhighlight" ><?php echo $lang['db_type']?></td>
<td width="15%" class="tablerowhighlight" ><?php echo $lang['db_char']?></td>
<td width="18%" class="tablerowhighlight" ><?php echo $lang['db_update_time']?></td>
<td width="17%" class="tablerowhighlight"><?php echo $lang['db_op']?></td>
</tr>

<?php
for ($i = 0; $i < count($tablerow); $i++) 
{
 echo "<tr onMouseOut=\"this.style.backgroundColor='#F1F3F5'\" onMouseOver=\"this.style.backgroundColor='#BFDFFF'\" bgColor='#F1F3F5'><td align='center'> ";
 echo "<input type=checkbox id='t_name[]' name='t_name[]' value='".$tablerow[$i][0]."' onclick='change_all(this.checked);'>";
 echo "</td>\n<td align='center'>";
 echo $tablerow[$i][0];
 echo "</td>\n<td align='center'>";
 echo $tablerow[$i][rows];
 echo "</td>\n<td align='center'>";
 echo c2s($tablerow[$i][size]);
 echo "</td>\n<td align='center'>";
 echo $tablerow[$i][type];
 echo "</td>\n<td align='center'>";
 echo $tablerow[$i][charset];
 echo "</td>\n<td align='center'>";
 echo $tablerow[$i][uptime];
 echo "</td>\n<td align='center'>";
 echo  "<a href='database_op.php?op=backup&t_name[]=".$tablerow[$i][0]."'>$lang[db_backup]</a> ";
 echo "</td></tr>";
 
}
?>
<tr onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' > 
<td align="center"><input type="checkbox" id="check_all" name="check_all"  onClick="checkAll();"  /></td>
<td align="center"><?php echo $lang['db_whole']?>
</td>
<td align="center"> <?php echo $total_rows ?>   </td>
<td align="center"> <?php echo c2s($sizeo)?></td>
<td align="center"><?php echo $lang['db_MyISAM']?></td>
<td align="center">————</td>
<td align="center">————</td>
<td align="center"><input type="button" onClick="document.tables.submit();" value="<?php echo $lang['db_backup_table']?>" /></td>

</tr>
<tr>
    <th colspan=8 align="left">
	<span class="STYLE2">
	
	&nbsp;&nbsp;<?php  
	
	echo " $lang[db_total] $total_tables $lang[db_num_talbe] $total_rows $lang[db_num_record] ";

	echo " $lang[db_space]: " . c2s($sizeo);

?>
</span></th>
  </tr>
</table>
</form>
</body>
</html>
