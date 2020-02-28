function playSound(){
	if(navigator.appName == 'Netscape')
		document.embeds[0].run();
	else{
		document.embeds[0].play();
	}
} 
function Embed()
{
	document.write("<embed  src=\"./Media/alert.wav\" loop=\"false\" autostart=\"false\" width=\"0\" height=\"0\" mastersound></embed> ");
}


function showHint(msg){
	document.body.innerHTML +="<div  style='filter:Alpha(opacity=90);background:#EFEFEF; border:1px solid #333333; padding:0px; padding-top:0px; display:inline; z-index:100;  position:absolute;  left:175px;  top:75px; width: 218px; height:100px;' ><table width='100%' height='100%' style='padding:0px; margin:0px; ' ><tr><td  colspan='3' align='right' style='line-height:12px;' ><table width='100%' height='100%' border='0'  style='margin:0px; padding:0px;'> <tr><td align='left' valign='bottom'>提示</td><td align='right'><input type='button' class='button'  style='height:14px; width:14px; font-size:12px; padding:0px' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\" value='-'><input type='button' class='button'  style='height:14px; width:14px; font-size:12px; padding:0px' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\" value='?'onClick=\"alert('\\r * 点确定关闭窗口.')\"><input type='button' class='button'  style='height:14px; width:14px; font-size:12px; padding:0px' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\" value='×' onClick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';\"></td></tr></table></td></tr> <tr><td width='86' style='line-height:20px;' align='right'> </td><td width='178' align='left' style='line-height:20px;' valign='middle'>"+msg+"</td></tr><tr><td colspan='3' style='padding:5px;'  align='center'><input type='button' onClick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';\" value='确定' class='button' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\">  </td></tr></table></div>";
}
function MakeSure(url,msg)
{
	document.body.innerHTML +="<div  style='filter:Alpha(opacity=90);background:#EFEFEF; border:1px solid #333333; padding:0px; padding-top:0px; display:inline; z-index:100;  position:absolute;  left:175px;  top:75px; width: 218px; height: 100px;' ><table width='100%' height='100%' style='padding:0px; margin:0px; ' ><tr><td  colspan='3' align='right' style='line-height:12px;' ><table width='100%' height='100%' border='0'  style='margin:0px; padding:0px;'> <tr><td align='left' valign='bottom'>提示</td><td align='right'><input type='button' class='button'  style='height:14px; width:14px; font-size:12px; padding:0px' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\" value='-'><input type='button' class='button'  style='height:14px; width:14px; font-size:12px; padding:0px' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\" value='?'onClick=\"alert('\\r * 继续操作点确定，否则点取消.')\"><input type='button' class='button'  style='height:14px; width:14px; font-size:12px; padding:0px' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\" value='×' onClick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';\"></td></tr></table></td></tr> <tr><td width='86' style='line-height:20px;' align='right'><span class='STYLE2'>你确定要</span>:      </td><td width='178' align='left' style='line-height:20px;' valign='middle'>"+msg+"</td></tr><tr><td colspan='3' style='padding:5px;'  align='center'><input type='button'  onClick=\"window.location.href='"+ url +"';\" value='确定' class='button' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' onClick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';\" value='取消' class='button' onMouseOver=\"this.style.background='#cccccc';\" onMouseOut=\"this.style.background='#E9EAE6';\">  </td></tr></table></div>";
	return false;
}

drag=false;

function show_tips(title,author,date,cat)
{
	drag = true;
	obj=document.getElementById('tips');

	obj.style.left = window.event.x-10;
	obj.style.top = window.event.y+parseInt(document.body.scrollTop);
	text=document.getElementById('newstext');
	text.innerHTML="标题:"+title+"<br>栏目:"+cat+"<br>作者:"+author+"<br>时间:"+date;
	obj.style.display="inline";
}

function hide_tips()
{
	obj=document.getElementById('tips');
	obj.style.display="none";
	drag = false;
}

function move_tips()
{
	if(!drag) return;

	obj=document.getElementById('tips');
	obj.style.posLeft=window.event.x-10;
	obj.style.posTop= window.event.y+parseInt(document.body.scrollTop);
}
