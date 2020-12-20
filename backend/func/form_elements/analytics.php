<script type="text/javascript">
 function SetCwinHeight(){
  var iframeid=document.getElementById("iframeid"); //iframe id
  if (document.getElementById){
   if (iframeid && !window.opera){
    if (iframeid.contentDocument && iframeid.contentDocument.body.offsetHeight){
     iframeid.height = iframeid.contentDocument.body.offsetHeight;
    }else if(iframeid.Document && iframeid.Document.body.scrollHeight){
     iframeid.height = iframeid.Document.body.scrollHeight;
    }
   }
  }
 }
</script>
<iframe width="100%" id="iframeid" height="4145" width="1581" frameborder="0" src="./slimstat/index.php"></iframe>
<!--script language="javascript">
 function reSize(){ 
 	　　parent.document.all.frameid.height=document.body.scrollHeight; 
 		parent.document.all.frameid.width=document.body.scrollwidth; 
 	} 
 	window.onload=reSize; </script>
<iframe frameborder="0" src="./slimstat/index.php" id="frameid"></iframe-->
