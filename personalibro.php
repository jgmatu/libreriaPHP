<html>

<head>
		<title>Persona Libro</title>
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
			th { background-color: #A7FF55; }
			.odd_row {background-color : #9DFA7B  ; }
			.even_row {background-color : #A3F8B3 ; }
		</style>
	</head>
	<body>
		<?PHP
			require 'funciones.php';
/*
	$_SESSION['id'] = "?";
	$_SESSION['nombre'] = "?";
	$_SESSION['apellido'] = "?";
	$_SESSION['movil'] = "?";
	$_SESSION['mail'] = "?";
*/
/*
echo '<hr/>';
var_dump($_SESSION);
echo '<hr/>';
*/
		conexion($_SESSION['user'],$_SESSION['pass']);
		?>
	</body>
</html>	