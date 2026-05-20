<?php
/*
$nCab	numero caballo						$cVen	codigo venta
$mVen	monto de venta						$ePrs	ejemplar primero simple
$ePrd	ejemplar primero doble				$ePrt	ejemplar primero doble
$dPsg	dividendo primero simple ganador	$dPsp	dividendo primero simple place
$dPss	dividendo primero simple show		$dPdg	dividendo primero doble ganador
$dPdp	dividendo primero doble place		$dPds	dividendo primero doble show
$dPtg	dividendo primero triple ganador	$dPtp	dividendo primero triple place
$dPts	dividendo primero triple show
------------------------------------------
$eSrs	ejemplar segundo simple				$eSrd	ejemplar segundo doble
$eSrt	ejemplar segundo triple				$dSsp	dividendo segundo simple place
$dSss	dividendo segundo simple show		$dSdp	dividendo segundo doble place
$dSds	dividendo segundo doble show		$dStp	dividendo segundo triple place
$dSts	dividendo segundo triple show
------------------------------------------
$eTrs	ejemplar tercero simple				$eTrd	ejemplar tercero doble
$eTrt	ejemplar tercero triple				$dTss	dividendo primero simple show
$dTds	dividendo primero doble show		$dTts	dividendo primero triple show
$def_regdiv1  $div_pdes1 $div_phas1 $pag_pdiv1 $opc_ame*/
// num_caballo cod_venta mon_venta eje_pri eje_pri_d eje_pri_t div_pri_g div_pri_p div_pri_s div_dob_g div_pri_dob_p div_pri_dob_s
// div_pri_tri_g div_pri_tri_p div_pri_tri_s eje_seg eje_seg_d eje_seg_d <-----falta
// eje_ter eje_ter_d eje_ter_t
// eje_cua eje_cua_d eje_cua_t div_exacta div_trifecta div_superfecta tope mas factor base
//$regla1_desd=$row_Recordset1['div_ran_pdes_hnac'];
//$regla1_hast=$row_Recordset1['div_ran_phas_hnac'];
//$regla1_opci=$row_Recordset1['opc_ran_pdiv_hnac'];
//$regla1_paga=$row_Recordset1['pag_ran_pdiv_hnac'];
//$regla2_desd=$row_Recordset1['div_ran_sdes_hnac'];
//$regla2_hast=$row_Recordset1['div_ran_shas_hnac'];
//$regla2_opci=$row_Recordset1['opc_ran_sdiv_hnac'];
//$regla2_paga=$row_Recordset1['pag_ran_sdiv_hnac'];


function jNormal($nCab, $cVen, $mVen, $ePrs, $ePrd, $ePrt, $dPsg, $dPsp, $dPss, $dPdg, $dPdp, $dPds, $dPtg, $dPtp, $dPts, $eSrs, $eSrd, $eSrt, $dSsp, $dSss, $dSdp, $dSds, $dStp, $dSts, $eTrs, $eTrd, $eTrt, $dTss, $dTds, $dTts, $tope, $mas, $anuReg, $def_regdiv1, $div_pdes1, $div_phas1, $pag_pdiv1, $opc_ame, $div_pdes2, $div_phas2, $pag_pdiv2, $opc_ame2, $redondeo_ame)
{

    if($redondeo_ame==1){
//ganador simple
$dPsg=$dPsg*5; 	$dPsg=floor($dPsg);	$dPsg=$dPsg/5;  
$dPsp=$dPsp*5;	$dPsp=floor($dPsp);	$dPsp=$dPsp/5;
$dPss=$dPss*5;	$dPss=floor($dPss);	$dPss=$dPss/5;	
$dPdg=$dPdg*5;	$dPdg=floor($dPdg);	$dPdg=$dPdg/5;
$dPdp=$dPdp*5;	$dPdp=floor($dPdp);	$dPdp=$dPdp/5;	
$dPds=$dPds*5;	$dPds=floor($dPds);	$dPds=$dPds/5;
$dPtg=$dPtg*5;	$dPtg=floor($dPtg);	$dPtg=$dPtg/5;	
$dPtp=$dPtp*5;	$dPtp=floor($dPtp);	$dPtp=$dPtp/5;
$dPts=$dPts*5;	$dPts=floor($dPts);	$dPts=$dPts/5;

//ganador doble
$eSrs=$eSrs*5; 	$eSrs=floor($eSrs);	$eSrs=$eSrs/5;
$eSrt=$eSrt*5; 	$eSrt=floor($eSrt);	$eSrt=$eSrt/5;
$dSss=$dSss*5; 	$dSss=floor($dSss);	$dSss=$dSss/5;
$dSds=$dSds*5; 	$dSds=floor($dSds);	$dSds=$dSds/5;
$dSts=$dSts*5; 	$dSts=floor($dSts);	$dSts=$dSts/5;
$eSrd=$eSrd*5; 	$eSrd=floor($eSrd);	$eSrd=$eSrd/5;
$dSsp=$dSsp*5; 	$dSsp=floor($dSsp);	$dSsp=$dSsp/5;
$dSdp=$dSdp*5; 	$dSdp=floor($dSdp);	$dSdp=$dSdp/5; 
$dStp=$dStp*5; 	$dStp=floor($dStp);	$dStp=$dStp/5;
//ganador triple
$eTrs=$eTrs*5; 	$eTrs=floor($eTrs);	$eTrs=$eTrs/5;
$eTrt=$eTrt*5; 	$eTrt=floor($eTrt);	$eTrt=$eTrt/5;
$dTds=$dTds*5; 	$dTds=floor($dTds);	$dTds=$dTds/5;
$eTrd=$eTrd*5; 	$eTrd=floor($eTrd);	$eTrd=$eTrd/5;
$dTss=$dTss*5; 	$dTss=floor($dTss);	$dTss=$dTss/5;
$dTts=$dTts*5; 	$dTts=floor($dTts);	$dTts=$dTts/5;
        }
        
        

        if($redondeo_ame==2){

            $dPsg=$dPsg*5; 	$dPsg=round($dPsg);	$dPsg=$dPsg/5;  
            $dPsp=$dPsp*5;	$dPsp=round($dPsp);	$dPsp=$dPsp/5;
            $dPss=$dPss*5;	$dPss=round($dPss);	$dPss=$dPss/5;	
            $dPdg=$dPdg*5;	$dPdg=round($dPdg);	$dPdg=$dPdg/5;
            $dPdp=$dPdp*5;	$dPdp=round($dPdp);	$dPdp=$dPdp/5;	
            $dPds=$dPds*5;	$dPds=round($dPds);	$dPds=$dPds/5;
            $dPtg=$dPtg*5;	$dPtg=round($dPtg);	$dPtg=$dPtg/5;	
            $dPtp=$dPtp*5;	$dPtp=round($dPtp);	$dPtp=$dPtp/5;
            $dPts=$dPts*5;	$dPts=round($dPts);	$dPts=$dPts/5;
            
            //ganador doble
            $eSrs=$eSrs*5; 	$eSrs=round($eSrs);	$eSrs=$eSrs/5;
            $eSrt=$eSrt*5; 	$eSrt=round($eSrt);	$eSrt=$eSrt/5;
            $dSss=$dSss*5; 	$dSss=round($dSss);	$dSss=$dSss/5;
            $dSds=$dSds*5; 	$dSds=round($dSds);	$dSds=$dSds/5;
            $dSts=$dSts*5; 	$dSts=round($dSts);	$dSts=$dSts/5;
            $eSrd=$eSrd*5; 	$eSrd=round($eSrd);	$eSrd=$eSrd/5;
            $dSsp=$dSsp*5; 	$dSsp=round($dSsp);	$dSsp=$dSsp/5;
            $dSdp=$dSdp*5; 	$dSdp=round($dSdp);	$dSdp=$dSdp/5; 
            $dStp=$dStp*5; 	$dStp=round($dStp);	$dStp=$dStp/5;
            //ganador triple
            $eTrs=$eTrs*5; 	$eTrs=round($eTrs);	$eTrs=$eTrs/5;
            $eTrt=$eTrt*5; 	$eTrt=round($eTrt);	$eTrt=$eTrt/5;
            $dTds=$dTds*5; 	$dTds=round($dTds);	$dTds=$dTds/5;
            $eTrd=$eTrd*5; 	$eTrd=round($eTrd);	$eTrd=$eTrd/5;
            $dTss=$dTss*5; 	$dTss=round($dTss);	$dTss=$dTss/5;
            $dTts=$dTts*5; 	$dTts=round($dTts);	$dTts=$dTts/5;
        }

        //echo $dPsg.'<br>';
    $divisor=2;
    $montoapagar[0]=0; //monto a pagar
    $montoapagar[1]="2"; // estado del ticket 2=pago con dividendo	5=pago devuelto
    $mas=$mas/10;

    if ($cVen==1 && $anuReg>0 && $mas>0) {
        
        if ($dPsg<=$anuReg) {
            $mas=0;
        }
    
        if ($dPdg<=$anuReg && $dPdg>0) {
            $mas=0;
        }
        if ($dPtg<=$anuReg && $dPtg>0) {
            $mas=0;
        }
    
}
    if ($ePrd>0 && $dPdg>0) { //comprueba si hay empate en primer lugar y asigna al segundo lugar dividendos
        $eSrs=$ePrd;
        $dSsp=$dPdp;
        $dSss=$dPds;
    }
    if (($nCab==$ePrs) || ($dPsg<=0 && $cVen==1) || ($dPsp<=0 && $cVen==2) || ($dPss<=0 && $cVen==3)) { //primer lugar
        if (($dPsg<=0 && $cVen==1) || ($dPsp<=0 && $cVen==2) || ($dPss<=0 && $cVen==3)) {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        } else {
            if ((int)$cVen==1) { //ganador
           if($def_regdiv1==0){


                
                $dTot=$dPsg+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
            if($def_regdiv1==1){
                

                if ($dPsg<$div_pdes1){
                $dTot=$dPsg+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }

                if ($dPsg>=$div_pdes1 && $dPsg<=$div_phas1) {
            if ($opc_ame==0 && $pag_pdiv1==0) { // +
                $dTot=$dPsg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==1 && $pag_pdiv1==0) { // =
                $dTot=$dPsg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==0 && $pag_pdiv1>0) { // +
                $pag_pdiv1=$pag_pdiv1/10;
                $dTot=$dPsg+$pag_pdiv1;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==1 && $pag_pdiv1>0) { //=
                $dTot=$pag_pdiv1;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
        }
           
           if($dPsg>=$div_pdes2 && $dPsg<=$div_phas2){
           
            if ($opc_ame2==0 && $pag_pdiv2==0) { // +
                $dTot=$dPsg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==1 && $pag_pdiv2==0) { // =
                $dTot=$dPsg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==0 && $pag_pdiv2>0) { // +
                $pag_pdiv2=$pag_pdiv2/10;
                $dTot=$dPsg+$pag_pdiv2;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==1 && $pag_pdiv2>0) { //=
                $dTot=$pag_pdiv2;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }

           }
        }
            }
            if ((int)$cVen==2) { //place
                $dTot=$dPsp+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
            if ((int)$cVen==3) { //show
                $dTot=$dPss+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
        }
    } //primer lugar
    if ($nCab==$ePrd) { //primer lugar empate doble
        if ((int)$cVen==1) { //ganador
            if($def_regdiv1==0){


                
                $dTot=$dPdg+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
            if($def_regdiv1==1){
                

                if ($dPdg<$div_pdes1){
                $dTot=$dPdg+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }

                if ($dPdg>=$div_pdes1 && $dPdg<=$div_phas1) {
            if ($opc_ame==0 && $pag_pdiv1==0) { // +
                $dTot=$dPdg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==1 && $pag_pdiv1==0) { // +
                $dTot=$dPdg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==0 && $pag_pdiv1>0) { // +
                $pag_pdiv1=$pag_pdiv1/10;
                $dTot=$dPdg+$pag_pdiv1;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==1 && $pag_pdiv1>0) { //=
                $dTot=$pag_pdiv1;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
        }
           
           if($dPdg>=$div_pdes2 && $dPdg<=$div_phas2){
           
            if ($opc_ame2==0 && $pag_pdiv2==0) { // +
                $dTot=$dPdg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }

            if ($opc_ame2==1 && $pag_pdiv2==0) { // +
                $dTot=$dPdg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==0 && $pag_pdiv2>0) { // +
                $pag_pdiv2=$pag_pdiv2/10;
                $dTot=$dPdg+$pag_pdiv2;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==1 && $pag_pdiv2>0) { //=
                $dTot=$pag_pdiv2;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }

           }
        }
        }
        if ((int)$cVen==2) { //place
            $dTot=$dPdp+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
        if ((int)$cVen==3) { //show
            $dTot=$dPds+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
    } //primer lugar
    if ($nCab==$ePrt) { //primer lugar empate triple
        if ((int)$cVen==1) { //ganador
            if($def_regdiv1==0){


                
                $dTot=$dPtg+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
            if($def_regdiv1==1){
                

                if ($dPtg<$div_pdes1){
                $dTot=$dPtg+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }

                if ($dPtg>=$div_pdes1 && $dPtg<=$div_phas1) {
            if ($opc_ame==0 && $pag_pdiv1==0) { // +
                $dTot=$dPtg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==1 && $pag_pdiv1==0) { // =
                $dTot=$dPtg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==0 && $pag_pdiv1>0) { // +
                $pag_pdiv1=$pag_pdiv1/10;
                $dTot=$dPtg+$pag_pdiv1;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame==1 && $pag_pdiv1>0) { //=
                $dTot=$pag_pdiv1;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
        }
           
           if($dPtg>=$div_pdes2 && $dPtg<=$div_phas2){
           
            if ($opc_ame2==0 && $pag_pdiv2==0) { // +
                $dTot=$dPtg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==1 && $pag_pdiv2==0) { // =
                $dTot=$dPtg;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==0 && $pag_pdiv2>0) { // +
                $pag_pdiv2=$pag_pdiv2/10;
                $dTot=$dPtg+$pag_pdiv2;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }
            if ($opc_ame2==1 && $pag_pdiv2>0) { //=
                $dTot=$pag_pdiv2;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot/$divisor) * $mVen);
            }

           }
        }
        }
        if ((int)$cVen==2) { //place
            $dTot=$dPtp+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
        if ((int)$cVen==3) { //show
            $dTot=$dPts+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
    }
    //segundo lugar
    if (($nCab==$eSrs) || ($dSsp<=0 && $cVen==2) || ($dSss<=0 && $cVen==3)) { //segundo lugar
        if (($dSsp<=0 && $cVen==2) || ($dSss<=0 && $cVen==3)) {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        } else {
            if ((int)$cVen==2) { //place
                $dTot=$dSsp+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
            if ((int)$cVen==3) { //show
                $dTot=$dSss+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
        }
    } //segundo lugar doble
    if ($nCab==$eSrd) { //segundo lugar	doble
        if ((int)$cVen==2) { //place
            $dTot=$dSdp+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
        if ((int)$cVen==3) { //show
            $dTot=$dSds+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
    } //segundo lugar triple
    if ($nCab==$eSrt) { //segundo lugar	triple
        if ((int)$cVen==2) { //place
            $dTot=$dStp+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
        if ((int)$cVen==3) { //show
            $dTot=$dSts+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
    }
    //tercer lugar triple
    if ($eSrd>0 && $dSdp>0 && $ePrd==0 && $dPdg==0) { //comprueba si hay empate en segundo lugar y asigna al tercer lugar dividendos
        $dTss=$dSdp;
        $eTrs=$eSrd;
    }//tercer lugar
    if (($nCab==$eTrs) || ($dTss<=0 && $cVen==3)) { //tercer lugar
        if (($dTss<=0 && $cVen==3)) {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        } else {
            if ((int)$cVen==3) { //show
                $dTot=$dTss+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($dTot / $divisor) * $mVen);
            }
        }
    } //tercer lugar doble
    if ($nCab==$eTrd) { //tercer lugar
        if ((int)$cVen==3) { //show
            $dTot=$dTds+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
    } //tercer lugar triple
    if ($nCab==$eTrt) { //tercer lugar
        if ((int)$cVen==3) { //show
            $dTot=$dTts+$mas;
            if ($dTot>$tope) {
                $dTot=$tope;
            }
            $montoapagar[0]=(($dTot / $divisor) * $mVen);
        }
    } //tercer lugar
    //echo "<br/>".$montoapagar[0];

  
    
    
    return $montoapagar;
}
// num_caballo cod_venta mon_venta eje_pri eje_pri_d eje_pri_t eje_seg eje_seg_d eje_seg_t eje_ter eje_ter_d eje_ter_t
// eje_cua eje_cua_d eje_cua_t div_exacta div_trifecta div_superfecta tope mas factor base
/*
$numCaballo,$codVenta,$montoVen,$dividendoExa,$dividendoTri,$dividendoSup,$tope,$mas,$fact,$base
*/
function jExotica2(
    $nCab,
    $cVen,
    $mVen,
    $diExaS,
    $orExaS,
    $diTriS,
    $orTriS,
    $diSupS,
    $orSupS,
    $diExaD,
    $orExaD,
    $diTriD,
    $orTriD,
    $diSupD,
    $orSupD,
    $diExaT,
    $orExaT,
    $diTriT,
    $orTriT,
    $diSupT,
    $orSupT,
    $tope,
    $mas,
    $fact,
    $base
)
{
    $montoapagar[0]=0;
    $montoapagar[1]="2";
    $nCab=explode("-", $nCab);
    $divisor=2;
    $base=2;
    $mas=$mas/10;
    if ((int)$cVen==4) {// exacta
        if ($diExaS>0) {
            $ejS=explode("/", $orExaS);
            if (($nCab[0]==$ejS[0]) && ($nCab[1]==$ejS[1] || $ejS[1]=="ALL")) {
                if ($fact<2) {
                    $ajuste=2/$fact;
                    $diExaS=$diExaS*$ajuste;
                    $fact=2;
                }
                $dTot=$diExaS+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$mVen;
            }
            if ($diExaD>0) {
                $ejD=explode("/", $orExaD);
                if (($nCab[0]==$ejD[0]) && ($nCab[1]==$ejD[1] || $ejD[1]=="ALL")) {
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diExaS=$diExaS*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diExaD+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$mVen);
                }
            }
            if ($diExaT>0) {
                $ejT=explode("/", $orExaT);
                if (($nCab[0]==$ejT[0]) && ($nCab[1]==$ejT[1] || $ejT[1]=="ALL")) {
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diExaT=$diExaT*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diExaT+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$mVen);
                }
            }
        } else {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        }
    }
    if ((int)$cVen==5) {// trifecta
        if ($diTriS>0) {
            $ejS=explode("/", $orTriS);
            if (($nCab[0]==$ejS[0]) && ($nCab[1]==$ejS[1]) && ($nCab[2]==$ejS[2] || $ejS[2]=="ALL")) {
                if ($fact<2) {
                    $ajuste=2/$fact;
                    $diTriS=$diTriS*$ajuste;
                    $fact=2;
                }
                $dTot=$diTriS+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$mVen;
            }
            if ($diTriD>0) {
                $ejD=explode("/", $orTriD);
                if (($nCab[0]==$ejD[0]) && ($nCab[1]==$ejD[1]) && ($nCab[2]==$ejD[2] || $ejD[2]=="ALL")) {
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diTriD=$diTriD*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diTriD+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$mVen);
                }
            }
            if ($diTriT>0) {
                $ejT=explode("/", $orTriT);
                if (($nCab[0]==$ejT[0]) && ($nCab[1]==$ejT[1]) && ($nCab[2]==$ejT[2] || $ejT[2]=="ALL")) {
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diTriT=$diTriT*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diTriT+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$mVen);
                }
            }
        } else {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        }
    }
    if ((int)$cVen==6) {// superfecta
        if ($diSupS>0) {
            $ejS=explode("/", $orSupS);
            if (($nCab[0]==$ejS[0]) && ($nCab[1]==$ejS[1]) && ($nCab[2]==$ejS[2]) && ($nCab[3]==$ejS[3] || $ejS[3]=="ALL")) {
                if ($fact<2) {
                    $ajuste=2/$fact;
                    $diSupS=$diSupS*$ajuste;
                    $fact=2;
                }
                $dTot=$diSupS+$mas;
                if ($dTot>$tope) {
                    $dTot=$tope;
                }
                $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$mVen;
            }
            if ($diSupD>0) {
                $ejD=explode("/", $orSupD);
                if (($nCab[0]==$ejD[0]) && ($nCab[1]==$ejD[1]) && ($nCab[2]==$ejD[2]) && ($nCab[3]==$ejD[3] || $ejD[3]=="ALL")) {
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diSupD=$diSupD*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diSupD+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$mVen);
                }
            }
            if ($diSupT>0) {
                $ejT=explode("/", $orSupT);
                if (($nCab[0]==$ejT[0]) && ($nCab[1]==$ejT[1]) && ($nCab[2]==$ejT[2]) && ($nCab[3]==$ejT[3] || $ejT[3]=="ALL")) {
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diSupT=$diSupT*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diSupT+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$mVen);
                }
            }
        } else {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        }
    }
    if ((int)$cVen==7) { //exacta permuta
        if ($diExaS>0) {
            $ejS=explode("/", $orExaS);
            if (in_array($nCab[0], $ejS, true)) {
                if (in_array($nCab[1], $ejS, true) || in_array("ALL", $ejS, true)) {
                    $monJu7=$mVen/2;
                    if ($fact<2) {
                        $ajuste=2/$fact;
                        $diExaS=$diExaS*$ajuste;
                        $fact=2;
                    }
                    $dTot=$diExaS+$mas;
                    if ($dTot>$tope) {
                        $dTot=$tope;
                    }
                    $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$monJu7;
                }
            }
            if ($diExaD>0) {
                $ejD=explode("/", $orExaD);
                if (in_array($nCab[0], $ejD, true)) {
                    if (in_array($nCab[1], $ejD, true) || in_array("ALL", $ejD, true)) {
                        $monJu7=$mVen/2;
                        if ($fact<2) {
                            $ajuste=2/$fact;
                            $diExaD=$diExaD*$ajuste;
                            $fact=2;
                        }
                        $dTot=$diExaD+$mas;
                        if ($dTot>$tope) {
                            $dTot=$tope;
                        }
                        $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$monJu7);
                    }
                }
            }
            if ($diExaT>0) {
                $ejT=explode("/", $orExaT);
                if (in_array($nCab[0], $ejT, true)) {
                    if (in_array($nCab[1], $ejT, true) || in_array("ALL", $ejT, true)) {
                        $monJu7=$mVen/2;
                        if ($fact<2) {
                            $ajuste=2/$fact;
                            $diExaT=$diExaT*$ajuste;
                            $fact=2;
                        }
                        $dTot=$diExaT+$mas;
                        if ($dTot>$tope) {
                            $dTot=$tope;
                        }
                        $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$monJu7);
                    }
                }
            }
        } else {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        }
    }
    if ((int)$cVen==8) { // trifecta permuta
        if ($diTriS>0) {
            $ejS=explode("/", $orTriS);
            if (in_array($nCab[0], $ejS, true)) {
                if (in_array($nCab[1], $ejS, true)) {
                    if (in_array($nCab[2], $ejS, true) || in_array("ALL", $ejS, true)) {
                        $monJu8=$mVen/6;
                        if ($fact<2) {
                            $ajuste=2/$fact;
                            $diTriS=$diTriS*$ajuste;
                            $fact=2;
                        }
                        $dTot=$diTriS+$mas;
                        if ($dTot>$tope) {
                            $dTot=$tope;
                        }
                        $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$monJu8;
                    }
                }
            }
            if ($diTriD>0) {
                $ejD=explode("/", $orTriD);
                if (in_array($nCab[0], $ejD, true)) {
                    if (in_array($nCab[1], $ejD, true)) {
                        if (in_array($nCab[2], $ejD, true) || in_array("ALL", $ejD, true)) {
                            $monJu8=$mVen/6;
                            if ($fact<2) {
                                $ajuste=2/$fact;
                                $diTriD=$diTriD*$ajuste;
                                $fact=2;
                            }
                            $dTot=$diTriD+$mas;
                            if ($dTot>$tope) {
                                $dTot=$tope;
                            }
                            $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$monJu8);
                        }
                    }
                }
            }
            if ($diTriT>0) {
                $ejT=explode("/", $orTriT);
                if (in_array($nCab[0], $ejT, true)) {
                    if (in_array($nCab[1], $ejT, true)) {
                        if (in_array($nCab[2], $ejT, true) || in_array("ALL", $ejT, true)) {
                            $monJu8=$mVen/6;
                            if ($fact<2) {
                                $ajuste=2/$fact;
                                $diTriT=$diTriT*$ajuste;
                                $fact=2;
                            }
                            $dTot=$diTriT+$mas;
                            if ($dTot>$tope) {
                                $dTot=$tope;
                            }
                            $montoapagar[0]=$montoapagar[0]+((($base/$fact)*($dTot/$divisor))*$monJu8);
                        }
                    }
                }
            }
        } else {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        }
    }
    if ((int)$cVen==9) { // superfecta permuta
        if ($diSupS>0) {
            $ejS=explode("/", $orSupS);
            if (in_array($nCab[0], $ejS, true)) {
                if (in_array($nCab[1], $ejS, true)) {
                    if (in_array($nCab[2], $ejS, true)) {
                        if (in_array($nCab[3], $ejS, true) || in_array("ALL", $ejS, true)) {
                            $monJu9=$mVen/24;
                            if ($fact<2) {
                                $ajuste=2/$fact;
                                $diSupS=$diSupS*$ajuste;
                                $fact=2;
                            }
                            $dTot=$diSupS+$mas;
                            if ($dTot>$tope) {
                                $dTot=$tope;
                            }
                            $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$monJu9;
                        }
                    }
                }
            }
            if ($diSupD>0) {
                $ejD=explode("/", $orSupD);
                if (in_array($nCab[0], $ejD, true)) {
                    if (in_array($nCab[1], $ejD, true)) {
                        if (in_array($nCab[2], $ejD, true)) {
                            if (in_array($nCab[3], $ejD, true) || in_array("ALL", $ejD, true)) {
                                $monJu9=$mVen/24;
                                if ($fact<2) {
                                    $ajuste=2/$fact;
                                    $diSupD=$diSupD*$ajuste;
                                    $fact=2;
                                }
                                $dTot=$diSupD+$mas;
                                if ($dTot>$tope) {
                                    $dTot=$tope;
                                }
                                $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$monJu9;
                            }
                        }
                    }
                }
            }
            if ($diSupT>0) {
                $ejT=explode("/", $orSupT);
                if (in_array($nCab[0], $ejT, true)) {
                    if (in_array($nCab[1], $ejT, true)) {
                        if (in_array($nCab[2], $ejT, true)) {
                            if (in_array($nCab[3], $ejT, true) || in_array("ALL", $ejT, true)) {
                                $monJu9=$mVen/24;
                                if ($fact<2) {
                                    $ajuste=2/$fact;
                                    $diSupT=$diSupT*$ajuste;
                                    $fact=2;
                                }
                                $dTot=$diSupT+$mas;
                                if ($dTot>$tope) {
                                    $dTot=$tope;
                                }
                                $montoapagar[0]=(($base/$fact)*($dTot/$divisor))*$monJu9;
                            }
                        }
                    }
                }
            }
        } else {
            $montoapagar[1]="5";
            $montoapagar[0]=$mVen;
        }
    }
    return $montoapagar;
}
