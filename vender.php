<html>
	<head>
		<title>Compra de Libro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">		
		<script type = "text/javascript" src = "funciones.js">
		</script>
		<style type = "text/css">
			th { background-color: #FC1F1F; }
			.odd_row{ background-color: #F74D4D; }
			.even_row{ background-color: #F88B8B; }
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
			h3 {color: #000 ;}
			p{color: #000 ;}
			a {color : #000 ;}
		</style>
	</head>
	<body>
		<table id = "tabhead" align = "center" border = "1">
			<tr>
				<td><h2><a href = "index.php">Inicio</a></h2></td>
				<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
				<td><h2><a href = "admin.php">Administración</a></h2></td>
			</tr>
		</table>
		<h3 align = "center">Nueva Venta</h3>
		<?PHP
			require 'funciones.php';
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
		<a href = "admin.php"><< Volver</a>
	</body>
</html>