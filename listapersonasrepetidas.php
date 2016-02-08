<?PHP
	require 'funciones.php';
	conexion('root','123456');
	echo '<h2>Nombres y Apellidos Repetidos</h2>';
	$query = "Select nombre,apellido,count(*) from personas
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
	echo '<h2>Moviles Repetidos</h2>';
	$query = "Select movil,count(*) from personas
	group by movil having count(*) > 1;";
	$result = mysql_query($query);
	if ($result){
		while($row = mysql_fetch_assoc($result)){
			echo 'Movil';
			echo $row['movil'];
			echo '<hr/>';
		}
		mysql_free_result($result);
	}else{
		echo 'Error'.mysql_error();
	}
?>
