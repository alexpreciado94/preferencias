<?php
  class Conexion{
    function __construct(){
      include_once 'configdb.php';
      $this->conexion = new mysqli(SERVIDORDB, USUARIO, CONTRASENA, BASEDATOS);
      //$this->conexion = new mysqli('localhost', 'root', '', 'empleadosphp');
    }
    function consultar($consulta){
      $resultado = mysqli_query($this->conexion, $consulta);
      echo $this->conexion->error;
      return $resultado;
    }
    function extraerFila($resultado){
      return mysqli_fetch_assoc($resultado);
    }
    function codigoError(){
      return $this->conexion->errno;
    }
  }
