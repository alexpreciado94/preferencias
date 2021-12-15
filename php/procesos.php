<?php
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
    function error($errno){
      switch ($errno) {
        case 0:
          echo 'El correo no pertenece a la Fundación';
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
