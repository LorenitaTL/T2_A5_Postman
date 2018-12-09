<?php
	//require_once('conexion_BD.php');
	//$conexion=new Conexion();

	$conexion=mysqli_connect("127.0.0.1", "root","","bd_escuela") or die(mysql_error());

	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$cadena_json = file_get_contents('php://input');
                                    //Recibe inforación por HTTP, en este caso una cadena JsonSerializable
    $datos = json_decode($cadena_json, true);

    $pa = $datos['pa'];
	$respuesta=array();

	$sql = "SELECT Num_Control, Nombre_Alumno, Primer_Ap_Alumno, Segundo_Ap_Alumno, Edad_Alumno, Semestre, Carrera FROM alumnos WHERE Primer_Ap_Alumno='$pa'";
	$consulta = mysqli_query($conexion,$sql);

	if (mysqli_num_rows($consulta)>0) {
		//json pares, clave-valor

		$respuesta["alumnos"] = array();
		while($fila = mysqli_fetch_assoc($consulta)){

			$alumno=array();

			$alumno["nc"]= $fila["Num_Control"];
			$alumno["n"]= $fila["Nombre_Alumno"];
			$alumno["pa"]= $fila["Primer_Ap_Alumno"];
			$alumno["sa"]= $fila["Segundo_Ap_Alumno"];
			$alumno["e"]= $fila["Edad_Alumno"];
			$alumno["s"]= $fila["Semestre"];
			$alumno["c"]= $fila["Carrera"];

			array_push($respuesta["alumnos"], $alumno);
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
