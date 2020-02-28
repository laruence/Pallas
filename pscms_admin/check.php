<?php
require_once('news.php');
$user=trim($_GET['user']);
if(isset($user))
{
$sql="select * from $T_USERS where ad_name='$user'";
$result=mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($result))
	{
      echo  1;
	 }
	 else
	{ echo  0;}
}


?>
