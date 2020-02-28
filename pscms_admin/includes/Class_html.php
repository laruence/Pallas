<? 
// 动态生成静态HTML页面的类
// 作者 laruence
// 最后更新时间 2007-04-08

if(!isset($__Class_html__))
{
 $__Class_html__=1;
 
 class PtH
 {
	 // var $srcFile=NULL;
	  var $dstFile=NULL;
	  var $contents=NULL;
	  var $reLoad=false;
	  
	  
	  function PtH($dFile,$reload=false)
	  {
		 $this->srcFile=$sFile;
		 $this->dstFile=$dFile;
		 $this->reLoad=$reload;
		 return true;
	  }
	 
	  function Start()
	  {
		  ob_start();
		  return;
	  }
		
	  function Build()
	  {
		$this->contents=ob_get_contents();
		if(!file_exists($this->dstFile)) $this->mkdirs($this->dstFile);
		$fp=fopen($this->dstFile,"wb") or die("静态生成时打开文件".$this->dstFile."时出错");
		fwrite($fp,$this->contents); #把HTML代码写入静态文件中！
		fclose($fp);
		
	  }
	  
	   function End()
	   {
			ob_end_clean();
			if($this->reLoad)
			echo "<script> window.location.reload();</script>";
			else
			echo "<script> window.location.replace('$this->dstFile');</script>";
			return true;
	   }
		function mkdirs($path, $mode = 0777) //creates directory tree recursively 
		{ 
			$dirs = explode('/',$path); 
			$pos = strrpos($path, "."); 
			if ($pos === false)
			 { // note: three equal signs  not found, means path ends in a dir not file 
				$subamount=0; 
			 } 
			else 
			{ 
				$subamount=1; 
			} 
			
			for ($c=0;$c < count($dirs) - $subamount; $c++) 
			{ 
				$thispath=""; 
				for ($cc=0; $cc <= $c; $cc++) 
				{ 
					$thispath.=$dirs[$cc].'/'; 
				} 
				if (!file_exists($thispath)) 
				{ //print "$thispath<br>"; 
					mkdir($thispath,$mode); 
				} 
			} //for
		}//mkdirs
		   
   }//class
}//if
   
?>