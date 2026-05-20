<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}
?>    		
<button type="submit" value="imprimir" title="imprimir ticket" id="imprimir"
	<?php if ($_SESSION['MM_monto']<=0) {
    echo "disabled='disabled'";
}?> 
    style="background-color:#FFF; width:40px; height:40px; padding:2px 1px 2px 0px;">
    <i class="fa fa-print fa-2x" style="color:#0070C1"></i>
</button>
