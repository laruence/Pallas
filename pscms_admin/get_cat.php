<?php 
header("Content-type:application/json;charset=utf-8");
//加入头，防止乱码
//$referUrl=$_SERVER['HTTP_REFERER'];//取得上一页面地址
//$referHost=$_SERVER['HTTP_HOST'];//取得当前主机名
//$referFile=explode("/",$referUrl);//取得上一前面的主机名$referFile[2]
//if($referFile[2]!=$referHost)//如果上一页面与本服务端程序不在同一主机则禁止执行
//{
//exit();
//}

require('news.php');
$action=$_GET["action"];

if($action=="top"||$action=="")
{//action为province时进行以下操作，输出省
	$sql="select * from $T_CAT where cat_parent=0";
	$result=mysql_query($sql) or die (mysql_error());

	$aryTree=NULL;

	while( $row=mysql_fetch_array($result,MYSQL_BOTH))
	{
		$aryTree[]=$row['cat_title']."|".$row['cat_id'];
	}

	//var_dump($aryTree);
	$menuStr=NULL;

	for($i=0;$i<count($aryTree);++$i)
	{
		$menuStr.=$aryTree[$i].",";
	}
	$pattern=",$";

	$menuStr=ereg_replace($pattern,NULL,$menuStr);

	echo trim($menuStr);

}
else if($action=="second")
{
	$id=$_GET['id'];
	if($id==NULL) die("出错 ");

	$sql="select * from $T_CAT where cat_parent=$id";

	$result=mysql_query($sql) or die (mysql_error());

	$aryTree=NULL;

	while( $row=mysql_fetch_array($result,MYSQL_BOTH))
	{
		$aryTree[]=$row['cat_title']."|".$row['cat_id'];
	}

	$menuStr=NULL;

	for($i=0;$i<count($aryTree);++$i)
	{
		$menuStr.=$aryTree[$i].",";
	}
	$pattern=",$";

	$menuStr=ereg_replace($pattern,NULL,$menuStr);

	echo trim($menuStr);


}
else if($action=="district"){
	//否则为district，输出省市
	$id=$_GET["id"];
	$id1=$_GET["id1"];
	echo $province[$id][0].$province[$id][$id1];
}
else
{//否则报错
	echo "程序出错";
	exit();
}
?>
