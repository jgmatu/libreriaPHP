<html>
	<head>
		<title>Confirmar Pago</title>
	</head>
	<style type = "text/css">
		th {background-color: #00FFE2;}
		.odd_row{ background-color: #ADCCEA ; }
		.even_row{ background-color: #FFF; }
	</style>
	<body background = "libroo.jpeg">
	<?PHP
		require 'funciones.php';
		echo 'Hola Mundo';
		$encontrado = false;
		$pos = 0;
			while (!$encontrado && count($_POST) != 0){
				if (isset($_POST['pagar'.$pos])){
					$encontrado = true;
					$_POST['pagar'.$pos] = $pos;
				}else{
					$pos =$pos + 1;
				}
			}
			if (count($_POST) != 0 ) {
			echo '<br/>';
			echo $_POST['pagar'.$pos];
			echo '<br/>';
			}
		?>
		<table name = "Pagar">
			<th>ID</th>
			<th>Descripcion</th>
			<th>ISBN</th>
			<tr class = "odd_row">
				<td><?PHP echo (count($_POST) != 0) ? $_POST['id_vendedor'.$pos] : 'N/A'  ?></td>
				<td><?PHP echo (count($_POST) != 0) ? $_POST['descripcion'.$pos] : 'N/A' ?></td>
				<td><?PHP echo (count($_POST) != 0) ? $_POST['isbn'.$pos] : 'N/A'  ?></td>
			</tr>
		</table>
		<?PHP
			if (count($_POST) != 0){
				echo '<form action = "imprimir.php" method = "POST">';
				echo '<a href = "gestion.php"><< Volver<a/>';
				echo '<input name = "id_vendedor" type = "hidden" value = "'.$_POST['id_vendedor'.$pos].'"/>';
				echo '<input name = "descripcion" type = "hidden" value = "'.$_POST['descripcion'.$pos].'"/>';
				echo '<input name = "isbn" type = "hidden" value = "'.$_POST['isbn'.$pos].'"/>';
				echo '<input name = "Pagar" type = "submit" value = "Confirmar Pago"/>';
				echo '</form>';
			}else {
				echo '<a href = "gestion.php"><< Volver<a/>';
			}
		?>
	</body>
</html>