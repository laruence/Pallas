<?php
//自动生成图片缩略图 
// 本函数从源文件取出图象，设定成指定大小，并输出到目的文件 
// 源文件格式：gif,jpg,jpe,jpeg,png 
// 目的文件格式：jpg 
// 参数说明: 
// $srcFile 源文件 
// $dstFile 目标文件 
// $dstW 目标图象宽度 
// $dstH 目标图象高度 

function makethumb($Filename,$srcFile,$dstFile,$action,$dstW,$dstH) { 
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
		if( $action == create )
		{//如果是创建，则输出到硬盘

			if(!file_exists($dstFile))
			{
				imagejpeg($ni,$dstFile);
			}
		}
		else
		{
			header("Content-type:image/jpeg");
			imagejpeg($ni);
		}
		imagedestroy($im); 
		imagedestroy($ni); 
}
$srcFile=$_GET['image'];
$Filename=$srcFile;
$srcFile="../uploads/".$srcFile;
$dstW=$_GET['width'];
$dstH=$_GET['height'];
$action=$_GET['action'];
$dstFile=explode(".",$Filename);
$dstFile=$dstFile[0];
$dstFile="../uploads/thumb_".$dstFile.".jpg";
makethumb($Filename,$srcFile,$dstFile,$action,$dstW,$dstH);
?>
