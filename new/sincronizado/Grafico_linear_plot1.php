<?php
require_once('../Connections/conexionbanca.php');
require_once ('Grafico_src/jpgraph.php');
require_once ('Grafico_src/jpgraph_line.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();


//echo '11111111111111<br>';

$fechasistemamenos12 = strtotime('-30 day', strtotime($fechasistema));
$fechasistemamenos12 = date('Y-m-d', $fechasistemamenos12);
$fechasistemamenos1 = strtotime('-1 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos1);

//$Array111=0;
$query_RecordsetAJ =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Grafico_linear_plot1.php - QUERY 1 */ SELECT
  id_estadistica, can_estadisitcas
  FROM  
  estadisticas
  WHERE 
  tipo_estadistica = 1
  AND (tiempo_estadistica >= %s AND tiempo_estadistica<= %s)
  ORDER BY id_estadistica ASC LIMIT 90",
      GetSQLValueString($fechasistemamenos12.' 00:00:00', "date"),
      GetSQLValueString($fechasistemamenos1.' 23:59:59', "date"));


if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
    while ($rowAJ = $resultAJ->fetch_array()) {
        //$Array111[] =  $rowAJ;
        //'codWiningBetEsta' => $rowAJ['can_estadisitcas']
      //$Array111[] = array('codWiningBetEsta' => $rowAJ['can_estadisitcas']);
      $datay1[] = intval($rowAJ['can_estadisitcas']);
      $fechaarray[] = intval($rowAJ['can_estadisitcas']);

       // echo $rowAJ['can_estadisitcas'].'<br>';
    }
    mysqli_free_result($resultAJ);
}






 
//$datay1 = array(20,15,23,15,80,20,45,10,5,45,60);
$datay2 = array(0,0,0,0,0,0,0,0,0,0,0,0);
$datay3 = array(0,0,0,0,0,0,0,0,0,0,0,0);
$datay4 = array(0,0,0,0,0,0,0,0,0,0,0,0);

// Setup the graph
$graph = new Graph(1300,350);
$graph->SetScale("textlin");
 
$theme_class=new UniversalTheme;
 
$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('TICKETS AMERICANAS');
$graph->SetBox(false);
 
$graph->img->SetAntiAliasing();
 
$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
 
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($fechaarray);
$graph->xgrid->SetColor('#E3E3E3');
 
// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('');
 

 
$graph->legend->SetFrameWeight(1);
 
$graph->legend->SetPos(0.5,0.98,'center','bottom');
 
// Output line
$graph->Stroke();








?>