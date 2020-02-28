<?php
function download($dir){
	//$dir= "./data/";
	$file = $_GET['filename'];	
	$fp = fopen($dir.$file,"r"); 	
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: ".filesize($dir.$file));
	Header("Content-Disposition: attachment; filename=" . $file);
	echo fread($fp,filesize($dir.$file));
	fclose($fp);
}

function extend($file_name) 
{ 
	$extend = pathinfo($file_name); 
	$extend = strtolower($extend["extension"]); 
	return $extend; 
} 

$ext=extend($_GET['filename']);

if($ext=="sql")
{
	$dir="./data/";
	download($dir);
}
else if($ext=="xml"){
	$dir="./log/";
	download($dir);
}
else{
	die("不容许的下载文件类型");
}
?>
