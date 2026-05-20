<script language="javascript"> 
	function reimprimir() { 
	propiedades="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventasmie/ventas_reimprimir.php","_blank"); 
	}
	function reimprimeult() { 
	propiedades="width=200,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
	window.open("../ventasmie/ventas_reimprimir_ultimo.php","_blank"); 
	} 
	function carreras_hoy() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/carreras_hoy.php","_blank",propiedades); 
	} 
	function dividendos() { 
	propiedades2="width=820,height=700,menubar=no,maximize=no,resizable=no,left=20,fullscreen=no,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventas/ventas_historial_lista.php","_blank"); 
	} 
	function winners() { 
	window.open("../gacetas/index.php","_blank"); 
	} 
	function gacetas() { 
	window.open("http://www.tuhipismo.net/simulcast/","_blank"); 
	} 
	function cuadre(){ 
	propiedades9="width=500,height=560,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reporte_cuadre_americana.php","_blank"); 
	} 
	function reportejugada() { 
	propiedades4="fullscreen=yes,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventas/ventas_reporte_jugadas.php","_blank"); 
	} 
	function mensajes() { 
	propiedades="width=820,height=465,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventasmie/chat_ventasmie.php","_blank",propiedades); 
	} 
function guias() { 
	propiedades="width=820,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../guias/listaguiaventasmie.html","_blank"); 
	} 
function veropciones() 
	{ 
pro1="width=980,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_ver_opciones_ame.php","_blank",pro1+pro2); 
} 
</script>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
        Gacetas y Guias
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:winners()">Gacetas</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:guias()">Guias</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Reportes y Cuadres
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" onclick="abrirmodal(4)">Reporte<br/> de jugadas</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:cuadre()">Cuadre de<br/>Caja</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Configuraciones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" onclick="abrirmodal(3)">Ver opciones activas e <br/>inactivas de taquilla</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" onclick="abrirmodal(2)">Configurar ticket</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" onclick="abrirmodal(1)">Cambiar clave</a>
        </div>
      </li>


        <!-- Inicio dropdown -->
      
  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Ir a Carreras o Parley
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
          
          <a class="dropdown-item" href="../ventashnac_mie/index.php">Ir a Carreras<br/>Nacionales</a>
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
          <a class="dropdown-item" href="cerrar_sesion_vendedor.php">Salir</a>
        </div>
      </li>
    </ul>

  </div>
</nav>