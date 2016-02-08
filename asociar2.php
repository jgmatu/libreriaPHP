<?PHP
	require 'funciones.php';
	if (!$_SESSION['conectado']){
		header ('Location: formulario.html');
	}											// Directivas de Seguridad
	if (count($_POST) == 0){	
		header ('Location: comprar.php');				
	}
	conexion($_SESSION['user'],$_SESSION['pass']);
	if (isset($_POST[0])){
		$boton = array_keys($_POST);
		$index = encontrarboton($boton);				// Confirmacion del libro elegido //
		$index = $index + 1000;
		asociar($index);
		$_SESSION['filas'] = $_SESSION['filas'] + 1;
		echo 'Filas		:';
		echo $_SESSION['filas'];
	}
?>
<html>
	<head>
		<title>Libros</title>
		<script type ="text/javascript" src = "funciones.js">
		</script>
	</head>
	<body>
		<table name = "libros" border = "1">
			<th>ISBN</th>
			<th>Descripción</th>
			<?PHP
				for ($i = 0; $i < $_SESSION['filas'] ; $i ++){
					echo '<tr>';
					echo '<td>'.$_SESSION['isbn' . $i].'</td>';
					echo '<td>'.$_SESSION['descripcion' . $i].'<td/>';
					echo '</tr>';
				}
			?>
		</table>
		<table name ="persona" border = "1">
			<th>ID</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Correo</th>
			<th>Movil</th>
			<tr>
				<td><?PHP echo $_SESSION['id']?></td>
				<td><?PHP echo $_SESSION['nombre']?></td>
				<td><?PHP echo $_SESSION['apellido']?></td>
				<td><?PHP echo $_SESSION['mail']?></td>
				<td><?PHP echo $_SESSION['movil']?></td>
			</tr>
		</table>
		<a href = "imprimir.php">Confirmar</a>
		<a href = "asociar.php">Asociar otro Libro</a>
		<a href = "comprar.php">Cancelar</a>
