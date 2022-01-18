<?php
  class OperacionesDB{
    function __construct(){
      include_once 'configdb.php';
      $this->conexion = new mysqli(SERVIDORDB, USUARIO, CONTRASENA, BASEDATOS);
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
    function cerrarConexion(){
      $this->conexion->close();
    }
  }
