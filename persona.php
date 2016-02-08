<html>
	<head>
		<title>Añadir libro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
		<script type ="text/javascript" src ="funciones.js">
		</script>
		<style = "text/css">
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
			th { background-color: #A7FF55; }
			.odd_row {background-color : #9DFA7B  ; }
			.even_row {background-color : #FFFF ; }
			#NA {background-color : #A7FF55 ; }
			#ID {background-color : #9DFA7B  ;}
			#NP {background-color : #9DFA7B ; }
		</style>
	</head>
		<body>
			<?PHP
				require 'funciones.php';
/*
echo '<hr/>';
echo '<h3>$_SESSION</h3>';
var_dump($_SESSION);
echo '<br/>';
echo '<h3>$_POST</h3>';
var_dump($_POST);
echo '<hr/>';
*/
				if (!$_SESSION['conectado']){
					header ('Location: autentificacion.php');
				}											// Directivas de Seguridad
				if (count($_POST) == 0){	
					header ('Location: comprar.php');				
				}
				conexion($_SESSION['user'],$_SESSION['pass']);
				if (isset($_POST[0])){
					$boton = array_keys($_POST);
					$index = encontrarboton($boton);				// Confirmacion del libro elegido //
					$index = $index + 1000;
					asociarcompra($index);
				}
				echo '<hr/>';
		?>
			<h3>¿Esta seguro de que quiere agregar este libro al Almacen?</h3>
			<table name = "compra">
				<th>ISBN</th>
				<th>Descripcion</th>
			<tr class = "odd_row">
				<td><?PHP echo $_SESSION['isbn' . $_SESSION['filas']] ; ?></td>
				<td><?PHP echo $_SESSION['descripcion'. $_SESSION['filas']] ; ?></td>
			</tr>
			</table>
			<div id = "ID">
				<h3>Asociar Persona por ID:</h3>
				<hr/>
				<form action = "listacompra.php" method = "post">
					ID	:<input name = "id" type = "name" required />
					<br/>
					<a href = "comprar.php"> << Volver </a>
					<input name = "ID" type ="submit" value ="Siguiente >>"/>
				</form>
			</div>
			<hr/>
			<div id = "NA">
				<h3>Asociar Persona por Movil</h3>	
				<form action = "listacompra.php" method = "post">
					Movil	:<input name = "movil" type = "name" required />
					<br/>
					<a href = "comprar.php"> << Volver </a>
					<input name = "M" type ="submit" value ="Siguiente >>"/>
				</form>
			</div>
				<hr/>
			<div id = "NP">
				<h3>Nueva Persona :</h3>
				<form action = "listacompra.php" method = "post">
					Nombre	:<input name = "nombre" type = "name" required />
				<br/>
				Apellido 	:<input name = "apellido" type = "name" required />
				<br/>
				Telefono	:<input name = "movil" type = "name"/>
				<br/>
				Correo	:<input name = "mail" type = "name"/>
				<br/>
					<a href = "comprar.php"> << Volver </a>
					<input name = "borrar" type ="reset" value ="Borrar"/>
					<input name = "NP" type ="submit" value ="Crear Persona"/>
				</form>
			</div>
		<?PHP
			$_SESSION['filas'] = $_SESSION['filas'] + 1;   // Asignacion de la nueva fila para un nuevo libro
			echo 'Filas		:';   
			echo $_SESSION['filas'];	
		?>
	<body>
</html>