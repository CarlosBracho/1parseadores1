<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<select class="rounded" tabindex="3" id="efectivoO" name="efectivoO"  form="formulario" style="width:130px; font-size:20px; background:#C00; color:#FFFFFF; height:40px">
	  <option value="0" <?php if ($_SESSION['efectivoOx']=='0') {
    echo 'SELECTED';
} ?>>Efectivo Bss</option>
	  <option value="1" <?php if ($_SESSION['efectivoOx']=='1') {
    echo 'SELECTED';
} ?>>Debito Bss</option>
	  <option value="2" <?php if ($_SESSION['efectivoOx']=='2') {
    echo 'SELECTED';
} ?>>Transferencia Bss</option>
	  <option value="3" <?php if ($_SESSION['efectivoOx']=='3') {
    echo 'SELECTED';
} ?>>Dolar Americano</option>
	  <option value="4" <?php if ($_SESSION['efectivoOx']=='4') {
    echo 'SELECTED';
} ?>>Peso Colombiano</option>
	  <option value="5" <?php if ($_SESSION['efectivoOx']=='5') {
    echo 'SELECTED';
} ?>>Sol Peruano</option>
</select>