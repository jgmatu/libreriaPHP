<html>
	<head>
		<title>Compra de Libro</title>
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
			th {background-color: #FC1F1F;}
			.odd_row{ background-color: #F74D4D; }
			.even_row{ background-color: #F88B8B; }
		</style>
	</head>
	<body background = "libroo.jpeg">
		<div id = "content">
		<table id = "tabhead" align = "center" border = "1">
			<tr>
				<td><h2><a href = "index.php">Inicio</a></h2></td>
				<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
				<td><h2><a href = "admin.php">Administración</a></h2></td>
			</tr>
		</table>
		<h3>Busqueda de Venta</h3>
		<?PHP
			require 'funciones.php';
/*
echo '<h3>$_SESSION</h3>';
echo var_dump($_SESSION);
var_dump($_SESSION);
echo '<h3>$_POST</h3>';
echo '<br/>';
var_dump($_POST);
echo '<br/>';
*/			conexion($_SESSION['user'],$_SESSION['pass']);
			if (!$_SESSION['conectado']){
				header ('Location: autentificacion.php');		// Directivas de Seguridad
			} 
			
			$pagina= 'listadoventa.php';
			$siguiente = 'listadoventa.php';
			generarventa($pagina,$siguiente);
			
			if (isset($_POST['isbn0'])){
				if (isset($_POST['Addrow'])){
					$boton = array_keys($_POST);
					$index = encontrarboton($boton);				// Confirmacion del libro elegido //
					$index = $index + 1000;
					asociarventa($index);
					$_SESSION['filas'] = $_SESSION['filas'] + 1;
				}
			}
			
		?>
		</table>
		<h3>Listado de Venta</h3>
		<table name = "libros">
		<th>ID</th>
		<th>Nombre</th>
		<th>Apellido</th>
		<th>ISBN</th>
		<th>Descripción</th>
		<?PHP
			
			$odd = true;
			$pos = 0;
			while ($pos != $_SESSION['filas'] && !isbnrepetido($_SESSION['isbn' . $pos])) {
				echo ($odd == true) ? '<tr class = "odd_row">' : '<tr class = "even_row">';   // Filas del listado de la venta de Segundamano	
				$odd = !$odd;
				echo '<td>'.$_SESSION['id_vendedor' . $pos].'</td>';
				echo '<td>'.$_SESSION['nombre' . $pos].'</td>';
				echo '<td>'.$_SESSION['apellido' . $pos].'</td>';
				echo '<td>'.$_SESSION['isbn' . $pos].'</td>';
				echo '<td>'.$_SESSION['descripcion' . $pos].'</td>';
				echo '</tr>';
				$pos = $pos + 1;
			}
			
			if (isbnrepetido($_SESSION['isbn' . $pos])) { 
				// Bloquear venta por libro repetido
				echo '<br/>';
				echo '<h3>El libro esta repetido vuelva a repetir la venta</h3>';  
				echo '<br/>';
			}
			
		?>
		</table>
		<?PHP
			if ($_SESSION['filas'] == $pos){
				$pos = $pos - 1;
			}
		
			if (!isbnrepetido($_SESSION['isbn' . $pos])){  		// Arreglar problema de Inidices
				echo '<form action = "imprimir.php" method = "post">';
				echo '<input name = "vender" type = "submit" value ="Confirmar"/>';
				echo '<a href = "admin.php">Volver</a>';
				echo '</form>';
			}else {
				echo '<a href = "admin.php">Volver</a>';
			}
		
			mysql_close($_SESSION['link']);
		?>
		</div>
	</body>
</html>
