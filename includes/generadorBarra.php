<?php
  include('barcode.php');
  $_POST['tipo']="code39";
  $_POST['ancho']=190; //
  $_POST['x']=95;
  $_POST['height']=50;
  $_POST['angle']=0;
  $_POST['alto']=52; //
  $_POST['y']=25;
  $_POST['generar']="v";
  $fontSize = 10;   // GD1 in px ; GD2 in point
  $marge    = 10;   // between barcode and hri in pixel
  $x        = $_POST['x'];  // barcode center
  $y        = $_POST['y'];  // barcode center
  $height   = $_POST['height'];   // barcode height in 1D ; module size in 2D
  $width    = 2;    // barcode height in 1D ; not use in 2D
  $angle    = $_POST['angle'];   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
          
  $code     = $_GET['codigo']; // barcode, of course ;)
  $type     = $_POST['tipo'];
  
  function drawCross($im, $color, $x, $y)
  {
      imageline($im, $x - 10, $y, $x + 10, $y, $color);
      imageline($im, $x, $y- 10, $x, $y + 10, $color);
  }
  
  ########## ancho largo ##################33
  $im     = imagecreatetruecolor($_POST['ancho'], $_POST['alto']);
  $black  = ImageColorAllocate($im, 0x00, 0x00, 0x00);
  $white  = ImageColorAllocate($im, 0xff, 0xff, 0xff);
  $red    = ImageColorAllocate($im, 0xff, 0x00, 0x00);
  $blue   = ImageColorAllocate($im, 0x00, 0x00, 0xff);
  imagefilledrectangle($im, 0, 0, $_POST['ancho'], $_POST['alto'], $white);
  
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  
  if (isset($font)) {
      $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
      $len = $box[2] - $box[0];
      Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
      imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $blue, $font, $data['hri']);
  }
  if ($_POST['generar']=='i') {
      imagegif($im, $code.'.gif');
      imagedestroy($im);
  } else {
      header('Content-type: image/gif');
      imagegif($im);
      imagedestroy($im);
  }
