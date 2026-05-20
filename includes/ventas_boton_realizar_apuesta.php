							<?php
                            if (!isset($totalRows_Recordset1)) {
                                $totalRows_Recordset1=0;
                            }
                            if ($totalRows_Recordset1>0) {?>
                                <input type="button" id="imprimir" name="imprimir" onClick="return enviado(); imprimeTicket();" 
                                value="REALIZAR APUESTA E IMPRIMIR"
                                tabindex="<?php echo $x;?>"/>
                                <?php } else {?>
                                <input type="button" value="REALIZAR APUESTA E IMPRIMIR" disabled="disabled" 
                                tabindex="<?php echo $x;?>" id="imprimir" name="imprimir"/>
                            <?php  }?>