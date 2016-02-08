<html>
	<head>
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
			th {background-color: #F3F17A;}
			.odd_row{ background-color: #7AB7F3; }
			.even_row{ background-color: #FFF; }
		</style>
		<title>Libros de Segunda Mano</title>
	</head>
	<body>
		<div id = "head">
			<div id "Menu">
				<table id = "tabhead" align = "center" border = "1">
					<tr>
						<td><h2><a href = "index.php">Inicio</a></h2></td>
						<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
						<td><h2><a href = "admin.php">Administración</a></h2></td>
					</tr>
				</table>
			</div>
		</div>
		<div id = "content">
			<h2>Contenido de Segunda mano</h2>
			<hr/>
			<?PHP
				require 'funciones.php';
				$username = 'root';
				$password = '123456';
				conexion($username,$password);
				$pagina = 'index.php';
				generargenerico($pagina);
			?>
			<?PHP
				mysql_close($_SESSION['link']);
			?>

	</body>
</html> 