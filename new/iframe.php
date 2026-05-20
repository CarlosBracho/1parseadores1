

<html> 

<head> 
<title>Mostrar un enlace en una iframe</title> 
</head> 

<body> 
<script>
window.setInterval("reloadIFrame();", 3000);

function reloadIFrame() {
 document.frames["alerta"].location.reload();
}
</script>


<iframe name="alerta" id="alerta" src="http://localhost/alertasonora.php"  
marginwidth="0" marginheight="0" name="ventana_iframe" scrolling="no" border="0"  
frameborder="0" width="800" height="600"> 
</iframe> 

</body> 

</html>