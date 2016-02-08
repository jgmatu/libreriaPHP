<html>
	<head>
		<title>Compra de Libro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">	
		<script type = "text/javascript" src = "funciones.js">
		</script>
	</head>
	<body>
	<div id = "content">
		<table id = "tabhead" align = "center" border = "1">
			<tr>
				<td><h2><a href = "index.php">Inicio</a></h2></td>
				<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
				<td><h2><a href = "admin.php">Administración</a></h2></td>
			</tr>
		</table>
		<?PHP
			require 'funciones.php';
			if (!$_SESSION['conectado']){
				header ('Location: formulario.php');
			} 
			conexion($_SESSION['user'],$_SESSION['pass']);
			$pagina= 'asociar.php';
			$siguiente = 'asociar2.php';
			echo 'Filas		:';
			echo $_SESSION['filas'];
			generarcompra($pagina,$siguiente);
			mysql_close($_SESSION['link']);
		?>
	</div>
	</body>
</html>