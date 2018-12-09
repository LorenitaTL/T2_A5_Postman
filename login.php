<?php
	//require_once('conexion_BD.php');
	//$conexion=new Conexion();

	$conexion=mysqli_connect("127.0.0.1", "root","","bd_usuarios_escuela") or die(mysql_error());

	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$cadena_json = file_get_contents('php://input');
                                    //Recibe inforación por HTTP, en este caso una cadena JsonSerializable
    $datos = json_decode($cadena_json, true);

    $u = $datos['u'];
    $pass = $datos['pass'];
	$respuesta=array();

	$sql = "SELECT usuario, password FROM usuarios WHERE usuario='$u' AND password ='$pass'";
	$consulta = mysqli_query($conexion,$sql);

	if (mysqli_num_rows($consulta)>0) {
		//json pares, clave-valor

		$respuesta["usuarios"] = array();
		while($fila = mysqli_fetch_assoc($consulta)){

			$usuario=array();

			$usuario["u"]= $fila["usuario"];
			$usuario["pass"]= $fila["password"];

			array_push($respuesta["usuarios"], $usuario);
		}

		$respuesta['exito']=1;
		echo json_encode($respuesta);

	} else {
		$respuesta['exito']=0;
		$respuesta['msj']="No hay registros";//Arreglo con posicion exito y msj
		echo json_encode($respuesta);
	}
}

?>
