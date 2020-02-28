<?php
require('session.inc');
if(empty($_SESSION['log']) || $_SESSION['log'] != true){
	echo "<script>window.location.replace('error.htm')</script>";
	die("没有登陆");
}
/*
 * 功能：数据备份/恢复文件简易方法
 *   以日期为单位，一天一个备份文件，以当天最后备份为准
 *   用提交表单的形式进行操作，
 *  其中$_POST["tbl_name"]为预备份表名称数组
 *      $_POST["sqlfile"]为预恢复数据文件的名称
 * 2005-02-25
 * kingerq AT msn.com
 */
require('news.php');

$dbdir = "./data/";
$dbdir = realpath($dbdir);
$dbdir = str_replace("\\","/",$dbdir)."/";
$txtname = array();

if(!is_writable($dbdir)){
	echo "对不起！指定的备份目录不可写！请修改权限";
	exit;
}

//op为一个隐形域，识别备份或者恢复
if($op == "backup")
{//备份数据
	//生成每个表的临时备份文件
	if(empty($t_name)){
		alert("你没有选择要备份的对象");
		echo "<script> window.location.replace('db_showtable.php');</script>";
		exit;
	}
	foreach( $t_name as $tbl){
		$txtname[] = $tbl.".txt";
		$sql = "SELECT * FROM `$tbl` INTO OUTFILE '".$dbdir.end($txtname)."'";
		if(!mysql_query($sql)) {
			alert("您没有MYSQL-FILE权限，无法使用此功能，请于您的空间管理员联系!");
			echo "<script> window.location.replace('db_showtable.php');</script>";
			die("权限错误!!");
		}; 
	}

	//将生成的临时备份文件合在一起
	$outfile = date("Y-m-d-H-i").".sql";
	if(file_exists($dbdir.$outfile)) 
		@ unlink($dbdir.$outfile);
	$fpr = fopen($dbdir.$outfile, "a");
	$flag=true;
	foreach($txtname as $txt)
	{
		if(file_exists($dbdir.$txt))
		{
			//读取临时备份文件
			$tdata = readfiles($dbdir.$txt);

			//生成备份文件
			$tbl = explode(".", $txt);
			$str = "`".$tbl[0]."`{{".$tdata."}}";
			if(fwrite($fpr, $str))
			{
				//  echo $tbl[0]."...写入 $outfile 成功！<br>\n";
			}else{
				//  echo $tbl[0]."...写入 $outfile 失败！<br>\n";
				$flag=false;
			}
			@unlink($dbdir.$txt);
		}
	}  
	if($flag) alert("备份数据到\"".$outfile."\"成功！");
	else alert("备份数据失败，请检查目录是否可写，文件是否已经存在！");
	fclose($fpr);
	echo "<script> window.location.href='db_showtable.php'</script>";
}


else if($op=="restore")
{//恢复数据

	if(empty($restorefile)){
		exit ("没有选择备份文件");
	}

	$tdata = readfiles($dbdir.$restorefile);

	preg_match_all("/`(.*)`\{\{(.*)\}\}/isU", $tdata, $data_ar);

	foreach($data_ar[1] as $k => $tt)
	{
		if(empty($data_ar[2][$k])) continue;
		$tfile = $dbdir.$tt.".txt";
		$fp = fopen($tfile, "wb");
		$data_ar[0][$k]=$data_ar[0][$k];//iconv("gbk","utf-8",$data_ar[0][$k]);
		if(fwrite($fp, $data_ar[2][$k])){
			//清空表
			$sql = "TRUNCATE TABLE `$tt`";
			mysql_query($sql);
			//mysql_query("set names 'utf8'") or die (mysql_error());
			//重新装入数据
			$sql = "LOAD DATA LOW_PRIORITY INFILE '".$dbdir.$tt.".txt"."' INTO TABLE `$tt`";
			if(mysql_query($sql)){
				fclose($fp);
				alert( $tt."表数据恢复成功"); echo "<script> window.location.replace('db_restore.php')</script>";
				unlink($dbdir.$tt.".txt");
			}else{
				alert( $tt."表数据恢复失败，请选择其他备份！"); echo "<script> window.location.replace('db_restore.php')</script>";
			}
		}

	}
	//echo $tdata;
	//print_r($data_ar);
	//exit;
}

else if($op=="del")
{
	@unlink($dbdir.$restorefile);
	alert ( $restorefile."删除成功");
	echo "<script> window.location.replace('db_restore.php');</script>";
}
/* 
 * 读取文件内容
 * 参数 $file 为文件名及完整路径
 * 返回文件内容
 */
function readfiles($file)
{
	$tdata = "";
	$fp = fopen($file, "r");
	while($data = fread($fp, filesize($file)))
	{
		$tdata .= $data;
	}
	fclose($fp);
	return $tdata;
}

?>
