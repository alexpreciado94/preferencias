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
        <?php
          include_once '../php/procesos.php';
          $procesos = new Procesos();
          $procesos->mostrarPreferencias();
        ?>
      </div>
    </main>
  </body>
</html>
