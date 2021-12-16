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
      <form class="preferencias" action="preferencias.php" method="POST">
        <div>
          <?php
            include_once '../php/procesos.php';
            $procesos = new Procesos();
            if(isset($_POST['enviar'])){
              $procesos->anadir($_POST);
            }else{
              $procesos->listar();
            }
          ?>
        </div>
        <input type="submit" name="enviar" value="ENVIAR" />
      </form>
    </main>
  </body>
</html>
