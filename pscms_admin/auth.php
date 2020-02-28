<?php 
// 作者：惠新宸
// 2006-05-18
//生成验证码图片 
header("content-type: image/png"); 
require('session.inc');
$_SESSION['authnum']="";
$im = imagecreate(50,20); //制定图片背景大小
$black = imagecolorallocate($im, 0,0,0); //设定三种颜色
$white = imagecolorallocate($im, 240,240,240); 
$gray = imagecolorallocate($im, 200,200,200); 
$blue = imagecolorallocate($im, 0,0,255);
imagefill($im,0,0,$gray); //采用区域填充法，设定（0,0）
$authnum=rand(1000,9999);
//将四位整数验证码绘入图片 
$_SESSION['authnum']=$authnum;
imagestring($im,4, 8, 3, $authnum, $black);
// 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 座标处（图像的左上角为 0, 0）。
//如果 font 是 1，2，3，4 或 5，则使用内置字体
for($i=0;$i<100;$i++) //加入干扰象素 
{ 
$randcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
} 
imagepng($im); 
imagedestroy($im); 
?>
