var http_request = false;
String.prototype.Trim = function(){return   this.replace(/(^\s+|\s+$)/g,"")}   

function send_request(url,method) 
{//初始化、指定处理函数、发送请求的函数
	http_request = false;
	//开始初始化XMLHttpRequest对象
	if(window.XMLHttpRequest) { //Mozilla 浏览器
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {//设置MiME类别
			http_request.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject) { // IE浏览器
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) { // 异常，创建对象实例失败
		window.alert("不能创建XMLHttpRequest对象实例.");
		return false;
	}

	http_request.onreadystatechange = method;

	// 确定发送请求的方式和URL以及是否同步执行下段代码
	http_request.open("GET", url, true);
	http_request.send(null);
}



function processRequest1(catid){
	//操作函数1,调入一级menu
	if (http_request.readyState == 4) { // 判断对象状态
		if(http_request.status == 200)
		{ // 信息已经成功返回，开始处理信息
			addOptionGroup("catid", http_request.responseText, catid);
			document.getElementById("catid").disabled=false;
			document.getElementById("catid").options[0].innerHTML="请选择栏目";
		} 
		else {//页面不正常

			alert("您所请求的页面有异常。");
		}

	}
	else 
	{//只要未读取完成
		document.getElementById("catid").disabled=true;
		document.getElementById("catid").options[0].innerHTML="正在读取数据中……";
	}
}


function processRequest2(specid) 
{
	if (http_request.readyState == 4) 
	{ // 判断对象状态
		if (http_request.status == 200){
			if(http_request.responseText.length>1)
			{
				addOptionGroup("specid", http_request.responseText, specid);
				document.getElementById("specid").disabled=false;
			}else{
				document.getElementById("specid").value = 0;
			}

			document.getElementById("specid").options[0].innerHTML="请选择分类";
		} 
		else { //页面不正常
			alert("您所请求的页面有异常。");
		}
	}else {//只要未读取完成
		document.getElementById("specid").disabled=true;
		document.getElementById("specid").options[0].innerHTML="正在读取数据中……";
	}
}



function loadcatid(catid){
	catid = catid || 0;
	send_request("get_cat.php?action=top", function(){ processRequest1(catid); });//服务端处理程序,操作函数
}


function loadspecid(cat_id, specid){
	if(!cat_id || cat_id == 0) 
		return;
	send_request("get_cat.php?action=second&id=" + cat_id, function(){ processRequest2(specid); });
}



function addOption(objSelectNow,txt,val)
{
	/// 使用W3C标准语法为SELECT添加Option
	var objOption = document.createElement("OPTION");
	objOption.text= txt;
	objOption.value=val;
	objSelectNow.options.add(objOption);
}


function addOptionGroup(selectId,optGroupString, val){
	var optGroup = optGroupString.split(",");

	var objSelectNow = document.getElementById(selectId);
	objSelectNow.length = 1;
	/// 成组添加Options
	for (i=0; i<optGroup.length; i++){
		opt = optGroup[i].split("|");
		//if(i>0) opt[0]=" "+opt[0];
		addOption(objSelectNow, opt[0],opt[1]);
	}
	if(val)
		objSelectNow.value = val;
}

