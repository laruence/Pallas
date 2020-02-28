<?php 
require('session.inc');
if($action==vote)
{ 
  
  if($_COOKIE["1vote"]==$votetitle) 
   {
	echo "<script>alert('您已经投过票了，请不要重复投票');window.close();</script>";
	exit;
    }
   require('news.php');
   $sql="select * from $T_VOTE where v_title='$votetitle'";
   $result=mysql_query($sql) or die (mysql_error());
   if(mysql_result($result,0,'v_type')==0)
   {
    $sql="update $T_VOTE set v_voted=v_voted+1 where v_id=$voteoption";
	$result=mysql_query($sql) or die (mysql_error());
    setcookie("1vote",$votetitle,time()+3600);
    echo "<script>alert('投票成功！');location.href='voteview.php?view=result&vtitle=$votetitle';</script>";
   }
   else
   {
   $num=count($voteoption);
   $j=0;
   while($j<$num)
    {
	 $sql="update $T_VOTE set v_voted=v_voted+1 where v_id=$voteoption[$j]";
	 $result=mysql_query($sql) or die (mysql_error());  
	 $j++;
	 }
	 setcookie("1vote",$votetitle,time()+3600);
     echo "<script>alert('投票成功！');location.href='voteview.php?view=result&vtitle=$votetitle';</script>"; }
}
?><html>
<head>
<title>投票</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="style.css" rel="stylesheet" type="text/css">
<body  style="background:#FFFFFF ">
<?php if($view==result)

{  require('news.php');
   $sql="select * from $T_VOTE where v_title='$vtitle' order by v_id ";
   $result=mysql_query($sql) or die (mysql_error());
   $total=mysql_num_rows($result);
   $i=0;
   while($rows=mysql_fetch_array($result,MYSQL_BOTH))
   {  
      
      $title=$rows['v_title'];
	  $start=substr($rows['v_fromtime'],0,10);
	  $end=substr($rows['v_totime'],0,10);
	  $vote[$i][content]=$rows['v_content'];
	  $vote[$i][voted]=$rows['v_voted'];
	  $i++;}
	  
   $i=0;
  $totalvote=0;
	while($i<$total) 
	{
	  $totalvote=$totalvote+$vote[$i][voted];
      $i++;
    }
	$i=0;
   while($i<$total) 
	{
	   $vote[$i][percent]=$vote[$i][voted]/$totalvote*100;
       $i++;
    }
	
?>

<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#F3F3F3">
  <tr align="center" bgcolor="#F3F3F3">
    <td colspan="3"><strong><?php echo $title;?></strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="200" height="20" align="center">投票总数: <font color="red"><?php echo $totalvote;?></font></td>
    <td width="50">&nbsp;</td>
    <td width="360">起始日期: <font color="red"><?php echo $start;?></font>&nbsp;&nbsp;&nbsp;&nbsp;截止日期: <font color="red"><?php echo $end;?></font></td>
  </tr>
  <tr align="center" bgcolor="#F3F3F3">
    <td height="20"><b>投票选项(投票总数)</b></td>
    <td><b>百分比</b></td>
    <td><b>柱状图</b></td>
  </tr>
 
<?php $i=$total-1; while($i>=0) { ?>
  <tr bgcolor="#FFFFFF">
    <td height="20">&nbsp;<?php echo $vote[$i][content] ?>(<font color="red"><?php echo $vote[$i][voted]?></font>)</td>
    <td align="center"><?php echo sprintf("%01.2f",$vote[$i][percent]);?>%</td>
    <td>
<table cellpadding="0" cellspacing="0" border="0" width="360" bgcolor="#e1e1e1">
  <tr>
    <td height="20" width="<?php echo $vote[$i][percent]?>%" bgcolor="#999999"></td>
    <td height="20" width="<?php echo 100-$vote[$i][percent]?>%"></td>
  </tr>
</table>
    </td>
  </tr>
<?php $i--; } ?>

 
</table>
<?php 
} 
else
{
require('news.php');
	$sql="select * from $T_VOTE where v_title=(select v_title from $T_VOTE order by v_id desc limit 0,1) order by v_id";
	$result=mysql_query($sql) or die (mysql_error());
	$total=$num=mysql_num_rows($result);
	if($num)
	{
	
	for($i=0;$i<$num;$i++)
	{ $rows[$i][v_title]=mysql_result($result,$i,"v_title");
	  $rows[$i][v_type]=mysql_result($result,$i,"v_type");
	  $rows[$i][v_content]=mysql_result($result,$i,"v_content");
	  $rows[$i][id]=mysql_result($result,$i,"v_id");
	}
	
	?>
<script>
function myform_submit(){
         var groups=<?php=$total?>; 
         for (i=0; i<groups; i++){
             if(myform.voteoption[i].checked){
                 return true;
             }
         }
         alert("对不起，您没有选择选项！");
         return false;
}
function goview(vtitle)
{
window.open("voteview.php?view=result&vtitle="+vtitle);
}
</script>
<table align="center" cellpadding="2" cellspacing="1" border="0"   bgcolor="#F3F3F3">
  <tr>
    <td  align="center" height="25" valign="bottom" bgcolor="#FFFFFF"><strong><?php echo $rows[1][v_title];?></strong></td>
  </tr>
  <form method="post" name="myform" action="?votetitle=<?php=$rows[1][v_title]?>&action=vote" target="_blank" onSubmit="return myform_submit();">
<?php 
  if($rows[1][v_type]==1)
  { while($total)
  { ?>
  <tr>
   <td  bgcolor="#FFFFFF"onMouseOut="this.style.backgroundColor='#FFFFFF'" onMouseOver="this.style.backgroundColor='#F3F3F3'">
  <input type="checkbox" name="voteoption[]" id="voteoption" value="<?php=$rows[$total-1][id]?>" style="border:0"> <?php=$rows[$total-1][v_content]?>
  </td>
  </tr>
 <?php $total--;}}
 else
 {while($total)
  { ?>
  <tr>
  <td bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#FFFFFF'" onMouseOver="this.style.backgroundColor='#F3F3F3'">
  <input type="radio" name="voteoption" id="voteoption" value="<?php=$rows[$total-1][id]?>" style="border:0"> <?php=$rows[$total-1][v_content]?></td>
  </tr>
 <?php $total--; }
   }
  ?>

  <tr>
    <td align="center" bgcolor="#FFFFFF">
              <input type="submit" value="投票" name="submit">
              <input type="button" value="查看结果" name="result" onClick="goview('<?php=$rows[1][v_title]?>')">
       </td>
  </tr>
  </form>
</table>
<?php } } ?>
</body>
</html>
