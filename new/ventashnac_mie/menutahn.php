<script language="javascript"> 
	function reimprimir() { 
	propiedades="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_reimprimir_hnac.php","_blank",propiedades); 
	}
	function reimprimeult() { 
	propiedades="width=230,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_reimprimir_ultimo_hnac.php","_blank",propiedades); 
	} 
	function dividendos() { 
	propiedades2="width=420,height=800,menubar=no,maximize=no,resizable=no,left=20,fullscreen=no,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventashnac_mie/incluir_modificar_dividendos_hnac.php","_blank",propiedades2); 
	} 
	function winners() { 
	window.open("../gacetas/index.php","_blank"); 
	} 
	function premio(){ 
	pr10="width=375,height=760,left=0,top=0,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_tickets_premiados.php","_blank",pr10); 
	} 	
	function gacetas() { 
	window.open("http://www.tuhipismo.net/simulcast/","_blank"); 
	} 
	function cuadre(){ 
	propiedades9="width=500,height=560,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_reporte_cuadre_hnac.php","_blank"); 
	} 
	function reportejugada() { 
	propiedades4="fullscreen=yes,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventashnac_mie/ventas_reporte_jugadas_hnac.php","_blank"); 
	} 
	function mensajes() { 
	pro4="width=820,height=465,Aresizable=no,location=no,menubar=no,left=20,top=20,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/chat_ventasmie_hnac.php","_blank",pro4); 
	} 
	function cambio() 
	{ 
	pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
	pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); 
	} 
	function car_programadas() { 
	pro3="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/carreras_hoy_hnac.php","_blank",pro3); 
	}
	function cambioticket() 
	{ 
	pro4="width=340,height=380,Aresizable=no,location=no,menubar=no,scrollbars=no,";
	pro5="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventashnac_mie/ventas_configurar_ticket.php","_blank",pro4+pro5); 
	} 
	function veropciones() 
		{ 
	pro1="width=980,height=620,Aresizable=yes,location=no,menubar=no,scrollbars=yes,";
	pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventashnac_mie/ventas_ver_opciones_nac.php","_blank",pro1+pro2); 
	} 
</script>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Reimprimir
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:reimprimeult()">Reimprimir Ultimo Ticket</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:reimprimir()">Reimprimir</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Resultados y Retirados
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:dividendos()">Dividendos<br/>y retirados</a>

        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Gacetas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:winners()">Gacetas</a>
          <div class="dropdown-divider"></div>

        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Reportes y Cuadres
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:reportejugada()">Reporte<br/> de jugadas</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:cuadre()">Cuadre de<br/>Caja</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Configuraciones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:veropciones()">Ver opciones activas e <br/>inactivas de taquilla</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:cambioticket()">Configurar ticket</a>
          <div class="dropdown-divider"></div>

        </div>
      </li>


    <!-- Inicio dropdown -->
  
  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Ir a Carreras Americanas o Parley
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php if ($dist_vende_amex==1 && $agen_vende_amex==1 && $taq_vende_amex==1) { ?>
          <?php if ($est_ame==1) {?>
          <a class="dropdown-item" href="../ventas/index.php">Ir a Carreras<br/>Americanas</a>
          <?php }?>
          <?php }?>
          <div class="dropdown-divider"></div>
          <?php if ($dist_vende_parley==1 && $agen_vende_parley==1 && $taq_vende_parley==1) { ?>

          <a class="dropdown-item" href="../parley/1taparley.php">Ir a <br/>Parley</a>
          <?php }?>
        </div>
      </li>
      
      <!-- Fin dropdown -->


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Volver o Salir
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../acceso.php">Volver a Seleccion</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../ventas/cerrar_sesion_vendedor.php">Salir</a>
        </div>
      </li>
    </ul>

  </div>
</nav>