<?php
require_once('../Connections/conexionbanca.php');
$fecha=fechaactualbd();
$fechahoy=str_replace("-", "", $fecha);

//veriufica que hay en la carpeta y lo guarda en el string $quehay
$quehay=shell_exec("ls /home/respaldos");
//fin veriufica que hay en la carpeta y lo guarda en el string $quehay
//echo $quehay;
//
//shell_exec("tar -czvf /home/respaldos/apuestas".$fechahoy.".tar.gz /home/respaldos/apuestas".$fechahoy.".sql");
$menos7dias=str_replace("-", "", date("Y-m-d",strtotime($fecha."- 7 days"))); 
//echo $menos7dias;
$tienebddia=0;
$tienebddiacomprimida=0;
//respaldar base de datos
if (strlen(stristr($quehay, $fechahoy.'.sql'))>0) { $tienebddia=1; } else {
    $linea1="mysqldump -u root -p".$password_conexionbanca." apuestas > /home/respaldos/apuestas".$fechahoy.".sql";
echo $linea1;
    echo exec($linea1);
sleep(60);
}
//fin respaldar base de datos


//comprimir archivos
if (strlen(stristr($quehay, 'apuestas'.$fechahoy.'.tar.gz'))>0 && $tienebddia==1) { $tienebddiacomprimida=1; 
} else {
shell_exec("tar -czvf /home/respaldos/apuestas".$fechahoy.".tar.gz /home/respaldos/apuestas".$fechahoy.".sql");
sleep(40);
}

if (strlen(stristr($quehay, "public".$fechahoy.'.tar.gz'))>0) {
} else {
shell_exec("tar -czvf /home/respaldos/public".$fechahoy.".tar.gz /home/apuestas/public_html/");
sleep(10);
}

if (strlen(stristr($quehay, "crondarchivos".$fechahoy.'.tar.gz'))>0) {
} else {
shell_exec("tar -czvf /home/respaldos/crondarchivos".$fechahoy.".tar.gz /home/apuestas/crondarchivos/");
sleep(5);
}

if (strlen(stristr($quehay, "crondraiz".$fechahoy.'.tar.gz'))>0) {
} else {
shell_exec("tar -czvf /home/respaldos/crondraiz".$fechahoy.".tar.gz /etc/cron.d/");
sleep(5);
}
//fin comprimir archivos


//borrar archivos con 7 o mas dias
if (strlen(stristr($quehay, "apuestas".$menos7dias.'.tar.gz'))>0) { 
    exec('rm /home/respaldos/apuestas'.$menos7dias.'.tar.gz'); 
    }
    
    if (strlen(stristr($quehay, "public".$menos7dias.'.tar.gz'))>0) { 
        exec('rm /home/respaldos/public'.$menos7dias.'.tar.gz'); 
        }

        if (strlen(stristr($quehay, "crondarchivos".$menos7dias.'.tar.gz'))>0) { 
            exec('rm /home/respaldos/crondarchivos'.$menos7dias.'.tar.gz'); 
            }

            if (strlen(stristr($quehay, "crondraiz".$menos7dias.'.tar.gz'))>0) { 
                exec('rm /home/respaldos/crondraiz'.$menos7dias.'.tar.gz'); 
                }
//final borrar archivos con 7 o mas dias

//borrar la base de datos del dia por ser un archivo muy pesado
        exec('rm /home/respaldos/apuestas'.$fechahoy.'.sql');
// fin borrar la base de datos del dia por ser un archivo muy pesado


        














