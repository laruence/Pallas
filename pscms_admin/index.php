<?php 
require("session.inc");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PSCMS网站后台管理系统</title>
<style>
body{
margin:0px;
}
</style>
<script>
if(top.location!=self.location) top.location=self.location;
</script>
<?php if(isset($_SESSION['log']) && $_SESSION['log']==true) {?>
<body scroll=no >
<table border="0" cellPadding="0" cellSpacing="0" height="100%" width="100%">
  <tr>
	<tr>
	  <td  width="100%" height="100%">
	<iframe frameBorder="0"  scrolling="yes"   src="main.php" style=" height:100%;z-index:1;" width="100%" >
	</iframe>
	  </td>
	</tr>
<tr>
	<td height="20"><iframe frameBorder="0" scrolling="no" src="bottom.html" style="HEIGHT: 100%; VISIBILITY: inherit; WIDTH: 100%; Z-INDEX: 1">
	</iframe>
		   </td>
		</tr>
	</td>
  </tr>
</table>

</body>
<?php 
}else{
?> 
	<script>
	window.location.replace('login.php');
	</script>
<?php 
}
?>
</html>
