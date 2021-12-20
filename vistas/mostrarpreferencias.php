<?php
  session_start();
  if(!isset($_SESSION['idUsuario'])){
    header('Location: ../index.php');
  }
?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Registro Preferencias</title>
  </head>
  <body>
    <main>
      <div class="divWrapper">
        <div class="wrapperWrapper">
          <h1>Tus Preferencias:</h1>
            <div class="wrapperPreferencias">
              <?php
                include_once '../php/procesos.php';
                $procesos = new Procesos();
                $procesos->mostrarPreferencias();
              ?>
            </div>
        </div>
      </div>
    </main>
  </body>
</html>
