<?php
//CERRAR CONEXIONES BD
  class Procesos{
    function __construct(){
      include_once 'conexion.php';
      $this->conexion = new Conexion();
    }
    function registro($datosRegistro){
      if(!str_contains($datosRegistro['email'], 'fundacionloyola.net')){
        return $this->error(0);
      }
      $errno = $this->conexion->codigoError();
      if($errno){
        return $this->error($errno);
      }
      $sql = 'insert into usuario(nombreUsuario, correo, password) values
      ("'.$datosRegistro['nombreUsuario'].'", "'.$datosRegistro['email'].'", "'.$datosRegistro['password'].'");';
      $resultado = $this->conexion->consultar($sql);
      session_start();
      $_SESSION['idUsuario'] = $this->recuperarId($datosRegistro)['idUsuario'];
      header('Location: vistas/preferencias.php');
    }
    function inicioSesion($datosInicio){
      $sql = "select idUsuario, correo, password from usuario";
      $resultado = $this->conexion->consultar($sql);
      $sw = false;
      while($fila = $this->conexion->extraerFila($resultado)){
        if($fila['correo']==$datosInicio['email'] && $fila['password']==$datosInicio['password']){
          session_start();
          $_SESSION['idUsuario'] = $fila['idUsuario'];
          $sw = true;
          header('Location: mostrarPreferencias.php');
        }
      }
      if(!$sw){
        $this->error(1);
      }
    }
    function listar(){
      $sql = 'select nombreJuego, idJuego from juego';
      $resultado = $this->conexion->consultar($sql);
      for ($i=0; $i<$resultado->num_rows; $i++){
        $fila = $this->conexion->extraerFila($resultado);
        echo '<div><input type="checkbox" name="minijuegos[]" value="'.$fila['idJuego'].'" />
        <label for="minijuegos[]">'.$fila['nombreJuego'].'</label></div>'; //NO SE QUE PONER EN EL FOR
      }
    }
    function recuperarId($datosRegistro){
      $sql = 'select idUsuario from usuario where correo="'.$datosRegistro['email'].'"';
      $resultado = $this->conexion->consultar($sql);
      return $this->conexion->extraerFila($resultado);
    }
    function anadir(){
      foreach ($_POST['minijuegos'] as $preferencia) {
        $sql = 'insert into preferencia(idUsuario, idJuego) values ('.$_SESSION['idUsuario'].','.$preferencia.');';
        $resultado = $this->conexion->consultar($sql);
      }
      header('Location: ../index.php');
    }
    function mostrarPreferencias(){
      $sql = 'select nombreJuego from juego inner join preferencia on juego.idJuego = preferencia.idJuego
      where preferencia.idUsuario ='.$_SESSION['idUsuario'];
      $resultado = $this->conexion->consultar($sql);
      for ($i=0; $i<$resultado->num_rows; $i++){
        $fila = $this->conexion->extraerFila($resultado);
        echo '<p>'.$fila['nombreJuego'].'</p>';
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
