<html>
	<head>
		<title>Añadir libro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
		<script type ="text/javascript" src ="funciones.js">
		</script>
		<style type = "text/css">
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
			th {background-color: #FC1F1F;}
			.odd_row{ background-color: #F74D4D; }
			.even_row{ background-color: #F88B8B; }
		</style>
	</head>
	<body>
		<?PHP
			require 'funciones.php';
			conexion($_SESSION['user'],$_SESSION['pass']);
			if (!$_SESSION['conectado']){
				header ('Location: autentificacion.php');
			}											// Directivas de Seguridad
			if (count($_POST) == 0){	
				header ('Location: vender.php');		//Actualizacion de la pagina				
			}else{
				$boton = array_keys($_POST);
				$index = encontrarboton($boton);				// Confirmacion del libro elegido //
				$index = $index + 1000;
				asociarventa($index);
			}
		?>
			<h3>¿Esta seguro de que quiere agregar este libro a Ventas?</h3>
			<table name = "venta">
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Descripcion</th>
				<th>ISBN</th>
				<tr class = "odd_row">
					<td><?PHP echo ($_SESSION['id_vendedor' . $_SESSION['filas']] != '?') ? $_SESSION['id_vendedor' . $_SESSION['filas']] : 'N/A' ;?></td>
					<td><?PHP echo ($_SESSION['nombre'. $_SESSION['filas']] != '?') ? $_SESSION['nombre'. $_SESSION['filas']] : 'N/A' ; ?></td>
					<td><?PHP echo ($_SESSION['apellido'. $_SESSION['filas']] != '?') ? $_SESSION['apellido'. $_SESSION['filas']] : 'N/A' ;?></td>
					<td><?PHP echo ($_SESSION['descripcion'. $_SESSION['filas']] != '?') ? $_SESSION['descripcion'. $_SESSION['filas']] : 'N/A' ;?></td>
					<td><?PHP echo ($_SESSION['isbn' . $_SESSION['filas']] != '?') ? $_SESSION['isbn' . $_SESSION['filas']] : 'N/A' ;?> </td>
				</tr>
			</table>
				<?PHP
					if ($_SESSION['isbn'. $_SESSION['filas']] != '?'){
						echo '<form action = "imprimir.php" method = "post">';
						echo '<input name = "vender" type = "submit" value = "Imprimir"/>';
						echo '</form>';
						echo '<a href ="asociarventa.php">Asociar Otro Libro<a/>';
					}
					$_SESSION['filas'] = $_SESSION['filas'] + 1;
					echo 'Filas		:';
					echo $_SESSION['filas'];
/*
echo '<hr/>';
echo '<h3>$_SESSION</h3>';
echo '<br/>';
var_dump($_SESSION);
echo '<br/>';
echo '<h3>$_POST</h3>';
var_dump($_POST);
echo '<hr/>';
*/
				?>
		<a href ="admin.php">Cancelar<a/>
	</body>
</html>