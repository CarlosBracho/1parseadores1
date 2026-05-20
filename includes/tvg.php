<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min4.5.2.css">
    <link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">
    <title>TVG PRUEBA</title>
</head>

<body>
    <table BORDER>
        <?php
set_time_limit ('1');
//$out = shell_exec('ls');
//var_dump($out);
//exec('PowerShell.exe C:\laragon\www\tvgx.ps1'); //funciona eb windows
exec('pwsh tvgx.ps1'); //prueba linux
//shell_exec("PowerShell.exe -NoProfile -Command "& {Start-Process PowerShell.exe -ArgumentList '-NoProfile -ExecutionPolicy Bypass -File"tvg.ps1"'}"")
//$output = exec("powershell.exe -executionPolicy Unrestricted  C:\laragon\www\tvg.ps1");
//$output= shell_exec($runCMD);
echo( '<pre>' );
//echo( $output );
echo( '</pre>' );


require_once('../Connections/conexionbanca.php');
function new_tvg()
{
    echo "<tr>";
    echo "<td>.. id ..</td>";
    echo "<td>. trackname .</td>";
    echo "<td>.number.</td>";
    echo "<td>. mtp  .</td>";
    echo "<td>.status.</td>";
    echo "</tr>";
$url = 'http://localhost/includes/tvgx.json';
$str_datos = get_url_contents($url); 
$fulldatos = json_decode($str_datos,true); 
//var_dump($fulldatos["data"]["lhnTracks"]); 
$fulldatos=$fulldatos["data"]["lhnTracks"];
//var_dump($fulldatos['0']["id"]);
if (isset($fulldatos)) {
    $x=0;
    foreach($fulldatos as $CurrentRace) {
        //echo ' '.$x.' ';
      // echo $CurrentRace[$x]["id"];
       //var_dump($fulldatos[$x]["id"]);
       $id[$x]=$fulldatos[$x]["id"];
       if (isset($fulldatos[$x]["races"]['0']["number"])) {
       $race[$x]=$fulldatos[$x]["races"]['0']["number"];
       } else { $race[$x]=0; }
       if (isset($fulldatos[$x]["races"]['0']["track"]["name"])) {
        $trackname[$x]=$fulldatos[$x]["races"]['0']["track"]["name"];
        } else { $trackname[$x]=0; }


       if (isset($fulldatos[$x]["races"]['0']["mtp"])) {
        $mtp[$x]=$fulldatos[$x]["races"]['0']["mtp"];
        } else { $mtp[$x]=0; }
        
        if (isset($fulldatos[$x]["races"]['0']["status"]["code"])) {
            $status[$x]=$fulldatos[$x]["races"]['0']["status"]["code"];
            } else { $status[$x]=0; }

        if ($race[$x]==0) {}else{
echo "<tr>";
echo "<td>$id[$x]</td>";
echo "<td>&nbsp;$trackname[$x]</td>";
echo "<td>&nbsp;$race[$x]</td>";
echo "<td>&nbsp;$mtp[$x]</td>";
echo "<td>&nbsp;$status[$x]</td>";
echo "</tr>";
}
$x++;
}
}
return array($id);
}
list($id)=new_tvg();
$file = "tvgx.json";
if (!unlink($file)) {
    echo("Error deleting $file");
} else {
    echo("Deleted $file");
}
?>

    </table>
</body>

</html>