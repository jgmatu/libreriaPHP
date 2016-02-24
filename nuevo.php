<html>
	<head>
		<title>Añádido</title>
	</head>
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
	<body>
		<?PHP
			include 'funciones.php';
			conexion($_SESSION['user'],$_SESSION['pass']);
			switch ($_POST){
				case isset($_POST['ID']);
					echo '<br/>';
					echo '<h3>Vas ha añadir un libro nuevo por IDENTIFICADOR</h3>';
					echo '<br/>';
					$_SESSION['isbn'] = $_POST['isbn'];
					$_SESSION['descripcion'] = $_POST['descripcion'];
					$_SESSION['cantidad'] = $_POST['cantidad'];
					$id = buscarpersonaID($_POST['id']);
					$_SESSION['id'] = $id;  // Es necesaria para pasar el identificador a la siguiente pagina y poder imprimir el libro por el ID
				break;
				case isset($_POST['M']):
					echo '<br/>';
					echo '<h3>Vas ha añadir un libro nuevo por Movil</h3>';
					echo '<br/>';
					$id = buscarpersonaM($_POST['movil']);
					$_SESSION['isbn'] = $_POST['isbn'];
					$_SESSION['descripcion'] = $_POST['descripcion'];
					$_SESSION['cantidad'] = $_POST['cantidad'];
				break;
				case isset($_POST['NP']):
					echo '<br/>';
					echo '<h3>Vas ha añadir un libro nuevo por persona nueva</h3>';
					echo '<br/>';
					$id = '?';
					$_SESSION['nombre'] = $_POST['nombre']; 
					$_SESSION['apellido'] = $_POST['apellido'];
					$_SESSION['movil'] = $_POST['movil'];
					$_SESSION['mail'] = $_POST['mail'];
					$_SESSION['isbn'] = $_POST['isbn'];
					$_SESSION['descripcion'] = $_POST['descripcion'];
					$_SESSION['cantidad'] = $_POST['cantidad'];
				break;
				default:
					echo 'Redireccionar a compra...';
				break;
			}
		?>
		<table name = "nuevo">
			<?PHP if ($id != "?"){ echo '<th>ID</th>'; }?>
			<th>Nombre</th>
			<th>Apellido</th>
			<?PHP if (isset($_POST['NP'])){ echo '<th>Movil</th>'; }// Campo para nueva persona NP?> 
			<?PHP if (isset($_POST['NP'])){ echo '<th>Mail</th>'; }// Campo para nueva persona NP ?>  
			<th>ISBN</th>
			<th>Descripción</th>
			<th>Cantidad</th>
			<tr class = "odd_row">
				<?PHP if ($id != "?"){ echo '<td>'.$id.'</td>'; }?>
				<td><?PHP echo ($id != "?" || isset($_POST['NP'])) ?  $_SESSION['nombre'] : 'N/A' ;?></td>
				<td><?PHP echo ($id != "?" || isset($_POST['NP'])) ?  $_SESSION['apellido'] : 'N/A' ;?></td>
				<?PHP if (isset($_POST['NP'])){ echo '<td>'.$_SESSION['movil'].'</td>'; }//Campo para comprobar nueva persona?>  
				<?PHP if (isset($_POST['NP'])){ echo '<td>'.$_SESSION['mail'].'</td>'; } //Campo para comprobar nueva persona ?>
				<td><?PHP echo $_SESSION['isbn']?></td>
				<td><?PHP echo $_SESSION['descripcion']?></td>
				<td><?PHP echo $_SESSION['cantidad']?></td>
			</tr>
		</table>
		<?PHP
			switch ($_POST){
				case isset($_POST['ID']);
					nuevolibroID($id);
				break;
				case isset($_POST['M']):
					nuevolibroM($id);	
				break;
				case isset($_POST['NP']):
					nuevolibroNP();
				break;
				default:
					echo 'Redireccionar a compra...';
				break;
			}
		?>
	</body>
</html>