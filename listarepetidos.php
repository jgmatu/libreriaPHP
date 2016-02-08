<?PHP	
	require 'funciones.php';
	conexion('root','123456');
	$query = "select nombre,apellido,id_persona from personas
			where movil = '-';";
	$result = mysql_query($query);
	if ($result){
		echo '<h3>Personas sin movil</h3>';
		while($row = mysql_fetch_assoc($result)){
			echo 'Nombre	: ';
			echo $row['nombre'];
			echo'<br/>';
			echo 'Apellido	: ';
			echo $row['apellido'];
			echo '<br/>';
			echo 'Identificador	 : ';
			echo $row['id_persona'];
			echo '<hr/>';
		}
		mysql_free_result($result);
	}else {
		echo 'Error'.mysql_error();
	}
	$query = "select nombre,apellido,movil from personas
			group by movil having count(*) >1;";
	$result = mysql_query($query);
	if ($result){
		echo '<h3>Personas con movil repetido</h3>';
		while($row = mysql_fetch_assoc($result)){
			echo 'Nombre	: ';
			echo $row['nombre'];
			echo'<br/>';
			echo 'Apellido	: ';
			echo $row['apellido'];
			echo'<br/>';
			echo 'Movil	: ';
			echo $row['movil'];
			echo '<hr/>';
		}
		mysql_free_result($result);
	}else {
		echo 'Error'.mysql_error();
	}
	echo '<br/>';
	echo '<h2>Nombres y Apellidos Repetidos</h2>';
	$query = "Select nombre,apellido from personas
	group by nombre,apellido
	having count(*) > 1";
	$result = mysql_query($query);
	if ($result){
		while ($row = mysql_fetch_assoc($result)){
			echo 'Nombre	:';
			echo $row['nombre'];
			echo '<br/>';
			echo 'Apellido	:';
			echo $row['apellido'];
			echo '<hr/>';
		}
		mysql_free_result($result);
	}else {
		echo 'Error'.mysql_error();
	};
?>