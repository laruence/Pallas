<?php
require('session.inc');
if(empty($_SESSION['log']) || $_SESSION['log'] != true){
	echo "<script>window.location.replace('error.htm')</script>";
	die("没有登陆");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理日志</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.STYLE2 {color: #333333; font-weight:normal;}
-->
</style>
</head><body>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
	<th colspan=5>管理日志</th>
  </tr>
<tr align=center>
<td width="15%" class="tablerowhighlight">事件</td>
<td width="15%" class="tablerowhighlight">用户</td>
<td width="17%" class="tablerowhighlight">时间</td>
<td width="12%" class="tablerowhighlight" >IP</td>
<td width="41%" class="tablerowhighlight">操作日志</td>
</tr>

<?php 
$open_tags = array( 
	'record' => '<record>',
	'event' => '<event>', 
	'op' => '<op>', 
	'time' => '<time>',
	'action'=> '<action>',
	'ip'=>'<ip>'
); 

$close_tags = array( 
	'record' => '</record>',
	'event' => '</event>', 
	'op' => '</op>', 
	'time' => '</time>',
	'action'=> '</action>',
	'ip'=>'</ip>' 
); 

global $index,$eachpage,$start,$end;

$index=1;$eachpage=20;

if($page=='NULL' or $page==0){ 
	$page=0;
	$start=1;
}else
   	$start=$page*$eachpage+1;
?>

<?php 

function startElement($parser, $name, $attrs=''){ 
	global $open_tags, $temp, $current_tag; 
	$current_tag = $name; 
	if ($format = $open_tags[$name]){ 
		switch($name){ 
		case 'event': 

			break; 
		default: 
			break; 
		} 
	} 
} 


function endElement($parser, $name, $attrs=''){ 
	global $close_tags, $temp, $current_tag; 
	if ($format = $close_tags[$name]){ 
		switch($name){ 
		case 'event': 
			return_page($temp); 
			$temp = ''; 
			break; 
		default: 
			break; 
		} 
	} 
} 


function characterData($parser, $data){ 
	global $current_tag, $temp, $catID,$total;
	switch($current_tag){ 
	case 'record': 
		$total = $data; 
		$current_tag = ''; 
		break; 
	case 'op': 
		$temp['op'] = $data; 
		$current_tag = ''; 
		break; 
	case 'time': 
		$temp['time'] = $data; 
		$current_tag = ''; 
		break; 
	case 'action':
		$temp['action'] = $data;
		$current_tag = '';   
		break; 
	case 'ip':
		$temp['ip'] = $data;
		$current_tag = '';   
		break; 	
	default: 
		break; 
	} 
} 
?>  


<?php 

function return_page(){ 
	global $temp, $index,$total,$eachpage,$start,$end,$totalpage;
	$totalpage = (int)($total/$eachpage);
	if($total % $eachpage!=0)$totalpage++;
	$end = $start+$eachpage;
	if($index<$end&&$index>=$start)
	{
		$op=$temp['op'];
		$action=$temp['action'];
		echo "<tr onMouseOut=\"this.style.backgroundColor='#F1F3F5'\" onMouseOver=\"this.style.backgroundColor='#BFDFFF'\" bgColor='#F1F3F5'>
			<td align='center'>管理事件".$index."</td>
			<td align='center'>
			".$op."</td>
			<td height=20 align=center>".$temp['time']."&nbsp;</td>
			<td align=center>".$temp['ip']."</td>
			<td align=center>".$action."</td>
			</tr>";

	}
	++$index;
} 


$xml_file = 'log/log.xml'; 
$type = 'UTF-8'; 
$xml_parser = xml_parser_create($type); 
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false); 
xml_parser_set_option($xml_parser, XML_OPTION_TARGET_ENCODING, 'UTF-8'); 
xml_set_element_handler($xml_parser, 'startElement','endElement'); 
xml_set_character_data_handler($xml_parser, 'characterData'); 
if (!($fp = fopen($xml_file, 'r'))) { 
	die("? $xml_file ?~{'_~}!n"); 
} 
while ($data = fread($fp, 4096)) { 
	if (!xml_parse($xml_parser, $data, feof($fp))){ 
		die(sprintf( "XML error: %s at line %dnn", 
			xml_error_string(xml_get_error_code($xml_parser)), 
			xml_get_current_line_number($xml_parser))); 
	} 
} 
xml_parser_free($xml_parser); 
?>
<tr>
	<td colspan=5 class="tablerow" align="right"><a href="download.php?filename=log.xml"  >下载XML</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
<tr>
	<th colspan=5 align="left"><span class="STYLE2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "共有".$total."条日志记录，共分为".$totalpage."页&nbsp;&nbsp;"; if($page-1>=0) echo "<a href='?page=".($page-1)."'>上一页</a>";   ?>
	&nbsp;&nbsp;<?php if($page<($totalpage-1))echo "<a href='?page=".($page+1)."'>下一页</a>";?></span></th>
  </tr>
</table>
</body>
</html>
