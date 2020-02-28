<?php
require("includes/Gvar.php");
require("log/sort.log");
$db_host="localhost";
$db_username="dxcstorecn";
$db_password="54WCvj";
$db_data_base="dbdxcstorecn";
$glo_web_path="/";
$glo_web_descript="没什么";
$glo_web_keywords="lareunce";
$glo_web_name="网上月饼专卖店";
$glo_allowedext="jpg|bmp|gif|jpeg|ppt|swf|doc|rar|zip|pdf|caj|png|mp3|rm|mpeg|avi|rmvb";//容许上传的文件，最好不要添加BMP文件，体积大，并且可能会有未知的错误发生
$glo_smtp_password="";
$glo_smtp_server="";
$glo_smtp_username="";
$glo_MYSQL_Client = MYSQL;//使用的MYSQL连接方式MYSQL(mysql) 或者 MYSQLI(mysqli);
$glo_Con_GBK=_NO_;//是否校正链接字符集为GBK;_NO_为不校正
$glo_language="zh_cn";//zh_cn简体中文  eng英文
$glo_reg_pass=1;
$glo_reg_permit="当你注册用户时，表示您已经同意遵守本规章。 


	欢迎您加入本站点参加交流和讨论，本站点为公共论坛，为维护网上公共秩序和社会稳定，请您自觉遵守以下条款： 



	一、不得利用本站危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益，不得利用本站制作、复制和传播下列信息：

	　（一）煽动抗拒、破坏宪法和法律、行政法规实施的；

	　（二）煽动颠覆国家政权，推翻社会主义制度的；

	　（三）煽动分裂国家、破坏国家统一的；

	　（四）煽动民族仇恨、民族歧视，破坏民族团结的；

	　（五）捏造或者歪曲事实，散布谣言，扰乱社会秩序的；

	　（六）宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；

	　（七）公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；

	　（八）损害国家机关信誉的；

	　（九）其他违反宪法和法律行政法规的；

	　（十）进行商业广告行为的。



	二、互相尊重，对自己的言论和行为负责。

	三、禁止在申请用户时使用相关本站的词汇，或是带有侮辱、毁谤、造谣类的或是有其含义的各种语言进行注册用户，否则我们会将其删除。

	四、禁止以任何方式对本站进行各种破坏行为。

	五、如果您有违反国家相关法律法规的行为，本站概不负责，您的登录论坛信息均被记录无疑，必要时，我们会向相关的国家管理部门提供此类信息。";
$glo_smtp_auth=0;
?>
