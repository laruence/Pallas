<?php 
//require('../pscms_admin/config.php');
switch($glo_MYSQL_Client){
case MYSQL:
{
	$db = mysql_connect($db_host,$db_username,$db_password) or die(mysql_error()); 
	mysql_select_db($db_data_base);
	$T_NEWS=$db_data_base."_news";
	$T_CMT=$db_data_base."_cmt";
	$T_VOTE=$db_data_base."_vote";
	$T_CAT=$db_data_base."_cat";
	$T_USERS=$db_data_base."_adminers";
	$T_GBOOK=$db_data_base."_gbook";
	$T_MBER =$db_data_base."_members";
	if(1 || $glo_Con_GBK){
		$sql_type="SET NAMES utf8";
		$typeresult=mysql_query($sql_type);
	}
	break;
}
case MYSQLI:
	{ 
		@ $db=new mysqli($db_host,$db_username,$db_password,$db_data_base); 
		$T_NEWS=$db_data_base."_news";
		$T_CMT=$db_data_base."_cmt";
		$T_VOTE=$db_data_base."_vote";
		$T_CAT=$db_data_base."_cat";
		$T_USERS=$db_data_base."_adminers";
		$T_GBOOK=$db_data_base."_gbook";
		$T_MBER =$db_data_base."_members";
		if( 1 || $glo_Con_GBK){
			$sql_type="SET NAMES utf-8";
			$typeresult=$db->query($sql_type) or die ($db->error);
		}
		break;
	}
	default:
		break;
}
//require_once('pscms_admin/common.php');
?>
