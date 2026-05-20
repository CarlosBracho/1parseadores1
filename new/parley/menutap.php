    
      <?php
        if($_SESSION['camino']==0){
        ?>

<script language="javascript"> 
function cambio() 
{ 
pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); 
}
function veropciones() 
	{ 
pro1="width=980,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../parley/ver_opciones_parley.php","_blank",pro1+pro2); 
} 
</script>
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="dropdown-item" href="1taparley.php">Apostar <br/> Parley</a>
      </li>


	  	        <li class="nav-item">
         <a class="dropdown-item" href="tapcuadrecaja.php">Cuadre de<br/> Caja</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="tapreportejugadas.php">Reporte de<br/>Jugadas</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="presultados.php">Resultados</a>
      </li>
      <!--
      <li class="nav-item">
        <a class="dropdown-item" href="tappagarticket.php">Pagar<br/> Ticket</a>
      </li>
      -->
      <li class="nav-item">
        <a class="dropdown-item" href="tapeliminarticket.php">Eliminar <br/>Ticket</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="tapconfiguracion.php">Configurar</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="javascript:cambio()">Cambiar<br/>Clave</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="javascript:veropciones()">Ver<br/>Opciones</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="tapchatparley.php">Chat</a>
      </li>

      <li class="nav-item">
      <?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
        <a class="dropdown-item"  href="../../ventas/index.php">Ir a Carreras<br/>Americanas</a>
      <?php }?>

      <li class="nav-item">
      <?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
        <a class="dropdown-item" href="../../ventashnac_mie/index.php">Ir a Carreras<br/>Nacionales</a>
      <?php }?>
      </li>
      <li class="nav-item">



        <a class="dropdown-item" href="../../acceso.php">Volver<br/> A Seleccion</a>





      
      
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../apostador/cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>

  </div>
</nav>



<?php }else{?>


  <script language="javascript"> 
function cambio() 
{ 
pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); 
}
function veropciones() 
	{ 
pro1="width=980,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../parley/ver_opciones_parley.php","_blank",pro1+pro2); 
} 
</script>
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="dropdown-item" href="1taparley.php">Apostar <br/> Parley</a>
      </li>


	  	        <li class="nav-item">
         <a class="dropdown-item" href="tapcuadrecaja.php">Cuadre de<br/> Caja</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="tapreportejugadas.php">Reporte de<br/>Jugadas</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="presultados.php">Resultados</a>
      </li>
      <!--
      <li class="nav-item">
        <a class="dropdown-item" href="tappagarticket.php">Pagar<br/> Ticket</a>
      </li>
      -->
      <li class="nav-item">
        <a class="dropdown-item" href="tapeliminarticket.php">Eliminar <br/>Ticket</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="tapconfiguracion.php">Configurar</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="javascript:cambio()">Cambiar<br/>Clave</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="javascript:veropciones()">Ver<br/>Opciones</a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="tapchatparley.php">Chat</a>
      </li>

      <li class="nav-item">
      <?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
        <a class="dropdown-item"  href="../ventas/index.php">Ir a Carreras<br/>Americanas</a>
      <?php }?>

      <li class="nav-item">
      <?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
        <a class="dropdown-item" href="../ventashnac_mie/index.php">Ir a Carreras<br/>Nacionales</a>
      <?php }?>
      </li>
      <li class="nav-item">



        <a class="dropdown-item" href="../acceso.php">Volver<br/> A Seleccion</a>





      
      
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../apostador/cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>

  </div>
</nav>







  <?php }
      
      ?>