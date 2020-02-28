function  cleanWordString()  {  
          
		   html=frames.message.document.body.innerHTML;
           html  =  html.replace(/<\/?SPAN[^>]*>/gi,  ""  );//  Remove  all  SPAN  tags  
           html  =  html.replace(/<(\w[^>]*)  class=([^    |>]*)([^>]*)/gi,  "<$1$3")  ;  //  Remove  Class  attributes  
           //html  =  html.replace(/<(\w[^>]*)  style="([^"]*)"([^>]*)/gi,  "<$1$3")  ;  //  Remove  Style  attributes  
           html  =  html.replace(/<(\w[^>]*)  lang=([^    |>]*)([^>]*)/gi,  "<$1$3")  ;//  Remove  Lang  attributes  
           html  =  html.replace(/<\\?\?xml[^>]*>/gi,  "")  ;//  Remove  XML  elements  and  declarations  
           html  =  html.replace(/<\/?\w+:[^>]*>/gi,  "")  ;//  Remove  Tags  with  XML  namespace  declarations:  <o:p></o:p>  
           html  =  html.replace(/&nbsp;/,  "  "  );//  Replace  the  &nbsp;  
           //  Transform  <P>  to  <DIV>  
           var  re  =  new  RegExp("(<P)([^>]*>.*?)(<\/P>)","gi")  ;            //  Different  because  of  a  IE  5.0  error  
           html  =  html.replace(  re,  "<div$2</div>"  )  ;  
           //insertHTML(  html  )  ;  
		 
           frames.message.document.body.innerHTML=  html;  
}  


function onPaste()
{
var re = /<\w[^>]* class="?MsoNormal"?/gi ;
frames.message.document.execCommand("paste");
sHTML=frames.message.document.body.innerHTML;
if ( re.test(sHTML))
{
				if ( confirm( "你要粘贴的内容好象是从Word中拷出来的，是否要先清除Word格式再粘贴？" ) ){
					cleanWordString() ;
				 	return false ;
				 }


}
}

function setPaste()
{
 frames.message.document.body.onpaste=onPaste;	
}




