<?php
// /home/parsea1/public_html/parseadores_ia/view_img.php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$img_dir = __DIR__ . '/img/';
$web_path = 'img/';
$images = [];

if (is_dir($img_dir)) {
    $files = scandir($img_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && preg_match('/\.png$/i', $file)) {
            $filePath = $img_dir . $file;
            $images[$file] = filemtime($filePath);
        }
    }
    // Ordenar descendentemente por fecha de modificación (el más nuevo primero)
    arsort($images);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10">
    <title>Visor de Capturas INH en Tiempo Real</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        h1 {
            color: #ffcc00;
            font-size: 24px;
        }
        .meta-info {
            background-color: #333;
            padding: 10px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .history-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            background: #262626;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .history-item {
            background-color: #333333;
            border: 2px solid #444444;
            border-radius: 6px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: border-color 0.2s;
        }
        .history-item:hover {
            border-color: #ffcc00;
        }
        .thumb-wrapper {
            width: 100%;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1a1a1a;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .thumb-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .thumb-meta {
            font-size: 12px;
            color: #aaaaaa;
            text-align: left;
            border-top: 1px solid #444;
            padding-top: 8px;
        }
        .thumb-meta strong {
            color: #ffcc00;
        }
        .thumb-meta a {
            color: #00ffcc;
            text-decoration: none;
            display: block;
            margin-top: 4px;
            word-break: break-all;
        }
        .thumb-meta a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Visor de Automatización INH (Monitoreo 30s)</h1>
        
        <?php if (!empty($images)): 
            $latest_file = key($images);
            $latest_time = current($images);
        ?>
            <div class="meta-info">
                <strong>Última captura:</strong> <?php echo $latest_file; ?> | 
                <strong>Fecha:</strong> <?php echo date("Y-m-d H:i:s", $latest_time); ?> (Auto-refresh cada 10s)
            </div>
            
            <h3>Historial de Capturas Recientes</h3>
            <div class="history-grid">
                <?php foreach ($images as $file => $time): ?>
                    <div class="history-item">
                        <div class="thumb-wrapper">
                            <a href="<?php echo $web_path . $file; ?>" target="_blank">
                                <img class="thumb-image" src="<?php echo $web_path . $file; ?>?v=<?php echo $time; ?>" alt="<?php echo $file; ?>">
                            </a>
                        </div>
                        <div class="thumb-meta">
                            <strong>Hora:</strong> <?php echo date("H:i:s", $time); ?><br>
                            <strong>Fecha:</strong> <?php echo date("Y-m-d", $time); ?>
                            <a href="<?php echo $web_path . $file; ?>" target="_blank"><?php echo $file; ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="meta-info">No se encontraron capturas de pantalla en el directorio /img/. Esperando el ciclo del bot...</div>
        <?php endif; ?>
    </div>
</body>
</html>