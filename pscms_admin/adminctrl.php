<?php 
require('session.inc');
?>
<link href="style.css" rel="stylesheet" type="text/css">
<style>

body{
background:#ffffff;
}
</style>
<?php
if(isset($_SESSION['log']) && $_SESSION['log']==true) {

	if (isset($_POST['password']))
	{ 
		$fp=fopen("password.inc","r");
	if($fp)
	{
		$content=fread($fp,filesize("password.inc"));
		$content=str_replace($_SESSION["psd"],md5($_POST["password"]),$content);
		$fw=fopen("password.inc","w");
		fwrite($fw,$content);
		echo "修改完毕 如象再次修改,请重新登陆!";}
	else echo "无法读取密码文件"; 
	}
	else {?>
<br>
<br><fieldset style="width:300;height:150;border:1px dashed #ff9966; text-align:center" align="center" >
<legend style="border:0px dashed #ff9966;background-color:white;text-align:center;"> 
修改密码
</legend>  
<form action="<?php $PHP_SELF ?>" method="post">
输入新密码:<input type="text" maxlength="20" name=password height="20"><br><br>
&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置">

</form></fieldset>

<?php }}
else { echo "<script> location.href='error.htm';</script>" ;}
?>
