<?php
$result = $_POST["file"];

 // $result = 1;
$fp = fopen('twinspire.json', 'w'); fwrite($fp, $result); fclose($fp);
