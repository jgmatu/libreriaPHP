<html>
	<head>
		<title>Compra de Libro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">	
		<script type = "text/javascript" src = "funciones.js">
		</script>
		<style type = "text/css">
			th {background-color: #FC1F1F;}
			.odd_row{ background-color: #F74D4D; }
			.even_row{ background-color: #F88B8B; }
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
		</style>
	</head>
	<body>
		<h3>Nueva Venta</h3>
		<?PHP
			require 'funciones.php';
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
			if (!$_SESSION['conectado']){				// Directiva de Seguridad
				header ('Location: autentificacion.php');
			}
			if (isset($_SESSION['filas'])){
				inicializarfilas($_SESSION['filas']);	// Inicializar venta
				$_SESSION['filas'] = 0;
			}else {
				$_SESSION['filas'] = 0;
			}
			conexion($_SESSION['user'],$_SESSION['pass']);
			$pagina = 'vender.php';
			$siguiente = 'listadoventa.php';
			generarventa($pagina,$siguiente);
		?>
		</table>
		<a href = "admin.php">Volver</a>
	</body>
</html>