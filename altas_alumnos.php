<?php
  if (!($conexion = mysqli_connect('127.0.0.1', 'root', '','bd_escuela'))) {
    die("Falló la conexión!!, ERROR: ".mysqli_connect_error());
  }

  if ($_SERVER['REQUEST_METHOD']=='POST') {
    $cadena_json = file_get_contents('php://input');
                                    //Recibe inforación por HTTP, en este caso una cadena JsonSerializable
    $datos = json_decode($cadena_json, true);

    $nc = $datos['nc'];
    $n = $datos['n'];
    $pa = $datos['pa'];
    $sa = $datos['sa'];
    $e = $datos['e'];
    $s = $datos['s'];
    $c = $datos['c'];

    $sql = "INSERT INTO alumnos VALUES('$nc','$n','$pa','$sa',$e,$s,'$c')";

    //echo json_encode($sql);

    $resultado = mysqli_query($conexion,$sql);;

    $respuesta = array();

    if ($resultado) {
      $respuesta['exito'] = 1;
      $respuesta['msj'] = 'Insercion correcta';
      echo json_encode($respuesta);
    }else {
      $respuesta['exito'] = 0;
      $respuesta['msj'] = 'Error en la insercion';
      echo json_encode($respuesta);
    }
  }
 ?>
