<?php
// 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
$html= '<html><body>Hola</body></html>';
$pdf = new DOMPDF();
$pdf->set_paper("A4", "portrait");
$pdf->load_html($html);
$pdf->render();
$output = $pdf->output();
file_put_contents('mipdf.pdf', $output);