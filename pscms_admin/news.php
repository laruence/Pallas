<?php
require('config.php');
require('common.php');
$T_NEWS=$db_data_base."_news";
$T_CMT=$db_data_base."_cmt";
$T_VOTE=$db_data_base."_vote";
$T_CAT=$db_data_base."_cat";
$T_USERS=$db_data_base."_adminers";
$T_GBOOK=$db_data_base."_gbook";
$T_MBER =$db_data_base."_members";
$db = mysql_connect($db_host,$db_username,$db_password); 
mysql_select_db($db_data_base); 
if(1 || $glo_Con_GBK) {
	$sql_type="SET NAMES utf8";
	$typeresult=mysql_query($sql_type) or die (mysql_error());
}
?>
