<!DOCTYPE html>
<html>
	<head>
		<title>Autentificación</title>
		<style type = "text/css">
		</style>
	</head>
	<body>
		<?PHP
			require 'funciones.php';
			if ($_SESSION['conectado']){
				header ('Location: admin.php');
			}
			echo $_SESSION['conectado'];
		?>
		<form action = 'admin.php' method = 'post'>
			Usuario : <input type = "name" name = "user" value = "--Escriba su Usuario--"/>
			Contraseña : <input type = "password" name = "pass"/>
			<br />
			<br />
			<input type = "submit" value = "Aceptar"/>
		</form>
	</body>
</html> 
