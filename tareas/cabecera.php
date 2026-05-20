<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03" style="background: black; border-radius:25px"> 
      <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 40px; padding:auto; margin:auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php" style="color: white;">Tareas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cambiarclave.php" style="color: white;">Cambiar Clave</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./Exit.php" tabindex="-1" aria-disabled="true" style="color: white;">Salir</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" style="color: white;" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Atras</a>
        </li>

      </ul>
    </div>
  </div>
</nav>