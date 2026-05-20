<script src="../admin_lot/jslot/fjava_lot.js"></script>
<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}
?>              
    
	<button value="restaurar" id="borrar" name="borrar" title="restaurar" 
    	onclick="window.location='index.php'; return false;" 
    	style=" background: #FFF; width:40px; height:40px;padding:2px 1px 2px 0px;" >
		<i class="fa fa-times-circle-o fa-2x" style="color: #900"></i>
	</button>


