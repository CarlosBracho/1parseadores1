<?php
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 logros\wuao.site nba mobile .php - QUERY 1 */ SELECT * FROM p2juegos 
WHERE competicionp2 = %s  AND
 deportep2 = %s  AND
iniciodtp2 >= %s ORDER BY iniciodtp2 
ASC
",
    GetSQLValueString("NBA", "text"),
    GetSQLValueString("Basketball", "text"),
    GetSQLValueString($datetime, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
    ?>
<div class="scrollj_mobil">
<div id="accordion">
<div class="card"> <div class="card-header-mobil" id="headingOneNBA">
<h5 class="mb-0">
<button style="color:#000000;font-weight: 900;" class="btn btn-link" data-toggle="collapse" data-target="#collapseOneNBA" aria-expanded="true" aria-controls="collapseOneNBA">
<small>NBA </small>
</button>
</h5>
</div>
<div id="collapseOneNBA" class="collapse" aria-labelledby="headingOneNBA" data-parent="#accordion">
<div class="card-body">
<table class="table table-bordered table-sm">
<thead>
</thead>
<tbody>
<?php
do {
        ?>
<tr class="tr-border-mobil">
<td colspan="6"><div class="text-center"><img border="0" width="20" height="20" class="img-fluid" src="./Vendedorclon_files/2HLnhmZg-lIu3xPm3.png"> 
<span class="font-equipo"> 
<b>(V)</b> CELTICS (BOS)</span> <small class="font-weight-bold">vs</small> <img border="0" width="20" height="20" class="img-fluid" src="./Vendedorclon_files/UmPff6f5-Q9co7bFf.png"> <span class="font-equipo"> 
<b>(H)</b> RAPTORS (TOR)</span><br> 
<span class="badge badge-primary">07/09/2020 6:30 pm</span> </div></td></tr>
<tr class="table-dark"></tr>
<tr class="table-dark"><th><small class="font-weight-bold">Ganar</small></th><th><small class="font-weight-bold">A/B</small></th><th><small class="font-weight-bold">Spread</small></th><th><small class="font-weight-bold">Ganar MJ</small></th><th><small class="font-weight-bold">A/B MJ</small></th><th><small class="font-weight-bold">Spread MJ</small></th></tr>
<tr class="table-light"><td id="45608_468517" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="45608,ML, ,468517,-130,CELTICS (BOS),7029,1,19552,6,,18:30:00,Boston Celtics">
<div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><b>-130</b></small></div></td>
<td id="45608_A468517" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="45608,A,212,A468517,-110,CELTICS (BOS),7029,4,19552,6,,18:30:00,Boston Celtics">
<div class="text-center"><small class="text-primary"><b>A 212</b></small> <b>-110<b></b></b></div></td>
<td id="45608_1468517" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="45608,RL,-1.5,1468517,-110,CELTICS (BOS),7029,2,19552,6,,18:30:00,Boston Celtics">
<div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>-1.5</b></small> <b>-110<b></b></b></small></div></td>
<td id="45608_5468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45608,5ML, ,5468517,-130,CELTICS (BOS),7029,9,19552,6,,18:30:00,Boston Celtics">
<div class="text-center"><b>-130</b></div></td>
<td id="45608_A5468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45608,5A,104.5,A5468517,-110,CELTICS (BOS),7029,12,19552,6,,18:30:00,Boston Celtics">
<div class="text-center"><small class="text-primary"><b>A 104.5</b></small><b><br>-110</b></div></td>
<td id="45608_2468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45608,5RL,-0.5,2468517,-110,CELTICS (BOS),7029,10,19552,6,,18:30:00,Boston Celtics">
<div class="text-center"><small class="text-primary"><b>-0.5</b></small><b><br>-110</b></div></td></tr>

<tr class="table-light"><td id="45609_468518" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="45609,ML, ,468518,100,RAPTORS (TOR),7030,5,19552,6,,18:30:00,Toronto Raptors">
<div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><b>100</b></small></div></td>
<td id="45609_B468518" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="45609,B,212,B468518,-110,RAPTORS (TOR),7030,8,19552,6,,18:30:00,Toronto Raptors">
<div class="text-center"><small class="text-primary"><b>B 212</b></small> <b>-110<b></b></b></div></td>
<td id="45609_1468518" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="45609,RL,+1.5,1468518,-110,RAPTORS (TOR),7030,6,19552,6,,18:30:00,Toronto Raptors">
<div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>+1.5</b></small> <b>-110<b></b></b></small></div></td>
<td id="45609_5468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45609,5ML, ,5468518,100,RAPTORS (TOR),7030,13,19552,6,,18:30:00,Toronto Raptors">
<div class="text-center"><b>100</b></div></td>
<td id="45609_B5468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45609,5B,104.5,B5468518,-110,RAPTORS (TOR),7030,16,19552,6,,18:30:00,Toronto Raptors">
<div class="text-center"><small class="text-primary"><b>B 104.5</b></small><b><br>-110</b></div></td>
<td id="45609_2468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45609,5RL,+0.5,2468518,-110,RAPTORS (TOR),7030,14,19552,6,,18:30:00,Toronto Raptors">
<div class="text-center"><small class="text-primary"><b>+0.5</b></small><b><br>-110</b></div></td></tr>
         <?php
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</tbody>
</table>
</div></div></div>    </div>
</div>
<?php
}?>