<html>
	<head>
		<title>Compra de Libro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">	
		<script type = "text/javascript" src = "funciones.js">
		</script>
		<style type = "text/css">
			th { background-color: #A7FF55; }
			.odd_row {background-color : #9DFA7B  ; }
			.even_row {background-color : #A3F8B3 ; }
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
			a{color : #000 ; }
			h3 {color : #000 ; }
			p {color : #000 ; }
		</style>
	</head>
	<body>
	<?PHP
		require 'funciones.php';        
	?>
	<div id = "content">
		<table id = "tabhead" align = "center" border = "1">
			<tr>
				<td><h2><a href = "index.php">Inicio</a></h2></td>
				<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
				<td><h2><a href = "admin.php">Administración</a></h2></td>
			</tr>
		</table>
		<h3 align = "center">Nuevo depósito de Libros</h3>
		<?PHP
			if (isset($_SESSION['filas'])){     // Inicializacion de la persona y de filas y nuevo si existe la variable global filas
 				inicializarfilas($_SESSION['filas']);
				$_SESSION['nuevo'] = False;
				$_SESSION['filas'] = 0;
			}else  {
				$_SESSION['filas'] = 0;
			}
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
				header ('Location: autentificacion.php'); // Directiva de Seguridad
			}else {
				conexion($_SESSION['user'],$_SESSION['pass']); 
				$pagina= 'comprar.php';
				$siguiente = 'persona.php';
				generarcompra($pagina,$siguiente); // Tabla de libros de la base de datos para comprar
				mysql_close($_SESSION['link']);
			}
		?>
	</div>
		<a href = "admin.php"><< Volver </a>
	</body>
</html>