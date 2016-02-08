<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
		<title>Gestión de Libros y Personas</title>
		<style type = "text/css">
			th {background-color: #00FFE2;}
			.odd_row{ background-color: #ADCCEA ; }
			.even_row{ background-color: #FFF; }
			#ID { background-color: #DD3; }
			#NA { background-color: #DA1; }
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
		</style>
	</head>
	<body background = "libroo.jpeg">
		<?PHP
			require 'funciones.php';
			conexion($_SESSION['user'],$_SESSION['pass']);
			$pagina = 'gestion.php';
		?>
		<h3>Buscar por Identificador</h3>
		<div id = "ID">
			<form action = "gestion.php" method = "post">
				<fieldset>
					<legend>Identificador</legend>
		Identificador    :<input  name = "id"  type = "name" required /> 
					<input name = "buscar"  type = "submit" value = "Buscar"/> 
				</fieldset>
			</form> 
		</div>
		<hr/>
		<h3>Buscar por Movil</h3>
		<div id = "NA">
			<form action = "gestion.php" method = "post">
			<fieldset>
				<legend>Movil</legend>
		Movil 	:<input  name = "movil"  type = "name" required />
			</fieldset>
				<input name = "buscar"  type = "submit" value = "Buscar"/>
			</form> 
		</div>
		<br/>
		<?PHP
			if (isset($_POST['id'])){  				// Búsqueda de personas por Identidicador y sus libros asociados de Segunda Mano	
				$query = "SELECT descripcion,estado,libros.isbn,id_vendedor FROM compraventa,libros
				WHERE libros.isbn = compraventa.isbn AND id_vendedor =" . $_POST['id'];
				$result = mysql_query($query);
				if ($result && mysql_num_rows($result) > 0){
					echo '<table name = "PersonaID">';
					echo '<th>ID</th>';		
					echo '<th>Descripcion</th>';																		
					echo '<th>Estado</th>';
					$odd = true;
					$pos = 0;
					echo '<form method = "POST" action = "pagar.php">';
					while ($row = mysql_fetch_assoc($result)){
						echo ($odd == True) ? '<tr class = "odd_row" >' : '<tr class = "even_row">';
						$odd = !$odd;
						echo '<td>'.$row['id_vendedor'].'</td>';
						echo '<td>'.$row['descripcion'].'</td>';
						echo '<td>'.$row['estado'].'</td>';
						echo '<td>';
						echo (!esboton($row['estado'])) ? 'N/A' : '<input name = "pagar'.$pos.'" type = "submit" value = "Pagar"/>';  	// Ver si el libro esta pagado';
						echo '</td>';
						echo '<td>';
						if (!espagado($row['estado'])){ echo '<input name = "descripcion' .$pos .'" type = "hidden" value = "'.$row['descripcion'].'"/>'; }	// Manda por formulario la posicion de los libros pagados y su descripcion
						if (!espagado($row['estado'])){ echo '<input name = "isbn'. $pos .'" type = "hidden" value = "'.$row['isbn'].'"/>'; }			// Manda por formulario la posicion de los libros pagados y su ISBN
						if (!espagado($row['estado'])){ echo '<input name = "id_vendedor'. $pos .'" type = "hidden" value = "'.$row['id_vendedor'].'"/>'; }			// Manda por formulario la posicion de los libros pagados y su IDvendedor
						echo '</td>';
						echo '</tr>';						
						$pos = $pos + 1;
					}
					echo '</form>';
					echo '</table>';
				}else  if (mysql_num_rows($result) == 0){
						echo '<h3>La persona '. $_POST['id'].' no existe o no tiene ningun libro en la tienda</h3>';
					}else{
						echo '<h3>Error en la base de datos</h3>' . mysql_error();
					}
			}
			if (isset($_POST['movil'])){  							// Busqueda de personas por movil y sus libros asociados de Segunda Mano
				$id = buscarpersonaM($_POST['movil']);
				if ($id != "?"){
					$query = "SELECT descripcion, estado, libros.isbn,id_vendedor FROM compraventa, libros
					WHERE libros.isbn = compraventa.isbn AND id_vendedor = ".$id."
					LIMIT 0 , 30";
					$result = mysql_query($query);
					if ($result && mysql_num_rows($result) > 0){
						echo '<table name = "PersonaID">';
						echo '<th>ID</th>';
						echo '<th>Descripcion</th>';																		
						echo '<th>Estado</th>';
						$odd = true;
						$pos = 0;
						echo '<form method = "POST" action = "pagar.php">';
						while ($row = mysql_fetch_assoc($result)){
							echo ($odd == True) ? '<tr class = "odd_row" >' : '<tr class = "even_row">';
							$odd = !$odd;
							echo '<td>'.$row['id_vendedor'].'</td>';
							echo '<td>'.$row['descripcion'].'</td>';
							echo '<td>'.$row['estado'].'</td>';
							echo '<td>';
							echo (!esboton($row['estado'])) ? 'N/A' : '<input name = "pagar'.$pos.'" type = "submit" value = "Pagar"/>';  	// Ver si el libro esta pagado';
							echo '</td>';
							echo '<td>';
							if (!espagado($row['estado'])){ echo '<input name = "descripcion' .$pos .'" type = "hidden" value = "'.$row['descripcion'].'"/>'; }	// Manda por formulario la posicion de los libros pagados y su descripcion
							if (!espagado($row['estado'])){ echo '<input name = "isbn'. $pos .'" type = "hidden" value = "'.$row['isbn'].'"/>'; }			// Manda por formulario la posicion de los libros pagados y su ISBN
							if (!espagado($row['estado'])){ echo '<input name = "id_vendedor'. $pos .'" type = "hidden" value = "'.$row['id_vendedor'].'"/>'; }			// Manda por formulario la posicion de los libros pagados y su IDvendedor
							echo '</td>';
							echo '</tr>';						
							$pos = $pos + 1;
						}
						echo '</form>';
						echo '</table>';
					}else if (mysql_num_rows($result) == 0){
						echo '<br/>';
						echo '<h3>No tiene libros Asociados</h3>';
						echo '<br/>';
					}else {
						echo 'Error en la base de datos'. mysql_error();
					}
				}else {
					echo '<br/>';
					echo '<h3>No existe la persona : 	</h3>';
					echo '<br/>';
				}
			}
		?>
	</hr>
	<a href = "admin.php"><< Volver</a>
	</hr>
	</body>
</html>