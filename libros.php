<?PHP
	require 'funciones.php';
	if (isset($_POST['persona'])){
		echo 'Persona asociada al libro			:';
		echo $_POST['persona'];
		$_SESSION['persona'] = $_POST['persona'];
		echo 'Filas		:';
		echo $_SESSION['filas'];
	}else {
		echo 'Persona asociada al libro			:';
		echo $_SESSION['persona'];
		echo '<br/>';
		echo 'Filas		:';
		echo $_SESSION['filas'];
	}
	
?>
<html>
	<head>
		<title>Libros</title>
		<script type ="text/javascript" src = "funciones.js">
		</script>
		<style type = "text/css">
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
		</style>
	</head>
	<body background = "libroo.jpeg">
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
			<tr>
				<td><?PHP echo $_SESSION['persona']?></td>
				<td><?PHP echo $_SESSION['persona']?></td>
				<td><?PHP echo $_SESSION['persona']?></td>
				<td><?PHP echo $_SESSION['persona']?></td>
			</tr>
		</table>
		<a href = "imprimir.php">Confirmar</a>
		<a href = "asociar.php">Asociar otro Libro</a>
		<a href = "comprar.php">Cancelar</a>
	</body>
</html>	