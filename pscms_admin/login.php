<?php 
require('session.inc');
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #3C3C3C;
}
-->
<!--
.style1 {color: #FF0000}
-->
</style>
<link href="images/lequn.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
drag  =  0 ; 
move  =  0;  
function  mouseUp()  
{  
drag=null;
move  =  0 ; 
}  
function  mouseDown() {  
dragObj=document.getElementById('auth');
clickleft  =  window.event.x  -  parseInt(dragObj.style.posLeft)  ;
clicktop  =  window.event.y  -  parseInt(dragObj.style.posTop)  ;
dragObj.style.zIndex  +=  1  ;
move  =  1  ;
}  

function  mouseMove(){  
if  (move)  {  
dragObj.style.posLeft  =  window.event.x  -  clickleft  ;
dragObj.style.posTop  =  window.event.y  -  clicktop  ;
 }  
}  


function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.65
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(parseInt(myV))||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('请以正确格式填写表单:\t\t\t\t\t\n\n'+myErr)}
   else { displayauth() ;}
   //document.MM_returnValue = (myErr=='');
 
}

function displayauth()
{
document.getElementById('auth').style.display="inline";
document.dl.auth_num.focus();
playSound() ;
}

function check_auth()
{
if(document.dl.auth_num.value!='')

{
 if(document.dl.auth_num.value>999)
   document.dl.submit();
   else alert('请以正确格式填写表单:\t\t\t\t\t\n\n * 请输入4位验证码!');

} 
else alert('请以正确格式填写表单:\t\t\t\t\t\n\n * 请输入验证码!');

}

function playSound() 
{ 　
   try
   {
   document.embeds[0].run();
   }
   catch(e)
   {
       try
	   {
	    document.embeds[0].play()  ;
	   }
	   catch(e)
	   {
	   
	   }
	   
   }
} 

var update=0;

function refreshauth()
{
javascipt:document.getElementById('authpic').src='auth.php?update='+update;
update++;
return false;
}
//-->
</script>

<title>PSCMS网站后台管理系统-LOGIN</title>
<style type="text/css">
<!--
.STYLE2 {
	color: #666666;
	font-family:"新宋体";
	font-size: 14px;
	font-weight: bold;
}
.button
{ border:1px #333333 solid ;
  font:"Times New Roman", Times, serif, "黑体";
  background:#E9EAE6;
}
-->
</style>
<body onLoad="javascript:document.forms[0].user.focus();" >

 <embed  src="./Media/alert.wav" loop="false" autostart="false" width="0" height="0" mastersound>
   </embed> 


<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">&nbsp;</td>
      </tr>
      <tr>
        <td><table width="600"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top">
			<form  action="<?php $PHP_SELF?>" method="post" name="dl" id="dl" onSubmit="YY_checkform('dl','user','#q','0','请填写用户名!','password','#q','0','请填写密码!');return (document.dl.auth_num.value!='')";>	
			  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><img src="images/dl_1.gif" width="600" height="285"></td>
                </tr>
                <tr>
				  <td valign="top">

<div style='position:relative;'>		
 <div id="auth" name="auth"  class="style1" style="background:url(images/dl_3.gif); border:1px solid #333333; padding:0px; padding-top:0px; display:none; z-index:100;  position:absolute;  left:175px;  top:10px; width: 218px; height: 90px;" onMouseUp="mouseUp()"      onmousedown="mouseDown()"   onMouseOut="move=0;"  onmousemove="mouseMove()">
<table width="100%" height="100%"  style="padding:0px; margin:0px; " >
<tr>
<td  colspan="3" align="right" style="line-height:12px;" >
<table width="100%" height="100%" border="0"  style="margin:0px; padding:0px; "> 
<tr>
<td align="left" valign="bottom">
请输入验证码</td>
<td align="right">
<input type="button" class="button"  style="height:14px; width:14px; font-size:12px; padding:0px" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='#E9EAE6';" value="-">
<input type="button" class="button"  style="height:14px; width:14px; font-size:12px; padding:0px" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='#E9EAE6';" value="?" onClick="alert('\r * 输入4位右边图片中显示的数字 \r\n\r\n * 如果看不清楚，可以点击图片刷新验证码!')">
<input type="button" class="button"  style="height:14px; width:14px; font-size:12px; padding:0px" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='#E9EAE6';" value="×" onClick="document.getElementById('auth').style.display='none';"></td>
</tr>
</table></td>
</tr> 
<tr>
<td width="116" style="line-height:20px;" align="right">
  <span class="STYLE2">验证码</span>:    
  <input type="text" name="auth_num"  id="auth_num" maxlength="4" size="4"  value="" style=" background-color:transparent; border:1px #000000 solid; color:#000000;"></td>
	<td width="88" align="left" style="line-height:20px;" valign="middle"> 
    &nbsp;&nbsp;<img  id="authpic" src="auth.php" style=" cursor: pointer;"  alt="点击刷新验证码图片" onClick="refreshauth();"></td>
</tr>
	<tr>
	<td colspan="3" style="padding:5px;"  align="center">
  <input type="button"  onClick="check_auth();" value="确定" class="button" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='#E9EAE6';">&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="button" onClick="document.dl.auth_num.value='';" value="重填" class="button" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='#E9EAE6';">  </td></tr></table>
</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="62%" valign="top" background="images/dl_2.gif">

<?php 
$user = @$_POST['user'];
$psword = @$_POST['password'];

if (empty($user)||empty($psword)){
?>					  
					  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="63%" height="23">&nbsp;</td>
                            <td width="37%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="20"><div align="right"></div></td>
                            <td><div align="left">
                                <input name="user" type="text" class="font12" id="user" size="18">
							
                            </div></td>
                          </tr>
                          <tr>
                            <td height="25"><div align="right"></div></td>
                            <td><div align="left">
                              <input name="password" type="password" class="font12" id="password" size="19">
</div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center" class="style1">
                              <div align="right">
                                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="94%"><div align="right"> 
                                       　 </div></td>
                                    <td width="6%">&nbsp;</td>
                                  </tr>
                                </table>
                                </div>
                            </div></td>
                            </tr>
                      </table>

<?php }
else if (0&& $auth_num != $_SESSION['authnum'])
{?>

 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="63%" height="23">&nbsp;</td>
                            <td width="37%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="20"><div align="right"></div></td>
                            <td><div align="left">
                                <input name="user" type="text" class="font12" id="user" size="18">
                            </div></td>
                          </tr>
                          <tr>
                            <td height="25"><div align="right"></div></td>
                            <td><div align="left">
                              <input name="password" type="password" class="font12" id="password" size="19">
</div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center" class="style1">
                              <div align="right">
                                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="94%"><div align="right">验证码错误！ 
                                       　 </div></td>
                                    <td width="6%">&nbsp;</td>
                                  </tr>
                                </table>
                                </div>
                            </div></td>
                            </tr>
                      </table>


<?php 
}
else{
require('news.php');
$sql="select * from $T_USERS where ad_name='$user' and ad_lock!=1";
$result=mysql_query($sql) or die (mysql_error());
$total=mysql_num_rows($result);
if($total)
{
$psword=$psword.mysql_result($result,0,'ad_scrt');
$psword=md5($psword);
if($psword==mysql_result($result,0,'ad_pswd'))
{
session_register($log,$loginid,$loginname,$grad);
$_SESSION['log']=true;
$_SESSION['loginid']=mysql_result($result,0,'ad_id');
$_SESSION['loginname']=mysql_result($result,0,'ad_name');
$_SESSION['grad']=mysql_result($result,0,'ad_grad');
$ip=$_SERVER['REMOTE_ADDR'];
$action="登入后台";

wLog($_SESSION['loginname'],$date,$action,$ip);
$uid=mysql_result($result,0,'ad_id');

$lasttime=date('YmdHis');
$sql="update $T_USERS set ad_lastip=ad_nowip,ad_lasttime=ad_nowtime where ad_id=$uid";
$result=mysql_query($sql) or die (mysql_error());
$sql="update $T_USERS set ad_logintimes=ad_logintimes+1,ad_nowip='$ip',ad_nowtime=$lasttime where ad_id=$uid";
$result=mysql_query($sql) or die (mysql_error());
echo "<script language='javascript'>";
echo " parent.location.href='index.php';";
//echo " parent.localtion.Reload();"
echo "</script>";
}
else{?>	
 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td width="63%" height="23">&nbsp;</td>
          <td width="37%">&nbsp;</td>
                  </tr>
                          <tr>
                            <td height="20"><div align="right"></div></td>
                            <td><div align="left">
                                <input name="user" type="text" class="font12" id="user" size="18">
                            </div></td>
                          </tr>
                          <tr>
                            <td height="25"><div align="right"></div></td>
                            <td><div align="left">
                              <input name="password" type="password" class="font12" id="password" size="19">
</div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center" class="style1">
                              <div align="right">
                                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="94%"><div align="right">密码错误！ 
                                       　 </div></td>
                                    <td width="6%">&nbsp;</td>
                                  </tr>
                                </table>
                                </div>
                            </div></td>
                            </tr>
                      </table>
<?php }
}
else {
?>
					  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="63%" height="23">&nbsp;</td>
                            <td width="37%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="20"><div align="right"></div></td>
                            <td><div align="left">
                                <input name="user" type="text" class="font12" id="user" size="18">
                            </div></td>
                          </tr>
                          <tr>
                            <td height="25"><div align="right"></div></td>
                            <td><div align="left">
                              <input name="password" type="password" class="font12" id="password" size="19">
</div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center" class="style1">
                              <div align="right">
                                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="94%"><div align="right">用户名错误！ 
                                       　 </div></td>
                                    <td width="6%">&nbsp;</td>
                                  </tr>
                                </table>
                                </div>
                            </div></td>
                            </tr>
                      </table>
<?php }
}?>					  					  				  
					  </td>
                      <td width="38%" height="95" valign="top" background="images/dl_3.gif"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="11%" height="23">&nbsp;</td>
                          <td width="89%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div align="left">
                            <input name="imageField" type="image" src="images/dl_5.gif" width="80" height="44" border="0">
                          </div></td>
                        </tr>
					  </table>
</div>
</td>
                    </tr>
				  </table>
			</td>
                </tr>
                <tr>
                  <td valign="top"><img src="images/dl_4.gif" width="600" height="120" border="0" usemap="#Map"></td>
                </tr>
              </table>
            </form></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<map name="Map">
  <area shape="circle" coords="505,48,37" href="javascript:history.back()">
  <area shape="rect" coords="212,68,437,90" href="contact.htm" target="_blank">
</map>
<div style='position:absolute;bottom:0px;width:100%'>
<TABLE width="100%" border=1px bgcolor="#CCCCCC" align=center  cellPadding=0 cellSpacing=0 class="lequn">
      <TBODY>
        <TR>
          <TD   align="right"  >
      <td colspan="2">  <div align="center"><span class="STYLE14">版权声明</span>：
	  <A href="#" target=_blank>PHP Pallas CMS</A>&nbsp;是由<A href="mailto:laruence@yahoo.com.cn"><strong>Laruence</strong></A>(惠新宸)开发的遵循GNU自由软件规范的CMS,
      任何单位和个人在保留版权信息的情况下,可以随意复制和修改本系统.</div>
		</TD>
        </TR>
      </TBODY>
    </TABLE>
</div>
</body>
</html>
