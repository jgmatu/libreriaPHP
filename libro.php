<html>
	<head>
	<title> Añadir Libro </title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
	<script type = "text/javascript">
		function validar(form , permitidos)
		{
			alert("Hola");
			var cantidad = document.getElementById("cantidad").value
			alert(cantidad);
			if (cantidad.length == 0){
 				alert("Tienes que insertar un valor numérico")
				return false
			}else{
				return true
			}
		}
	</script>
	<style type = "text/css">
		body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
		hr{
			color : blue;
		}
		#ID {background-color : #FF9 ; } 
		#Movil {background-color : #BB3; } 
		#NP {background-color : #DD3; } 
	</style>
	</head>
	<body background = "libroo.jpeg">
		<?PHP	
			include 'funciones.php';
			conexion($_SESSION['user'],$_SESSION['pass']);
			$_SESSION['id'] = '?';
			$_SESSION['nombre'] = '?';
			$_SESSION['apellido'] = '?';
			$_SESSION['movil'] = -13;
			$_SESSION['mail'] = '?';
			$_SESSION['isbn'] = '?';
			$_SESSION['descripcion'] = '?';
			$_SESSION['cantidad'] = -13;
		?>
	<h3 align = "center">Rellenar un único formulario de color</h3>
	<div id = "container">
	<hr/>
	<h3>Asociar Persona por ID:</h3>
	<hr/>
	<div id = "ID">
		<form action = "nuevo.php" method = "post">
			<fieldset>
			<legend>Libro Nuevo</legend>
			ISBN : <input name = "isbn" type = "name" required /><br/>
			Descripción :<input name = "descripcion" type = "name" required /><br/>
			Cantidad	:<input name = "cantidad" type = "number" required /><br/>
			</fieldset>
			<fieldset>
			<legend> Identificador de Persona</legend>
			ID	:<input name = "id" type = "name" required />
			<br/>
			</fieldset>
			<a href = "comprar.php"> << Volver </a>
			<input name = "borrar" type ="reset" value ="Borrar"/>
			<input name = "ID" type ="submit" value ="Siguiente >>"/>
		</form>
	</div>
	<hr/>
	<h3>Asociar Persona por Nombre y Apellido</h3>
	<hr/>	
	<div id = "Movil">
		<form action = "nuevo.php" method = "post">
			<fieldset>
			<legend>Libro nuevo</legend>
			ISBN : <input name = "isbn" type = "name" required /><br/>
			Descripción :<input name = "descripcion" type = "name" required /><br/>
			Cantidad	:<input name = "cantidad"  type = "number" required /><br/>
			</fieldset>
			<fieldset>
			<legend>Movil</legend>
			Movil	:<input name = "movil" type = "name" required /><br/>
			</fieldset>
			<a href = "comprar.php"> << Volver </a>
			<input name = "borrar" type ="reset" value ="Borrar"/>
			<input name = "M" type ="submit" value ="Siguiente >>"/>
			<br/>
		</form>
	</div>
	<hr/>
	<h3>Nueva Persona </h3>
	<hr/>
	<div id = "NP">
	<form action = "nuevo.php" method = "post">
		<fieldset>
		<legend>Libro Nuevo</legend>
		ISBN : <input name = "isbn" type = "name" required /><br/>
		Descripción :<input name = "descripcion" type = "name" required /><br/>
		Cantidad	:<input name = "cantidad" id = "cantidad" type = "number" required /><br/>
		</fieldset>
		<fieldset>
		<legend>Nueva Persona</legend>
		Nombre	:<input name = "nombre" type = "name" required />
		<br/>
		Apellido 	:<input name = "apellido" type = "name" required />
		<br/>
		Telefono	:<input name = "movil" type = "name"/>
		<br/>
		Correo	:<input name = "mail" type = "name"/>
		<br/>
		</fieldset>
		<a href = "comprar.php"> << Volver </a>
		<input name = "borrar" type ="reset" value ="Borrar"/>
		<input name = "NP" type ="submit" value ="Siguiente >>"/>
	</form>
	</div>
	<hr/>
	<a href = "comprar.php" > << Atrás <a/>
	<hr/>
	<?PHP
		if (!$_SESSION['conectado']){
			header ('Location: autentificacion.php');
		}
	?>
	</div>
	</body>
</html>