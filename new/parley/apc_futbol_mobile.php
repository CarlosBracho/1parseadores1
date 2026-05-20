<?php
do {
    //$nuevo_array[] = $fila;
    //echo '--';
    //echo $row_Recordset1fm['competicionp2'];
    //echo '</br>';
    ?>

<div id="accordion">
        <div class="card"> 
            <div class="card-header-mobil" id="headingOne<?php echo $row_Recordset1fm['competicionp2'] ?> - FUTBOL">
            <h5 class="mb-0">
            <button style="color:#000000;font-weight: 900;" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $row_Recordset1fm['competicionp2'] ?> - FUTBOL" aria-expanded="true" aria-controls="collapseOne<?php echo $row_Recordset1fm['competicionp2'] ?> - FUTBOL">
            <small><?php echo $row_Recordset1fm['competicionp2'] ?> - FUTBOL </small>
            </button>
            </h5>



            </div><div id="collapseOne<?php echo $row_Recordset1fm['competicionp2'] ?> - FUTBOL" 
            class="collapse" aria-labelledby="headingOne<?php echo $row_Recordset1fm['competicionp2'] ?> - FUTBOL" data-parent="#accordion"><div class="card-body">
            <table class="table table-bordered table-sm"><thead></thead><tbody><tr class="tr-border-mobil"><td colspan="5"><div class="text-center"><b>(V)</b> 
            <img border="0" width="20" height="20" class="img-fluid"> <span class="font-equipo">Dobanovci Buducnost </span> <small class="font-weight-bold">vs</small> <b>(H)</b> <img border="0" width="20" height="20" class="img-fluid" > <span class="font-equipo">Kolubara</span><br> <span class="badge badge-primary">07/09/2020 10:30 am</span> </div></td></tr><tr class="table-dark"><th><small class="font-weight-bold">Ganar</small></th>
            <th><small class="font-weight-bold">A/B</small></th>
            <th><small class="font-weight-bold">Spread</small></th>
            <th><small class="font-weight-bold">Ganar MJ</small></th>
            </tr><tr class="table-light">
            <td id="45816_469070" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45816,EML, ,469070,230,Empate - Doba VS Kolu,1524,25,19637,3,,10:30:00,">
            <div class="text-center">
            <span class="badge badge-pill badge-warning">
            Empate</span> <br><b>230<b></b></b></div></td><td id="45816_469070" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45816,,,469070,,Kolubara,1524,12,19637,3,,10:30:00,"></td>
            
            <td></td><td id="45816_5469070" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45816,E5ML, ,5469070,-105,Empate - Doba VS Kolu,1524,26,19637,3,,10:30:00,"><div class="text-center"><span class="badge badge-pill badge-warning">Empate</span> <br><b>-105</b></div></td></tr><tr class="table-light"></tr><tr></tr><tr class="table-light">
            <td id="45814_469068" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45814,ML, ,469068,170,Dobanovci Buducnost ,2133,1,19637,3,,10:30:00,"><div class="text-center"><span class="badge badge-pill badge-warning">Ganar <small class="font-weight-bold">
            (V)</small></span><small class="font-weight-bold"> <br><b>170</b></small></div></td><td id="45814_A469068" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45814,A,2.5,A469068,-120,Dobanovci Buducnost ,2133,4,19637,3,,10:30:00,"><small class="text-warning"><b>
            A 2.5</b></small> <b>-120<b></b></b></td>
            
            <td></td><td id="45814_5469068" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45814,5ML, ,5469068,220,Dobanovci Buducnost ,2133,9,19637,3"><div class="text-center"><span class="badge badge-pill badge-warning">Ganar MJ. <small class="font-weight-bold">
            (V)</small></span><small class="font-weight-bold"> <br> <b>
            220</b></small></div></td></tr><tr class="table-light"></tr><tr></tr><tr class="table-light">
            <td id="45815_469069" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45815,ML, ,469069,120,Kolubara,1524,5,19637,3,,10:30:00,"><div class="text-center"><span class="badge badge-pill badge-warning">Ganar <small class="font-weight-bold">
            (H)</small></span><small class="font-weight-bold"> <br><b>
            120</b></small></div></td>
            <td id="45815_B469069" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45815,B,2.5,B469069,-110,Kolubara,1524,8,19637,3,,10:30:00,"><small class="text-warning"><b>B 2.5</b></small> <b>-110<b></b></b></td>
            
            <td></td>
            <td id="45815_5469069" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
            class="45815,5ML, ,5469069,180,Kolubara,1524,13,19637,3">
            <div class="text-center"><span class="badge badge-pill badge-warning">
            Ganar MJ. <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br> <b>
            180</b></small></div></td></tr><tr class="table-light"></tr><tr></tr></tbody></table>
            </div>


            
            
            </div>
            </div>
         <div class="card"> 
    </div>




    <?php
} while ($row_Recordset1fm = mysqli_fetch_assoc($Recordset1fm));
