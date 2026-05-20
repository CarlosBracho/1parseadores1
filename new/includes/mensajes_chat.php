<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset2 = sprintf("
/* PARSEADORES1 new\includes\mensajes_chat.php - QUERY 1 */ SELECT * 
FROM 
chat2
WHERE 
(sentdate >= date_add(NOW(), INTERVAL -3 DAY) AND sentdate <= %s) AND 
 tipo=%s
ORDER BY id desc", GetSQLValueString($fechasistema, "date"), GetSQLValueString(0, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$os = array();
do {
    if ($totalRows_Recordset2>0) {
        if (trim($row_Recordset2['from1'])!="Soporte") {
            if (!in_array($row_Recordset2['from1'], $os)) {
                $os[]=$row_Recordset2['from1']; ?>
                <div style="height:auto; padding:5px 5px 5px 5px; font-size:11px; background: #EBEBEB; margin:5px 5px 25px 5px;
                border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px 5px 5px 5px; -webkit-border-radius: 5px 5px 5px 5px;
                box-shadow: #aaa 1px 1px 6px; border: 1px solid #d4d4d4;">
                <?php
                if ($row_Recordset2['recd']==1) {?>
                    <a href="javascript:void(0)" style="text-decoration:none;" class="botonChat" data-type="zoomout" 
                    onClick="haga('<?php echo $row_Recordset2['from1'];?>','<?php echo $row_Recordset2['id_taquilla'];?>')">
                    <?php
                } ?>
                <table width="100%" border="0">
                    <tr>
                        <td width="10%" align="left"><?php echo $row_Recordset2['from1'].": "; ?></td>
                        <td colspan="2" rowspan="2" align="left" valign="middle" style="font-size:13px">
                            <?php echo $row_Recordset2['message']; ?>
                        </td>
                        <td width="4%" rowspan="2">
                                <?php
                            if ($row_Recordset2['recd']==1) {?>
                                <div style="float:right; font-size:46px; margin:15px 5px 0px 0px; color:#C00" class="noLeido">
                                    *
                                </div>
                                <?php
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><?php echo " Taquilla:.[".ObtenerNombreTaquilla($row_Recordset2['id_taquilla'])."]"; ?></td>

                    </tr>
                    <tr>
                        <td colspan="4" align="left">
                        <strong><em><?php
                        if ($fechasistema==$row_Recordset2['sentdate']) {
                            $dia="hoy";
                        } else {
                            $dia="el ".fechanueva($row_Recordset2['sentdate']);
                        }
                echo " enviado ".$dia." a las ".horaampm($row_Recordset2['senttime']); ?>
                        </em></strong></td>
                    </tr>
                </table>
                <?php
                if ($row_Recordset2['recd']==1) {?>
                    </a>
                    <?php
                } ?>
                </div>
            <?php
            }
        } else {
            if (!in_array($row_Recordset2['from1'].$row_Recordset2['to1'], $os)) {
                $os[]=$row_Recordset2['from1'].$row_Recordset2['to1']; ?>
                <div style="height:auto; padding:5px 5px 5px 5px; font-size:11px; margin:5px 5px 15px 5px; color:#FFFFFF;
                background-color: #333; border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px 5px 5px 5px; 
                -webkit-border-radius: 5px 5px 5px 5px; box-shadow: #aaa 1px 1px 6px; border: 1px solid #d4d4d4;">
                    <table width="100%" border="0">
                        <tr>
                            <td align="right" valign="middle" style="font-size:13px"><?php echo $row_Recordset2['message']; ?></td>
                        </tr>
                        <tr>
                            <td align="right">
                            <strong><?php echo $row_Recordset2['from1']; ?></strong>
                            <?php echo " a ".$row_Recordset2['to1']." Taquilla:.[".ObtenerNombreTaquilla($row_Recordset2['id_taquilla'])."]"; ?> 
                            <em><?php
                            if ($fechasistema==$row_Recordset2['sentdate']) {
                                $dia="hoy";
                            } else {
                                $dia="el ".fechanueva($row_Recordset2['sentdate']);
                            }
                            
                echo " enviado ".$dia." a las ".horaampm($row_Recordset2['senttime']); ?>
                            </em>
                        </td>
                        </tr>
                    </table>
                </div>
            <?php
            }
        }
    }
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
mysqli_free_result($Recordset2);
?>
