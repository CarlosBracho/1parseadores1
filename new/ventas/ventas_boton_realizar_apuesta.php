							<?php
                            if (!isset($_GET["js"])) {
                                $_GET["js"]=$totalRows_Recordset1;
                            }
                            if ($_GET["js"]>0) {?>
                                <input type="button" id="imprimir" name="imprimir" onClick="return enviado(); imprimeTicket();" 
                                value="REALIZAR APUESTA E IMPRIMIR"
                                tabindex="<?php echo $x;?>"/>
                                <?php } else {?>
                                <input type="button" value="REALIZAR APUESTA E IMPRIMIR" disabled="disabled" 
                                tabindex="<?php echo $x;?>" id="imprimir" name="imprimir" 
                                style="background:#CCCCCC; border:#CCC;box-shadow: 0px 0px 0px rgba(0, 0, 0, 0); color:#e0e0e0"/>
                            <?php  }?>