<?php
//------------------------------------------------ 
// 取中文的substr() 
// 由laruence增加了对于带有font属性的字符串的截取
// laruence@yahoo.com.cn
//------------------------------------------------ 

#$_SESSION['login'] = true;
#$_SESSION['grad'] = 1;
#$_SESSION['loginname'] = 'admin';
#$_SESSION['loginid'] = '1';

function csubstr($str,$start,$len) 
{ 
	if(substr($str,0,1)=="<"&&substr($str,-1,1)==">")
	{
		$fonti=FALSE;
		$fontb=FALSE;
		$font=FALSE;
		if(stristr($str,"</b>"))
			$fontb=TRUE;
		if(stristr($str,"</i>"))
			$fonti=TRUE;
		if(stristr($str,"</font>"))
			$font=TRUE;

		if($fonti&&$font&&$fontb)

		{
			$strleft=substr($str,0,26);
			$strright=substr($str,-15);
			$str=substr($str,26,strlen($str)-41);
			return $strleft.csubstr($str,$start,$len-1).$strright;
		}
		elseif($fonti&&$font||$fontb&&$font)
		{ 

			$strleft=substr($str,0,23);
			$strright=substr($str,-11);
			$str=substr($str,23,strlen($str)-34);
			return $strleft.csubstr($str,$start,$len-1).$strright;
		}
		elseif($fonti&&$fontb)
		{ 

			$strleft=substr($str,0,6);
			$strright=substr($str,-8);
			$str=substr($str,6,strlen($str)-14);
			return $strleft.csubstr($str,$start,$len-1).$strright;
		}
		elseif ($fonti||$fontb)
		{
			$strleft=substr($str,0,3);
			$strright=substr($str,-4);
			$str=substr($str,3,strlen($str)-7);
			return $strleft.csubstr($str,$start,$len-1).$strright;
		}
		else
		{
			$strleft=substr($str,0,20);
			$strright=substr($str,-7);
			$str=substr($str,20,strlen($str)-27);
			return $strleft.csubstr($str,$start,$len).$strright;
		}
	}

	$strlen=strlen($str); 
	$clen=0; 
	$elen=0;
	for($i=0;$i<$strlen;$i++) 
	{ 
		if ($clen>=$start+$len) 
			break; 
		if(ord(substr($str,$i,1))>0xa0) 
		{ 
			if ($clen>=$start) 
				$tmpstr.=substr($str,$i,2); 
			$i++; 
			$clen++;
		} 
		else 
		{ 
			if ($clen>=$start) 
				$tmpstr.=substr($str,$i,1); 

			if($elen = ($elen xor 1))//英文字符2个占用一个长度
				$clen++;

		}
	} 
	if ($str<>$tmpstr) //判断是否加省略号
		$tmpstr .= "..."; 
	return $tmpstr; 
} 
//------------------------------------------------ 
// 返回指定长度的字符串，超过部分加... 
//------------------------------------------------ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function showShort($str,$len) 
{ 
	$tempstr = csubstr($str,0,$len); 
	return $tempstr; 
}

//  $document  应包含一个  HTML  文档。
//  本例将去掉  HTML  标记，javascript  代码
//  和空白字符。还会将一些通用的
//  HTML  实体转换成相应的文本。
function cuthtml($str)
{
	$search  =  array  ("'<script[^>]*?>.*?</script>'si",                            //  去掉  javascript
		"'<[\/\!]*?[^<>]*?>'si",                      //  去掉  HTML  标记
		"'([\r\n])[\s]+'",                            //  去掉空白字符
		"'&(quot|#34);'i",                            //  替换  HTML  实体
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(\d+);'e");                               //  作为  PHP  代码运行

	$replace  =  array  ("",
		"",
		"\\1",
		"\"",
		"&",
		"<",
		">",
		"  ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)");

	$text  =  preg_replace  ($search,  $replace,  $str);
	return $text;

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function alert($var)
{
	echo "<script>alert('".$var."');</script>";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
function reurl($var)
{
	echo "<script>window.location.replace('".$var."');</script>";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function addwater($srcFile,$str,$path,$alpha)
{
	$data=getimagesize($srcFile);
	switch ($data[2]) { 
	case 1: 
		$im = @imagecreatefromgif($srcFile); 
		break; 
	case 2: 
		$im = @imagecreatefromjpeg($srcFile); 
		break; 
	case 3: 
		$im = @imagecreatefrompng($srcFile); 
		break; 
	} 

	$font_file = "source/SIMLI.TTF"; 
	#$str = iconv("GB2312","UTF-8",$str); 
	#
	$white=imagecolorallocatealpha($im,255,255,255,$alpha);

	imagettftext($im,15,0,$data[0]-200,$data[1]-20,$white,$font_file,$str); 

	imagejpeg($im,$path);

	imagedestroy($im);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
function makethumb($Filename,$srcFile,$dstFile,$action,$dstW,$dstH) { 

	if(file_exists($dstFile))
	{
		return TRUE;
	}
	$data = getimagesize($srcFile,$info); 
	switch ($data[2]) { 
	case 1: 
		$im = @imagecreatefromgif($srcFile); 
		break; 
	case 2: 
		$im = @imagecreatefromjpeg($srcFile); 
		break; 
	case 3: 
		$im = @imagecreatefrompng($srcFile); 
		break; 
	} 
	$srcW=$data[0]; 
	$srcH=$data[1]; 
	$dstX=0; 
	$dstY=0; 
	if ($srcW*$dstH>$srcH*$dstW) 
	{ 
		$fdstH=round($srcH*$dstW/$srcW); 
		$dstY=floor(($dstH-$fdstH)/2); 
		$fdstW=$dstW; 
	}else{ 
		$fdstW=round($srcW*$dstH/$srcH); 
		$dstX=floor(($dstW-$fdstW)/2); 
		$fdstH=$dstH; } 
		$ni=imagecreatetruecolor($dstW,$dstH); 
		$dstX=($dstX<0)?0:$dstX; 
		$dstY=($dstX<0)?0:$dstY; 
		$dstX=($dstX>($dstW/2))?floor($dstW/2):$dstX; 
		$dstY=($dstY>($dstH/2))?floor($dstH/2):$dstY; 
		$black = imagecolorallocate($ni, 255,255,255);
		imagefilledrectangle($ni,0,0,$dstW,$dstH,$black); 
		imagecopyresampled($ni,$im,$dstX,$dstY,0,0,$fdstW,$fdstH,$srcW,$srcH); 

		imagejpeg($ni,$dstFile);

		imagedestroy($im); 
		imagedestroy($ni); 
		return TRUE;
}


function wLog($name,$time,$action,$ip)
{
	$file="./log/log.xml";
	$date=date("Y-m-d H:i:s");

	$ip=$_SERVER['REMOTE_ADDR'];
	$name=$_SESSION['loginname'];
	if(!file_exists($file))
	{

		$fp=fopen($file,"w");
		$action_1="创建日志文件";
		$str="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Log><record>0</record><event><op>".$name."</op><time>".$date."</time><action>".$action_1."</action><ip>".$ip."</ip></event></Log>";
		fwrite($fp,$str);
		fclose($fp);
	}
	$str=file_get_contents($file);
	$records=substr_count($str,"<event>");
	$str=explode("<Log>",$str);
	$str_r=explode("</record>",$str[1]);
	$str[1]=$str_r[1];
	$insert="<record>".++$records."</record>"."<event><op>".$name."</op><time>".$date."</time><action><![CDATA[".$action."]]></action><ip>".$ip."</ip></event>";
	$str=$str[0]."<Log>".$insert.$str[1];

	$fp=fopen($file,"w");
	fwrite($fp,$str);
	fclose($fp);

}


function del_dir($dir,$deldir=false) 
{
	$dir=realpath($dir);
	$dh=@opendir($dir);
	if(!$dh) exit("文件目录无法打开,可能是因为文件不存在,或者权限不够!");
	while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				del_dir($fullpath,true);
			}
		}
	}

	closedir($dh);
	if($deldir)
	{
		if(rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}
	else
	{
		return true;
	}
} 


function mkdirs($path, $mode = 0777) //creates directory tree recursively 
{ 
	$dirs = explode('/',$path); 
	$pos = strrpos($path, "."); 
	if ($pos === false) { // note: three equal signs 
		// not found, means path ends in a dir not file 
		$subamount=0; 
	} 
	else { 
		$subamount=1; 
	} 

	for ($c=0;$c < count($dirs) - $subamount; $c++) { 
		$thispath=""; 
		for ($cc=0; $cc <= $c; $cc++) { 
			$thispath.=$dirs[$cc].'/'; 
		} 
		if (!file_exists($thispath)) { 
			//print "$thispath<br>"; 
			mkdir($thispath,$mode); 
		} 
	} 
}

function refrestSrot(){
	global $T_CAT;
	$logdir = 'log/sort.log';
	$sql=<<<SQL
	select * from $T_CAT order by cat_id;
SQL;
	$result = mysql_query($sql) or error_log(mysql_error());
	$arr = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		if(intval($row['cat_parent']) == 0){
			$arr[$row['cat_id']] = array('cname' => $row['cat_title'], 'ename' => $row['cat_name']);
		}else{
			$arr[$row['cat_parent']]['childs'][$row['cat_id']] = array('cname' => $row['cat_title'], 'ename' => $row['cat_name']);
		}
	}
	$str = var_export($arr, true);
	$str = "<?php\n\$categoryCache = " . $str .";\n?>";
	
	$ret = file_put_contents($logdir, $str);
	if($ret == FALSE){
		exit('日志文件无法写入，请检查log目录权限');
	}
	return true;
}
?>
