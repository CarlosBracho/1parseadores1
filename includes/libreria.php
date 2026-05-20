<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}
class carrito
{
    public $num_apuestas; 		// var $num_productos;
    public $array_cod_loteria;			// var $array_id_prod;
    public $array_num_jugado;		// var $array_nombre_prod;
    public $array_mon_apuesta;		// var $array_precio_prod;
    public $array_signo_apuesta;	// var $array_referencia_prod;
    public function carrito()
    {
        $this->num_apuestas=0;
    }
    public function introduce_jugada($num_jugado, $mon_apuesta, $cod_loteria, $signo_apuesta)
    {
        $this->array_num_jugado[$this->num_apuestas]=$num_jugado;
        $this->array_mon_apuesta[$this->num_apuestas]=$mon_apuesta;
        $this->array_cod_loteria[$this->num_apuestas]=$cod_loteria;
        $this->array_signo_apuesta[$this->num_apuestas]=$signo_apuesta;
        $this->num_apuestas++;
        //echo "(".$this->num_apuestas.") ".$num_jugado." ".$mon_apuesta." ".$cod_loteria." ".$signo_apuesta."<br/> ";
    }
    public function eliminaJugadaSimple1($num_jugado)
    {
        echo "<td class='espacionumero2'>".$num_jugado."</td>";
    }
    public function imprime_carrito()
    {
        $suma = 0;
        $x=1111;
        $z=0;
        for ($i=0;$i<$this->num_apuestas;$i++) {
            if ($this->array_cod_loteria[$i]!=0) {
                $xloteria=ObtenerNombreLoteria($this->array_cod_loteria[$i]);
                $tipo="";
                $numJ=$this->array_num_jugado[$i];
                //echo " (".$numJ.") ";
                $tipo=ObtenerTipoLoteria($this->array_cod_loteria[$i]);
                if ($tipo>=3&&$tipo<=6) {
                    if ($tipo==4) {
                        list($tipo, $numJ)=ObtenerNombreAnimal($numJ);
                    } elseif ($tipo==5) {
                        list($tipo, $numJ)=ObtenerNombreFruta($numJ);
                    } elseif ($tipo==6) {
                        $tipo=ObtenerNombreCarta($this->array_signo_apuesta[$i]);
                    } else {
                        $tipo=ObtenerNombreSigno($this->array_signo_apuesta[$i]);
                    }
                    $xloteria=$xloteria."-".$tipo;
                } elseif ($this->array_signo_apuesta[$i]>0) {
                    $tipo=ObtenerNombreSigno($this->array_signo_apuesta[$i]);
                    $xloteria=$xloteria."-".$tipo;
                }
                //echo $this->array_num_jugado[$i];
                $monJ=$this->array_mon_apuesta[$i];
                echo '<table border="0" cellspacing="0">';
                if ($z%2==0) {
                    echo '<tr align="right" bgcolor="#E5E5E5" style="color:#000000">';
                } else {
                    echo '<tr align="right">';
                }
                echo "<td width='22'>" . $numJ . "</td>";
                echo "<td width='76'>".number_format($monJ, 2, ",", ".")."</td>";
                echo "<td width='216' align='left'> | " . $xloteria . "</td>"; ?>
				<td width='13' >
					<a title="eliminar jugada: <?php echo $numJ.'x'.$monJ.'&#13;'.$xloteria ?>" href="#" 
                    	onClick='cargar(<?php echo $i; ?>)'>
						<i class="fa fa-minus-circle" style="color:#000000"></i>
					</a><?php
                echo '</tr>';
                echo "</table>";
                $suma += $this->array_mon_apuesta[$i];
                $z++;
            }
        }
        return $suma;
    }
    public function recorre_carrito($monto)
    {
        $n=0;
        $xcarro=array();
        for ($i=0;$i<$this->num_apuestas;$i++) {
            if ($this->array_cod_loteria[$i]!=0) {
                if (strlen($this->array_num_jugado[$i])==3) {
                    $numero=substr($this->array_num_jugado[$i], 1, 2);
                    $term1=ObtenerTerminalLoteria($this->array_cod_loteria[$i]);
                    $xcarro2=$numero."-".$monto."-".$term1."-2-".$this->array_signo_apuesta[$i];
                    if (in_array($xcarro2, $xcarro)) {
                    } else {
                        $xcarro[]=$numero."-".$monto."-".$term1."-2-".$this->array_signo_apuesta[$i];
                    };
                    $n++;
                }
            }
        }
        if ($n==0) {
            $xcarro[0]="-0";
        }
        return $xcarro;
    }
    public function sumar_carrito()
    {
        $sumar=0;
        for ($i=0;$i<$this->num_apuestas;$i++) {
            if ($this->array_cod_loteria[$i]!=0) {
                $sumar += $this->array_mon_apuesta[$i];
            }
        }
        return $sumar;
    }
    public function contar_carrito_loteria($xcodigoLoteria, $napuesta, $xsigno)
    {
        $suma2=0;
        for ($i=0;$i<$this->num_apuestas;$i++) {
            if ($this->array_cod_loteria[$i]!=0) {
                if (($this->array_cod_loteria[$i])==$xcodigoLoteria && ($this->array_num_jugado[$i]===$napuesta) && ($this->array_signo_apuesta[$i]==$xsigno)) {
                    $suma2 += $this->array_mon_apuesta[$i];
                }
            }
        }
        return $suma2;
    }
    public function ordena_ticket()
    {
        for ($i=0;$i<($this->num_apuestas-1);$i++) {
            if ($this->array_cod_loteria[$i]!=0) {
                $cod1=$this->array_cod_loteria[$i];
                $sig1=$this->array_signo_apuesta[$i];
                $mon1=$this->array_mon_apuesta[$i];
                $num1=$this->array_num_jugado[$i];
                for ($y=($i+1);$y<$this->num_apuestas;$y++) {
                    if ($this->array_cod_loteria[$y]!=0) {
                        $cod2=$this->array_cod_loteria[$y];
                        $sig2=$this->array_signo_apuesta[$y];
                        $mon2=$this->array_mon_apuesta[$y];
                        $num2=$this->array_num_jugado[$y];
                        if ($cod1==$cod2 && $sig1==$sig2 && $num1===$num2) {
                            $this->array_mon_apuesta[$i]=$mon1+$mon2;
                            $this->array_mon_apuesta[$y]=0;
                            $this->array_signo_apuesta[$y]=0;
                            $this->array_cod_loteria[$y]=0;
                        }
                    }
                }
            }
        }
    }
    public function elimina_jugada($linea)
    {
        $this->array_cod_loteria[$linea]=0;
    }
    public function enviar_carrito($tipo)
    { // envia contenido antes de imprimir
        $retorno="";
        if ($tipo==5) {
            $retorno=$this->num_apuestas;
        }
        for ($i=0;$i<$this->num_apuestas;$i++) {
            if ($tipo==1) {
                $retorno[$i]=$this->array_cod_loteria[$i];
            }
            if ($tipo==2) {
                $retorno[$i]=$this->array_signo_apuesta[$i];
            }
            if ($tipo==3) {
                $retorno[$i]=$this->array_num_jugado[$i];
            }
            if ($tipo==4) {
                $retorno[$i]=$this->array_mon_apuesta[$i];
            }
        }
        return $retorno;
    }
}

if (!isset($_SESSION["ocarrito"])) {
    $_SESSION["ocarrito"] = new carrito();
}
if (!isset($_SESSION["ocarritoAni"])) {
    $_SESSION["ocarritoAni"] = new carrito();
}
function eliminaJugadaSimple($linea1)
{
    $_SESSION["ocarrito"]->elimina_jugada($linea1);
}
function eliminaJugadaSimpleAni($linea1)
{
    $_SESSION["ocarritoAni"]->elimina_jugada($linea1);
}
function orderMultiDimensionalArray($toOrderArray, $field, $inverse = false)
{
    $position = array();
    $newRow = array();
    foreach ($toOrderArray as $key => $row) {
        $position[$key]  = $row[$field];
        $newRow[$key] = $row;
    }
    if ($inverse) {
        arsort($position);
    } else {
        asort($position);
    }
    $returnArray = array();
    foreach ($position as $key => $pos) {
        $returnArray[] = $newRow[$key];
    }
    return $returnArray;
}
function series($valor, $longitud)
{
    $numeroP=str_split($valor);
    $contador=0;
    foreach ($numeroP as $numero4) {
        if ($numero4=="*") {
            if ($longitud==3) {
                if ($contador==0) {
                    for ($i = 0; $i <= 9; $i++) {
                        $arrayresultante[]=$i.$numeroP[1].$numeroP[2];
                    }
                }
                if ($contador==1) {
                    for ($i = 0; $i <= 9; $i++) {
                        $arrayresultante[]=$numeroP[0].$i.$numeroP[2];
                    }
                }
                if ($contador==2) {
                    for ($i = 0; $i <= 9; $i++) {
                        $arrayresultante[]=$numeroP[0].$numeroP[1].$i;
                    }
                }
            }
            if ($longitud==2) {
                if ($contador==0) {
                    for ($i = 0; $i <= 9; $i++) {
                        $arrayresultante[]=$i.$numeroP[1];
                    }
                }
                if ($contador==1) {
                    for ($i = 0; $i <= 9; $i++) {
                        $arrayresultante[]=$numeroP[0].$i;
                    }
                }
            }
        }
        $contador++;
    }
    return $arrayresultante;
}
function permutar($str)
{
    if (strlen($str) < 2) {
        return array($str);
    }
    $permutaciones = array();
    $cola = substr($str, 1);
    foreach (permutar($cola) as $permutacion) {
        $longitud = strlen($permutacion);
        for ($i = 0; $i <= $longitud; $i++) {
            if (strlen($str) == 2) {
                $permutaciones[] = substr((substr($permutacion, 0, $i) . $str[0] . substr($permutacion, $i)), 0, 2);
            }
            if (strlen($str) > 2) {
                $permutaciones[] = substr((substr($permutacion, 0, $i) . $str[0] . substr($permutacion, $i)), 0, 3);
            }
        }
    }
    $listaSimple = array_unique($permutaciones);
    $listaSimpleFinal = array_values($listaSimple);
    return $listaSimpleFinal;
}
function permutarOriginal($str)
{
    if (strlen($str) < 2) {
        return array($str);
    }
    $permutaciones = array();
    $cola = substr($str, 1);
    foreach (permutar($cola) as $permutacion) {
        $longitud = strlen($permutacion);
        for ($i = 0; $i <= $longitud; $i++) {
            $permutaciones[] = substr($permutacion, 0, $i) . $str[0] . substr($permutacion, $i);
        }
    }
    $listaSimple = array_unique($permutaciones);
    $listaSimpleFinal = array_values($listaSimple);
    return $listaSimpleFinal;
}
function seguidilla($inicio, $fin)
{
    $inicio2=(int)$inicio;
    for ($i = $inicio2 ; $i <= $fin ; $i ++) {
        if (strlen($inicio)==2) {
            if ($i>=0 && $i<=9) {
                $cero="0";
            } else {
                $cero="";
            }
        }
        if (strlen($inicio)==3) {
            if ($i>=0 && $i<=9) {
                $cero="00";
            } elseif ($i>=10 && $i<=99) {
                $cero="0";
            } else {
                $cero="";
            }
        }
        $seguidilla[] = $cero.$i;
    }
    return $seguidilla;
}
?>