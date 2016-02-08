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
			th { background-color: #A7FF55; }
			.odd_row {background-color : #9DFA7B; }
			.even_row {background-color : #A3F8B3; }
			h3 { background-color: #FFF; }
		</style>
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
				header ('Location: autentificacion.php');
			} 
			conexion($_SESSION['user'],$_SESSION['pass']);
			$pagina= 'asociarcompra.php';
			$siguiente = 'asociarcompra.php';
			echo 'Filas		:';
			echo $_SESSION['filas'];
			generarcompra($pagina,$siguiente);
		?>
	</div>
	<?PHP
		if (count($_POST) != 0){
			if (isset($_POST['Addrow'])){
				$boton = array_keys($_POST);
				$index = encontrarboton($boton);				// Confirmacion del libro elegido //
				$index = $index + 1000;
				asociarcompra($index);
				$_SESSION['filas'] = $_SESSION['filas'] + 1;
			}
			echo 'Filas		:';
			echo $_SESSION['filas'];
			$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
		}
	?>
		<table name = "libros">
			<th>ISBN</th>
			<th>Descripción</th>
			<?PHP
				$odd = True;
				for ($i = 0; $i < $_SESSION['filas'] ; $i ++){
					echo ($odd == True) ? '<tr class = "odd_row">' : '<tr class = "even_row">'; // Lista de Libros de compra
					$odd = !$odd;
					echo ($_SESSION['isbn' . $i] != '?') ? '<td>' .$_SESSION['isbn' . $i] .'</td>' : '<td>N/A</td>';
					echo ($_SESSION['descripcion' . $i] != '?') ? '<td>' .$_SESSION['descripcion' . $i] .'</td>' : '<td>N/A</td>';
					echo '</tr>';
				}
			?>
		</table>
		<table name ="persona">
			<?PHP if ($id != "?"){ echo '<th>ID</th>'; }	// Campo unicamente si se tiene Identificador?>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Movil</th>
			<th>Correo</th>
			<tr class = "odd_row">
				<?PHP if ($id != "?"){ echo '<td>'.$id.'</td>'; }// Campo unicamente si se tiene Identificador?>  
				<td><?PHP echo ($_SESSION['nombre'] != '?') ? $_SESSION['nombre'] : 'N/A'?></td>
				<td><?PHP echo ($_SESSION['apellido'] != '?') ? $_SESSION['apellido'] : 'N/A'?></td>
				<td><?PHP echo ($_SESSION['movil'] != -13) ? $_SESSION['movil'] : 'N/A'?></td>
				<td><?PHP echo ($_SESSION['mail'] != '?') ? $_SESSION['mail'] : 'N/A'?></td>
			</tr>
		</table>
		<form action = "imprimir.php" method = "post">
			<?PHP echo ($_SESSION['nuevo']) ? '<input name = "comprarNP" type = "submit" value = "imprimir"/>' : '<input name = "comprarID" type = "submit" value = "imprimir"/>'?>
			<?PHP if ($_SESSION['nombre'] != '?') {echo '<a href = "asociarcompra.php">Asociar otro Libro</a>';}?>
			<a href = "comprar.php">Cancelar</a>
		</form>
	<a href = "comprar.php">Cancelar <a/>
	<?PHP 
/*
echo '<hr/>';
echo '<h3>$_SESSION :';
echo '<br/>';
var_dump($_SESSION);
echo '<br/>';
echo '<h3>$_POST	: ';
echo '<br/>';
var_dump($_POST);
echo '</h3>';
echo '<hr/>';
*/
		mysql_close($_SESSION['link']);
	?>
	</body>
</html>