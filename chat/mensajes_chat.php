<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("America/Puerto_Rico");
if (isset($_POST["from1"]) && isset($_POST["to1"])) {
    $_POST["from1"]=trim($_POST["from1"]);
    $_POST["to1"]=trim($_POST["to1"]);
    $fecAct=fechaactualbd();
    $de=trim($_POST["rA"]);
    $query_Recordset120 = sprintf(
        "/* PARSEADORES1 chat\mensajes_chat.php - QUERY 1 */ SELECT *	
		FROM chat 
		WHERE (from1=%s AND to1=%s AND recd!=2) OR (from1=%s AND to1=%s AND recd!=2)
		ORDER BY sentdate ASC, senttime ASC",
        GetSQLValueString($_POST["from1"], "text"),
        GetSQLValueString($_POST["to1"], "text"),
        GetSQLValueString($_POST["to1"], "text"),
        GetSQLValueString($_POST["from1"], "text")
    );
    $Recordset120 = mysqli_query($conexionbanca, $query_Recordset120) or die(mysqli_error($conexionbanca));
    $row_Recordset120 = mysqli_fetch_assoc($Recordset120);
    $totalRows_Recordset120 = mysqli_num_rows($Recordset120);
    if ($totalRows_Recordset120>0) {
        $fAnt=""; ?>
		<table border="0" cellpadding="0" cellspacing="2" class="tablaMen" width="100%" id="cMessage" style="text-transform: none">
			<tbody><?php
                $ctaLeido=0;
        do {
            if ($row_Recordset120['sentdate']==$fecAct) {
                $fecView="hoy";
            } else {
                $fecView=fechanueva($row_Recordset120['sentdate']);
            }
            if ($row_Recordset120['to1']==$_POST["to1"]) {
                $estilo='tfromDiv';
                $class='tfrom';
                $nom="&nbsp;";
                $disNew="";
                if ($row_Recordset120['recd']==1) {
                    $cStatus="background:#B50003";
                } else {
                    $cStatus="display:none;";
                }
            } else {
                $estilo='ttoDiv';
                $class='tto';
                $nom=$row_Recordset120['from1'].":";
                $cStatus="#288DD5";
                $cStatus="display:none;";
                if ($row_Recordset120['recd']==1) {
                    $connected=$row_Recordset120['connected'];
                    $insertSQL1 = sprintf(
                        "/* PARSEADORES1 chat\mensajes_chat.php - QUERY 2 */ UPDATE chat 
							SET recd=%s, connected=%s
							WHERE id=%s",
                        GetSQLValueString(0, "int"),
                        GetSQLValueString($connected, "date"),
                        GetSQLValueString($row_Recordset120['id'], "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    $ctaLeido++;
                }
            }
            if ($row_Recordset120['sentdate']!=$fAnt) {
                $fAnt=$row_Recordset120['sentdate']; ?>
						<tr style="text-align:center; font-size:8px">
							<td>
								<?php echo $fecView; ?>
							</td>
						</tr><?php
            } ?>
					<tr>
						<td>
                        <div class=" <?php echo $class; ?>"></div>
							<div class=" <?php echo $estilo; ?>">
								<div style="width:110%; float:left; margin:-2%; color: #FFDC00; font-size:13px; 
									padding:0.5% 0 3% 1%"><b><?php echo $nom; ?></b>
								</div>
								<?php echo $row_Recordset120['message']; ?>
								<div style="width:100%; padding:3% 0 0 0; font-size:9px; text-align:right;">
                                	<div style="width:96%;float:left;">
                                    	<?php echo horaampm($row_Recordset120['senttime'])."&nbsp;"; ?>
                                    </div>
									
									<div style="float:left;width:4%; height:9px;">
										<div class="c1" style=" <?php echo $cStatus?>">
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
						<tr style="text-align:left" height="4">
						<td></td>
					</tr><?php
        } while ($row_Recordset120 = mysqli_fetch_assoc($Recordset120)); ?>
			</tbody>
		</table>
		<script>
			if( typeof menANew !== 'undefined' && jQuery.isFunction( menANew ) ) {menANew('<?php echo $_POST["newD"]; ?>');}
			document.getElementById("from1").value="<?php echo $_POST["from1"]; ?>";
			document.getElementById("to1").value="<?php echo trim($_POST["to1"]); ?>";
			document.getElementById("newD").value="<?php echo $_POST["newD"]; ?>";
		</script><?php
    } else {
        echo '<table border="0" cellpadding="0" cellspacing="2" class="tablaMen" width="100%" id="cMessage"><tbody><tr><td>&nbsp;</td></tr><tr><td></td></tr></tbody></table>';
    }
}
?>


