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
        <h1>Tus Preferencias:</h1>
        <?php
          include_once '../php/procesos.php';
          $procesos = new Procesos();
          $procesos->mostrarPreferencias();
        ?>
      </div>
    </main>
  </body>
</html>
