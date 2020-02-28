<?php 
require("session.inc");
include_once ('config.php');
switch($glo_language)
{
case 'zh_cn':
  require_once('languages/lang_zh_cn.php');
case 'eng':
  require_once('languages/lang_eng.php');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=uft-8">
<title><?php echo $lang['h_title']?></title>
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
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #FF3300;
}
a:active {
	text-decoration: none;
}
.style2 {
	color: #000000;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<link href="images/lequn.css" rel="stylesheet" type="text/css">
<link href="source/Left_menu.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style11 {font-size: 12px; }
.style13 {font-size: 14px}
.style21 {color: #FF3300}
-->
</style>
<SCRIPT src="source/inc_common.js" 
type=text/javascript>
</SCRIPT>
</head>

<?php if(isset($_SESSION['log']) && $_SESSION['log']==true) {?>
<body>
<table width="100%" height="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD width="15%" bgColor=#818181><IMG 
            src="images/logo.gif" ></TD>
            <TD width="85%" 
          height=132 background="images/banner.jpg"></TD>
          </TR>
        </TBODY>
      </TABLE>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      </table>
    </div></td>
  </tr>
  <tr>
    <td height="100%"><div align="center">
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="15%" valign="top" height="100%"  bgcolor="#DEDEDE">
<div id="PARENT">
<ul id="nav">
<li><a href="../"   target="_blank"><?php echo $lang['home']?></a></li>
<li><a href="home.php"   target="mainwin"><?php echo $lang['homeset']?></a></li>

<li><a href="cache_op.php" target="mainwin"><?php echo $lang['opcache']?></a></li>
<li><a href="#Menu=ChildMenu2" onclick="DoMenu('ChildMenu2')"><?php echo $lang['news_man']?></a>
	 <ul id="ChildMenu2" class="collapsed">
	 <li><a href="news_add.php" target="mainwin" ><?php echo $lang['news_add']?></a></li>
	 <li><a href="news_man.php?delete=yes" target="mainwin"><?php echo $lang['news_man']?></a></li>
</li>	 </ul>
<li><a href="#Menu=ChildMenu3" onclick="DoMenu('ChildMenu3')"><?php echo $lang['sort_man']?></a>
 	<ul id="ChildMenu3" class="collapsed">
 	<li><a href="sort_man.php?action=add" target="mainwin"><?php echo $lang['sort_add']?></a></li>
 	<li><a href="sort_man.php?action=manage" target="mainwin"><?php echo $lang['sort_man']?></a></li>
</li>	</ul>

<li><a href="news_man.php?delete=yes&type=comment" target="mainwin"><?php echo $lang['cmt_man']?></a></li>
<li><a href="gbook_man.php" target="mainwin"><?php echo $lang['gbook_man']?></a></li>
<li><a href="#Menu=ChildMenu4" onclick="DoMenu('ChildMenu4')"><?php echo $lang['vote_man']?></a>
	 <ul id="ChildMenu4" class="collapsed">
	 <li><a href="vote_man.php?action=add" target="mainwin"><?php echo $lang['vote_add']?></a></li>
	 <li><a href="vote_man.php?action=manage" target="mainwin"><?php echo $lang['vote_man']?></a></li>
</li>	</ul>
<li><a href="member_man.php" target="mainwin"><?php echo $lang['meber_man']?></a></li>
<li><a href="#Menu=ChildMenu5" onclick="DoMenu('ChildMenu5')"><?php echo $lang['admin_man']?></a>
 	<ul id="ChildMenu5" class="collapsed">
 	<li><a href="user_man.php?action=add" target="mainwin"><?php echo $lang['meber_add']?></a></li>
	 <li><a href="user_man.php?action=view" target="mainwin"><?php echo $lang['admin_man']?></a></li>
	 <li><a href="user_man.php?action=chgpw" target="mainwin"><?php echo $lang['meber_chpw']?></a></li>
</li>	
    </ul>
<li><a href="log.php" target="mainwin"><?php echo $lang['man_log']?></a></li>
<li><a href="#Menu=ChildMenu6" onclick="DoMenu('ChildMenu6')"><?php echo $lang['data_man']?></a>
 	<ul id="ChildMenu6" class="collapsed">
 	<li><a href="db_showtable.php" target="mainwin"><?php echo $lang['data_res']?></a></li>
	 <li><a href="db_restore.php" target="mainwin"><?php echo $lang['data_rec']?></a></li>
</li>	
    </ul>


<li><a href="info.php" target="mainwin"><?php echo $lang['server']?></a></li>
<li><a href="contact.htm" target="mainwin"><?php echo $lang['contact']?></a></li>
<li><a href="logout.php" target="mainwin"><?php echo $lang['logout']?></a></li>

</ul>
</div>

<script type=text/javascript><!--
var LastLeftID = "";

function menuFix() {
 var obj = document.getElementById("nav").getElementsByTagName("li");
 
 for (var i=0; i<obj.length; i++) {
  obj[i].onmouseover=function() {
   this.className+=(this.className.length>0? " ": "") + "sfhover";
  }
  obj[i].onMouseDown=function() {
   this.className+=(this.className.length>0? " ": "") + "sfhover";
  }
  obj[i].onMouseUp=function() {
   this.className+=(this.className.length>0? " ": "") + "sfhover";
  }
  obj[i].onmouseout=function() {
   this.className=this.className.replace(new RegExp("( ?|^)sfhover\\b"), "");
  }
 }
}

function DoMenu(emid)
{
 var obj = document.getElementById(emid); 
 obj.className = (obj.className.toLowerCase() == "expanded"?"collapsed":"expanded");
 if((LastLeftID!="")&&(emid!=LastLeftID)) //关闭上一个Menu
 {
  document.getElementById(LastLeftID).className = "collapsed";
 }
 LastLeftID = emid;
}

function GetMenuID()
{

 var MenuID="";
 var _paramStr = new String(window.location.href);

 var _sharpPos = _paramStr.indexOf("#");
 
 if (_sharpPos >= 0 && _sharpPos < _paramStr.length - 1)
 {
  _paramStr = _paramStr.substring(_sharpPos + 1, _paramStr.length);
 }
 else
 {
  _paramStr = "";
 }
 
 if (_paramStr.length > 0)
 {
  var _paramArr = _paramStr.split("&");
  if (_paramArr.length>0)
  {
   var _paramKeyVal = _paramArr[0].split("=");
   if (_paramKeyVal.length>0)
   {
    MenuID = _paramKeyVal[1];
   }
  }
  /*
  if (_paramArr.length>0)
  {
   var _arr = new Array(_paramArr.length);
  }
  
  //取所有#后面的，菜单只需用到Menu
  //for (var i = 0; i < _paramArr.length; i++)
  {
   var _paramKeyVal = _paramArr[i].split('=');
   
   if (_paramKeyVal.length>0)
   {
    _arr[_paramKeyVal[0]] = _paramKeyVal[1];
   }  
  }
  */
 }
 
 if(MenuID!="")
 {
  DoMenu(MenuID)
 }
}

GetMenuID(); //*这两个function的顺序要注意一下，不然在Firefox里GetMenuID()不起效果
menuFix();
--></script>		 
            </td>
          <td valign="top">
			  <DIV id=mainContent >        
                 <iframe id="mainwin" name="mainwin" allowtransparency="true" scrolling="no" style="border-left-width:0px; border-left-color:#FFFFFF; border-left-style:solid; border-top-width:0px; border-top-color:#FFFFFF; border-top-style:solid; z-index:auto"src="contact.htm" onload="this.style.height=(parseInt(window.frames[0].document.body.scrollHeight)>377?parseInt(window.frames[0].document.body.scrollHeight)+'px':'377px');" width="100%"  frameborder="0"></iframe>
              </DIV>
		  </td>
        </tr>
      </table>
    </div></td>
  </tr>
 
</table>
</body>
<?php }else{?> 
<script>
window.location.replace('login.php');
</script>
<?php }?>
</html>
