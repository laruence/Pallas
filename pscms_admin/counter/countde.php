<?

/*<script src="../count/count.php?id=1"></script>*/


	if(!isset($id))				//如果忘了写id值了设定默认值
	{
		$id=1;
	}

	$file="data/".$id.".php";	//记录数据的文件

	if(!file_exists($file))		//判断是否存在文件
	{
		//chmod("data/",0777);	//修改文件夹属性
		fopen($file,'w+');
	}

	//if(!is_writeable($file))	//判断文件是否可写
	//{
		//chmod($file,0777);		//修改文件属性
	//}

	$fo=fopen($file,"r");		//打开文件
	$fg=fgets($fo,10000);		//读取数据
	
	if($fg=='')$fg=0;

	//$fg++;

	$fo2=fopen($file,'w+');		//以可写方式打开文件
	fputs($fo2,$fg);

	$fg=sprintf("%06s",$fg);	//修改此处的 %06s 为 %08s 就可以把六位计数器改为8位计数器咯
	$mc=chunk_split($fg,1,'|');		//每隔一个字符插入一个|号
	$arr=explode('|',$mc);		//按|号切开，存成数组
	echo "muhang='';\n";

	for($i=0;$i<count($arr);$i++)
	{
		if($arr[$i]!='')
		{
			echo "muhang+='<img src=../counter/countimg/".$arr[$i].".png>';\n";
		}
	}

	echo "document.write(muhang);";	//输出

?>