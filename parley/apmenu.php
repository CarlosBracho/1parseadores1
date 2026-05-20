<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
				<a class="dropdown-item" href="" id="navbarDropdownPortfolio" data-toggle="dropdown" >Apostar Aqui</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
				<a href="../apostador/internacionalesa.php" class="dropdown-item">Hipismo Internacional</a>
				<?php if ($row_Recordset5['taq_vende_parley']==1) {?>
				<a href="../parley/apparley.php" class="dropdown-item">Parley</a>
				<?php }?>
				</div>
				</li>
				<li class="nav-item">
        <a class="dropdown-item" href="../apostador/reportea.php">Reporte General</a>
      </li>
	  	        <li class="nav-item">
        <a class="dropdown-item" href="../apostador/cambiomonedaa.php">Cambiar Moneda A Usar</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="../apostador/dividendosyretiradosa.php">Dividendos y Retirados</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="../gacetas/retrospectosa.php">Retrospectos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../apostador/cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>

  </div>
</nav>