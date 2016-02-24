<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
		<title>Gestión de Libros y Personas</title>
		<style type = "text/css">
			th {background-color: #00FFE2;}
			.odd_row{ background-color: #ADCCEA ; }
			.even_row{ background-color: #FFF; }
			#ID { background-color: #2EA9FF; }
			#NA { background-color: #2EA9FF; }
			body{ 
				background: url('naranja.jpeg') no-repeat center center fixed;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			} 
			h3 {color :#000 ;}
			a {color : #000 ;}
		</style>
	</head>
	<body background = "libroo.jpeg">
		<table id = "tabhead" align = "center" border = "1">
			<tr>
				<td><h2><a href = "index.php">Inicio</a></h2></td>
				<td><h2><a href = "https://maps.google.es/maps?bav=on.2,or.r_qf.&bvm=bv.69620078,d.ZGU,pv.xjs.s.es.Vq9uElIHUwM.O&biw=1112&bih=710&dpr=1&q=cuesta+de+san+francisco+las+rozas&um=1&ie=UTF-8&hq=&hnear=0xd41837c20956dcf:0x8a4a35a8ff1040be,Calle+Cuesta+San+Francisco,+28231+Las+Rozas,+Madrid&gl=es&sa=X&ei=BNOpU8C4C6qS7AbfjICYDw&ved=0CCQQ8gEwAA">Donde Estamos<a/></h2></td>
				<td><h2><a href = "admin.php">Administración</a></h2></td>
			</tr>
		</table>
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
				<input name = "buscar"  type = "submit" value = "Buscar"/>
			</fieldset>
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
					echo '<form action = "ficha.php" method = "POST">';
					echo '<input name = "ID" type = "hidden" value = "'.$_POST['id'].'"/>';
					echo '<input name = "ficha" type ="submit" value = "Ver Ficha"/>';
					echo '</form>';
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
						echo '<form action = "ficha.php" method = "POST">';
						echo '<input name = "Movil" type = "hidden" value = "'.$_POST['movil'].'"/>';
						echo '<input name = "ficha" type ="submit" value = "Ver Ficha"/>';
						echo '</form>';
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