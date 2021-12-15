<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Registro Preferencias</title>
  </head>
  <body>
    <?php
      include_once 'php/procesos.php';
      $procesos = new Procesos();
      if(isset($_POST['enviar'])){
        $procesos->registro($_POST);
      }
    ?>
    <main>
      <form action="index.php" method="POST">
        <h1>Regístrate Ya!!!</h1>
        <input type="text" name="nombreUsuario" placeholder="Nombre Usuario..." required />
        <input type="email" name="email" placeholder="E-Mail..." required />
        <input type="password" name="password" placeholder="Contraseña..." required />
        <input type="submit" name="enviar" value="ENVIAR" />
      </form>
    </main>
  </body>
</html>
