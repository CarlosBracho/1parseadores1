 <?php 
 
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');

//Coordenada Y. Van a ser tres líneas
//En el interior del array, se agrega cada valor, en este caso son cuatro valores
//para cada una de las líneas que dibujarán la gráfica
$datay1 = array(20,15,23,15);
$datay2 = array(12,9,42,8);
$datay3 = array(5,17,32,24);

// Dimensiones de la gráfica anchura, altura
$graph = new Graph(300,250);
$graph->SetScale("textlin");

// Agregándole uno de los themes
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);

// Título de la gráfica
$graph->title->Set('Ejemplo gráfica');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");


//Coordenada X
$graph->xaxis->SetTickLabels(array('A','B','C','D'));
$graph->xgrid->SetColor('#E3E3E3');

// Creando la primera línea y dándole las características gráficas
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Línea 1');

// Creando la segunda línea y dándole las características gráficas
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Línea 2');

// Creando la tercera línea y dándole las características gráficas
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Línea 3');

$graph->legend->SetFrameWeight(1);

// Genera la gráfica
$graph->Stroke();

?>