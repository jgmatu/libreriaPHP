<html>
	<head>
		<title>Pagina de Administraci�n</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">	
		<script type = "text/javascript" src = "funciones.js">
		</script>
		<style type = "text/css">
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
			h2,h3
			{
				float:center; 
				text-align:center;
			}
			table
			{
				text-align:center;
			}
			#compra {background-color : #2EFF4E;}
			#venta {background-color : #FF4848;}
			#gestion {background-color : #2EA9FF;}
			h2,h3 {
					background-color : #D032A3
					color : #000 ;
				}
			a {color : #000 ;}
			
		</style>
	</head>
	<body>
	<?PHP
		require 'funciones.php';
		$_SESSION['id'] = '?';
		$_SESSION['nombre'] = '?';
		$_SESSON['apellido'] = '?';
		$_SESSION['mail'] = '?';
		$_SESSION['movil'] = '?';
		$_SESSION['isbn'] = '?';
		$_SESSION['descripcion'] = '?';
		$_SESSION['cantidad'] = '?';
		$_SESSION['filas'] = 0;		
		if (isset ($_POST['user'])){
			$user = $_POST['user'];
			$_SESSION['user'] =$user;		//Asignacion del Usuario y contrase�a
		}
		if (isset($_POST['pass'])){
			$pass= $_POST['pass'];
			$_SESSION['pass'] = $pass;
		}
		conexion($_SESSION['user'],$_SESSION['pass']);  
		if ($_SESSION['conectado']){				// Directivas de Seguridad
			echo ('<h3>Se ha autentificado correctamente</h3>');
		}else {
			header ('Location: autentificacion.php');
		}
	?>
	<div id = "container">
		<table id = "tabhead" align = "center" border = "1">
			<tr>
				<td><h2><a href = "index.php">Inicio</a></h2></td>
				<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
				<td><h2><a href = "admin.php">Administracion</a></h2></td>
			</tr>
		</table>'
		<h2><p>Compra - Venta de Segunda Mano</p></h2>
		<h3>Esta opci�n est� solo disponible por el administrador</h3>
		<table align= "center" border = "1">
			<tr>
				<td id = "compra"><h1><a href = "comprar.php">Para Llevar libros al almacen<a/></h1><br/><p>(Compra de libros de Segunda Mano)(1 Persona)</p></td>
				<td id = "venta"><h1><a href= "vender.php">Para Sacar Libros del Almacen<a/></h1><br/><p>(Venta de Libros de Segunda Mano)(Varias Personas)</p></td>
				<td id = "gestion"><h1><a href= "gestion.php">Gesti�n<a/></h1><br/><p> (Personas y Libros)</p></td>
			</tr>
		</table>
	</div>
	<?PHP
/*
echo '<hr/>';
echo '<h3>$_SESSION</h3>';
var_dump($_SESSION);
echo '<br/>';
echo '<h3>$_POST</h3>';
var_dump($_POST);
echo '<hr/>';
*/
		mysql_close($_SESSION['link']);
	?>
	</body>
</html> 