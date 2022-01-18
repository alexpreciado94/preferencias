<?php
  class Procesos{
    function __construct(){
      include_once 'operacionesdb.php';
      $this->operacionesdb = new OperacionesDB();
    }
    function registro($datosRegistro){
      if(!str_contains($datosRegistro['email'], 'fundacionloyola.net')){
        return $this->error(0);
      }
      $errno = $this->operacionesdb->codigoError();
      if($errno){
        return $this->error($errno);
      }
      $sql = 'insert into usuario(nombreUsuario, correo, password) values
      ("'.$datosRegistro['nombreUsuario'].'", "'.$datosRegistro['email'].'", "'.password_hash($datosRegistro['password'], PASSWORD_DEFAULT, ['cost' => 4]).'");';
      $resultado = $this->operacionesdb->consultar($sql);
      session_start();
      $_SESSION['idUsuario'] = $this->recuperarId($datosRegistro)['idUsuario'];
      $this->operacionesdb->cerrarConexion();
      header('Location: vistas/preferencias.php');
    }
    function inicioSesion($datosInicio){
      $sql = "select idUsuario, password from usuario where correo= ?";
      $stmt = $this->operacionesdb->conexion->prepare($sql);
      $stmt->bind_param('s', $datosInicio['email']);
      $stmt->execute();
      $resultado = $stmt->get_result();
      $sw = false;
      $fila = $this->operacionesdb->extraerFila($resultado);
      if(isset($fila['idUsuario'])){
        if(password_verify($datosInicio['password'], $fila['password'])){
          session_start();
          $_SESSION['idUsuario'] = $fila['idUsuario'];
          $sw = true;
          $this->operacionesdb->cerrarConexion();
          header('Location: mostrarPreferencias.php');
        }
      }
      if(!$sw){
        $this->error(1);
      }
    }
    function listar(){
      $sql = 'select nombreJuego, idJuego from juego';
      $resultado = $this->operacionesdb->consultar($sql);
      for ($i=0; $i<$resultado->num_rows; $i++){
        $fila = $this->operacionesdb->extraerFila($resultado);
        echo '<div><input type="checkbox" name="minijuegos[]" value="'.$fila['idJuego'].'" />
        <label for="minijuegos[]">'.$fila['nombreJuego'].'</label></div>'; //NO SE QUE PONER EN EL FOR
      }
      $this->operacionesdb->cerrarConexion();
    }
    function recuperarId($datosRegistro){
      $sql = 'select idUsuario from usuario where correo="'.$datosRegistro['email'].'"';
      $resultado = $this->operacionesdb->consultar($sql);
      return $this->operacionesdb->extraerFila($resultado);
    }
    function anadir(){
      foreach ($_POST['minijuegos'] as $preferencia) {
        $sql = 'insert into preferencia(idUsuario, idJuego) values ('.$_SESSION['idUsuario'].','.$preferencia.');';
        $resultado = $this->operacionesdb->consultar($sql);
      }
      $this->operacionesdb->cerrarConexion();
      header('Location: ../index.php');
    }
// ¡¡¡HACE FALTA BORRADO EN CASCADA EN LA TABLA PREFERENCIA!!!
    function mostrarPreferencias(){
      $sql = 'select nombreJuego from juego inner join preferencia on juego.idJuego = preferencia.idJuego
      where preferencia.idUsuario ='.$_SESSION['idUsuario'];
      $resultado = $this->operacionesdb->consultar($sql);
      for ($i=0; $i<round($resultado->num_rows/4, PHP_ROUND_HALF_UP); $i++){
        $j = 0;
        echo '<ul>';
        while ($resultado->num_rows && $j<4){
          if ($fila = $this->operacionesdb->extraerFila($resultado)) {
            echo '<li><p>'.$fila['nombreJuego'].'</p></li>';
          }
          $j++;
        }
        echo '</ul>';
      }
    }
    function error($errno){
      switch ($errno) {
        case 0:
          echo 'El correo no pertenece a la Fundación';
          break;
        case 1:
          echo 'El correo o la contraseña son incorrectos';
          break;
        case 1062:
          echo 'El correo introducido ya está registrado';
          break;
        case 1406:
          echo 'Uno de los campos tiene una longitud mayor de la permitida';
          break;
        default:
          echo 'Ha ocurrido un error inesperado';
          break;
      }
	  }
  }
