<?PHP
	session_start();
	session_id();
	function conexion ($username, $password) 
	{
		$_SESSION['conectado'] = false;
		$server = '127.0.0.1';
		$data = 'libreria';
		$link = mysql_connect ($server,$username,$password);
		if ($link){
			$bbdd = mysql_select_db($data);
			if ($bbdd){
				$_SESSION['conectado'] = true;
			}else {
				echo ('No ha seleccionado la Base de Datos' . mysql_error());
			}
		}else {
			echo ('No se ha podido conectar con la Base de Datos' . mysql_error());
		}
		$_SESSION['link'] = $link;
	}
	function filtro ($pagina)
	{
		echo '<form id = "filtro"action = '.$pagina . ' method = post>';
		echo '<tr>';
		echo '<p>ISBN	:<td><input name = "isbn"  type = "name"/></td>';
		echo 'Descripcion	:<td><input name = "descripcion"  type = "name"/></td>';
		echo '<td><input name = "buscar"  type = "submit" value = "Buscar"/></td></td>';
		echo '</p></tr>';
		echo '</form>'; 
	}
	function consultalibros ($query , $pagina)
	{
		$result = mysql_query ($query);
		if (!$result) {
			echo ('No se ha seleccionado ninguna fila');
		}else {
			filtro($pagina);
			echo '<table>';
			echo	'<tr>';
			echo	 '<th>ISBN</th>';
			echo	 '<th>Descripcion</th>';
			echo	'<th>Cantidad</th>';
			echo	'</tr>';
			$odd = True;
			while ($row = mysql_fetch_assoc($result)){
				echo ($odd == True) ? '<tr class = "odd_row">' : '<tr class = "even_row">';
				$odd = !$odd;
				echo '<td>' .$row['isbn']. '</td>';
				echo '<td>' .$row['descripcion']. '</td>';
				echo '<td>' .$row['cantidad']. '</td>';
				echo '</tr>';
			}
			echo '</table>';
			mysql_free_result($result);
		}
	}
	function generargenerico ($pagina)
	{
		if (!isset($_POST['isbn'])){
			$_POST['isbn'] = '--Buscar--';			//Inicializacion de variables
		}
		if (!isset($_POST['descripcion'])){
			$_POST['descripcion'] = '--Buscar--';
		 }
		switch($_POST){
			case $_POST['isbn']  != "--Buscar--":
				$query = "SELECT descripcion,isbn,cantidad FROM libros 
				WHERE isbn LIKE '%" . $_POST['isbn'] . "%'  ORDER BY descripcion 
				LIMIT 40";
			break;
			case $_POST['descripcion'] != "--Buscar--":
				$query = "SELECT descripcion,isbn,cantidad FROM libros
				WHERE descripcion LIKE '%".$_POST['descripcion']."%' ORDER BY descripcion";
			break;
			default: 
				$query = "SELECT descripcion,libros.isbn,cantidad FROM libros,compraventa
				WHERE cantidad > 0 AND libros.isbn = compraventa.isbn 
				AND estado = 'Almacen' LIMIT 50";
			break;
		}
		consultalibros($query , $pagina);
	}
	function listadocompra($query , $pagina, $siguiente) 
	{
		$result = mysql_query ($query);
		if (!$result) {
			die ('No se ha seleccionado ninguna fila :'.mysql_error());
		}
		filtro($pagina);
		echo '<table name = "compra">';
		echo	'<tr>';
		echo	 '<th>ISBN</th>';
		echo	 '<th>Descripcion</th>';
		echo	'<th>Cantidad</th>';
		echo '<th><a href = "libro.php">Nuevo libro</a></th>';
		echo	'</tr>';
		$long = 0;
		$isbn = -1000;
		echo '<form action= "'.$siguiente.'"method = "POST">';
		$odd = True;
		while ($row = mysql_fetch_assoc($result)){
			echo ($odd == True) ? '<tr class = "odd_row">' : '<tr class = "even_row">';
			$odd = !$odd;
			$_POST[$long] = $row['isbn'];
			echo '<input name =' .$long .' type ="hidden" value = "'.$_POST[$long].'"/> ';
			echo '<input name ="Addrow" type ="hidden" value = "OK"/> ';
			echo '<td>' .$row['isbn']. '</td>';
			echo '<td>' .$row['descripcion']. '</td>';
			echo '<td>' .$row['cantidad']. '</td>';
			echo '<td><input name = "'.$isbn.'" type = "submit" value = "Añadir libro"/></td>';
			echo '</tr>';
			$long = $long + 1;
			$isbn = $isbn + 1;
		}
		echo '</form>';
		echo '</table>';
		mysql_free_result($result);
	}
	function generarcompra ($pagina,$siguiente)
	{
		if (!isset($_POST['isbn']) && !isset($_POST['descripcion'])){
			$_POST['descripcion'] = '';
			$_POST['isbn'] = '';
		 }
		switch($_POST){
		case $_POST['isbn'] != '':
				$query = "SELECT descripcion,isbn,cantidad FROM libros 
				WHERE isbn LIKE '%" . $_POST['isbn']  . "%' ORDER BY descripcion LIMIT 50";
		break;
		case $_POST['descripcion'] != '':
			$query = "SELECT descripcion,isbn,cantidad FROM libros
			WHERE descripcion LIKE '%".$_POST['descripcion']."%' ORDER BY descripcion LIMIT 50";
		break;
		default: 
			$query = "SELECT isbn,descripcion,cantidad FROM libros
			WHERE cantidad > 0 LIMIT 0";
		break;
		}
		listadocompra($query , $pagina ,$siguiente);
	}
	function asociarcompra ($index)
	{
		$query = "SELECT id_libro,descripcion,isbn FROM libros
		WHERE isbn ='".$_POST[$index]."'";
		$result = mysql_query($query);						//Eleccion de Añadir el libro
		if ($result && mysql_num_rows($result) != 0){
			$row = mysql_fetch_assoc($result);
			$_SESSION['isbn' . $_SESSION['filas']] = $row['isbn'];
			$_SESSION['descripcion'. $_SESSION['filas']] = $row['descripcion'];
		}else if (mysql_num_rows($result) == 0){
			echo '<h3>No Existe el libro </h3>';
		}else{
			die ('<h3> Error en la Base de datos'. mysql_error() . '</h3>');
		}
		echo '<br/>';
	}
	// Listado de libros para vender a los 
	//clientes muestra los libros que estén 
	// disponibles en el Almacen
	function listadoventa ($query,$pagina,$siguiente)
	{
		filtro($pagina);
		echo '<table name = "venta">';
		echo	'<tr>';
		echo	'<th>ID_PERSONA</th>';
		echo	 '<th>ISBN</th>';
		echo	 '<th>Descripcion</th>';
		echo	'<th>Elegir libro</th>';
		echo	'</tr>';
		$result = mysql_query($query);
		if ($result){							
			$isbn = 0;
			$id = 0;
			$long = -1000;
			$_POST[$long] = '?';
			echo '<form action= "'.$siguiente.'"method = "POST">';
			$odd = True;
			while ($row = mysql_fetch_assoc($result)){
				echo ($odd == True) ? '<tr class = "odd_row">' : '<tr class = "even_row">';
				$odd = !$odd;
				$_POST['isbn'.$isbn] = $row['isbn'];
				$_POST['id'.$id] = $row['id_vendedor'];
				echo '<input name ="isbn' .$isbn.'" type ="hidden" value = "'.$_POST['isbn'.$isbn].'"/>';
				echo '<input name ="id'.$id .'" type ="hidden" value = "'.$_POST['id'.$id].'"/> ';
				echo '<input name = "Addrow" type = "hidden"/>';
				echo '<td>' . $row['id_vendedor'] . '</td>';
				echo '<td>'. $row['isbn'] .'</td>';
				echo '<td>' . $row['descripcion'] . '</td>';
				echo '<td><input name = "'.$long.'" type = "submit" value = "Vender libro"/></td>';
				echo '<tr>';
				$id = $id + 1;
				$long = $long + 1;
				$isbn = $isbn + 1;
			}
			echo '</form>';
			mysql_free_result($result);
		}else{
			echo 'No ha funcionado la consulta' . mysql_error();
		}
	}
	function generarventa ($pagina,$siguiente)
	{
		if (!isset($_POST['isbn']) && !isset($_POST['descripcion'])){
			$_POST['isbn'] = '';
			$_POST['descripcion'] = '';
		 }
		switch($_POST){
		case $_POST['isbn']  != "":
			$query = "SELECT libros.isbn,descripcion,id_vendedor FROM compraventa,libros
			WHERE compraventa.isbn = " .$_POST['isbn']." AND libros.isbn = compraventa.isbn 
			AND estado = 'Almacen' LIMIT 50";
		break;
		case $_POST['descripcion'] != "":
			$query = "SELECT libros.isbn,descripcion,id_vendedor FROM compraventa,libros
			WHERE descripcion LIKE '%".$_POST['descripcion']."%' AND libros.isbn = compraventa.isbn 
			AND estado = 'Almacen' LIMIT 50";
		break;
		default: 
			$query = "SELECT libros.isbn,descripcion,id_vendedor FROM compraventa,libros
			WHERE libros.isbn = compraventa.isbn AND estado = 'Almacen' LIMIT 0";
		break;
		}
		listadoventa($query,$pagina,$siguiente);
	}
	function asociarventa($index)
	{
		$_SESSION['cantidad' . $_SESSION['filas']] = 0;
		$query = "SELECT libros.isbn,descripcion,cantidad,id_vendedor, nombre ,apellido FROM libros, compraventa,personas
		WHERE libros.isbn =".$_POST['isbn'. $index]." AND libros.isbn = compraventa.isbn 
		AND id_persona = id_vendedor AND estado = 'Almacen' AND id_vendedor = ".$_POST['id'.$index]."
		AND cantidad > 0 LIMIT 0 , 1";
		$result = mysql_query($query);						//Eleccion de Añadir el libro
		if ($result && mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$_SESSION['cantidad' . $_SESSION['filas']] = $row['cantidad'];
			$_SESSION['isbn' . $_SESSION['filas']] = $row['isbn'];
			$_SESSION['descripcion'. $_SESSION['filas']] = $row['descripcion'];
			$_SESSION['id_vendedor' . $_SESSION['filas']] = $row['id_vendedor'];
			$_SESSION['nombre'. $_SESSION['filas']] = $row['nombre'];
			$_SESSION['apellido'. $_SESSION['filas']] = $row['apellido'];
		}else{ 
			echo '<a href = "admin.php">Volver<a/>';
			die('<h3>No se ha seleccionado ningún libro'.mysql_error().'</h3>');
		}
		echo '<br/>';
	}
	function encontrarboton ($boton)
	{
		echo '<br/>';
		$encontrado = False;
		$pos = 0;
		while (!$encontrado && $pos != count($boton)){
			if ($boton[$pos] < 0){
				$encontrado = True;
			}else{
				$pos = $pos + 1;
			}
		}
		return $boton[$pos];
	}
	function isbnrepetido($isbn)
	{
		$repetido = False;
		$total = 0;
		for ($i = 0 ; $i < $_SESSION['filas'] ; $i++){
			$repetido = $_SESSION['isbn'.$i] == $isbn;
			if ($repetido){
				$total = $total + 1;
			}
		}
		$repetido = $total > 1;
		return $repetido;
	}
	function devolverid ($nombre,$apellido,$movil,$mail) // Devuelve el identificador de la persona que se 
											//le diga por sus caracteristicas de la base de datos se usa justo despues de haber creado la persona
	{
		$id = "?";
		$query = "SELECT id_persona FROM personas 
		WHERE nombre = '".$nombre."' AND apellido = '".$apellido."' 
		AND movil = '".$movil."' AND mail = '".$mail."'";
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$id = $row['id_persona'];
		}else if (mysql_num_rows($result) > 1){
			echo '<h3>Ya existe una persona con esa descripción</h3>';
		}else if (mysql_num_rows($result) == 0){
			$id = "?";
		}else{
			echo '<a href = "admin.php">Volver<a/>';
			die ('<h3>No se ha encontrado el ID' . mysql_error(). '</h3>');
		}
		return $id;
	}
	function confinsert($result)
	{
		if (!$result){
			echo 'Error	:';
			echo mysql_error();
			echo '<br/>';
		}
	}
	function insertpersona($nombre,$apellido,$movil,$mail) // Insertar una nueva persona en la base de datos
	{
		$query = "INSERT INTO personas (nombre , apellido , movil , mail)
		VALUES ('".$nombre."','". $apellido ."','".$movil."','".$mail."')";
		$result = mysql_query($query);
		confinsert($result);
		echo '<br/>';
		echo 'Persona Agregada a la libreria';
		echo '<br/>';
	}
	function addlibro ($isbn)  // Añadir un nuevo libro ya existente con un incremento de cantidad en uno.
	{
		$cantidad = 0;
		$query = "SELECT cantidad FROM libros
		WHERE isbn ='".$isbn."'";
		$result = mysql_query($query);	
		if ($result){
			$row = mysql_fetch_assoc($result);
			$cantidad= $row['cantidad'];
			mysql_free_result($result);
		}else {
			echo 'No Tengo la cantidad de libros' . mysql_error();
		}
		$cantidad = $cantidad + 1;
		$query = "UPDATE libros 
		SET cantidad =".$cantidad.
		" WHERE isbn=".$isbn.";";
		$result = mysql_query($query);
		if (!$result){
			echo '<br/>';
			echo 'No se ha añadido el libro';
			echo '<br/>';
		}	
	}
	function insertlibro($isbn,$descripcion,$cantidad)
	{
		$query = "SELECT isbn, descripcion, cantidad FROM libros  
				WHERE isbn = '".$isbn."' LIMIT 0 , 50"; 
		$result = mysql_query($query);   // Consulta para comprobar la existencia del libro en la base de datos
		if(!$result){
			die ('Error al insertar el nuevo libro'.mysql_error());  // Error de la base de datos
		}else if (mysql_num_rows($result) == 0){
			mysql_free_result($result);   // vaciar la select de seguridad de inserccion
			$query = "INSERT INTO libros (isbn, descripcion,cantidad)
			VALUES ('". $isbn ."','".$descripcion."','".$cantidad."')";    // Inserccion del nuevo libro a la base de datos
			$result = mysql_query($query);
			confinsert($result);   // Confirmacion de la inserccion del nuevo libro a la base de datos
		}else{
			echo '<h3>Ya Existe un libro con ese ISBN No puede volver a insertarlo</h3>';  // Se muestra si ya existe un libro con ese isbn en la base de datos
		}
	}
	function addcompra($isbn,$idvendedor)
	{
		if ($idvendedor != '?'){
			$query = "INSERT INTO compraventa (isbn , id_vendedor , fecha_entrada , estado)
			VALUES ('".$isbn."','". $idvendedor . "','" . date('Y:m:d:G:i:s') . "','Almacen')";
			$result = mysql_query($query);
			confinsert($result);
		}else{
			die ('No se ha podido realizar la inserccion de la compra en la BBDD : '.mysql_error());
		}
	}
	function addventa ($isbn,$idvendedor,$cantidad)
	{
		$date = date('Y:m:d:G:i:s');
		$query = "UPDATE compraventa SET estado = 'Vendido' , fecha_salida = '".$date."' 
		WHERE isbn = '".$isbn."' AND id_vendedor = '".$idvendedor."' AND estado = 'Almacen';";
		$result = mysql_query($query);
		if (!$result){
			die ('No se ha Actualizado la tabla compraventa' .mysql_error());
		}else{
			$cantidad = $cantidad - 1;						//Añadir una nueva venta en la tabla compraventa de la base de datos
			$query = "UPDATE libros SET cantidad = ".$cantidad." 
			WHERE isbn = '".$isbn."'";
			$result = mysql_query($query);
		}
		if (!$result){
			die ('No se ha actualizado la cantidad de libros'.mysql_error());
		}
	}
	function pagar ($idvendedor,$isbn)
	{
		$query  = "UPDATE compraventa SET estado = 'Pagado' 
		WHERE estado = 'Vendido' AND id_vendedor = ".$idvendedor." AND isbn = ".$isbn.";";
		$result = mysql_query($query);
		confinsert($result);
	}
	function buscarpersonaID($id)
	{
		$_SESSION['nombre'] = '?';
		$_SESSION['apellido'] = '?';
		$_SESSION['movil'] = '?';
		$_SESSION['mail'] = '?';
		$query = "SELECT id_persona,nombre,apellido,movil,mail FROM personas 
		WHERE id_persona = '".$id . "'";
		$id = '?';
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$id = $row['id_persona'];
			$_SESSION['nombre'] = $row['nombre'];
			$_SESSION['apellido'] = $row['apellido'];
			$_SESSION['movil'] = $row['movil'];
			$_SESSION['mail'] = $row['mail'];
		}else if (mysql_num_rows($result) == 0){
			echo '<h3>No existe niguna persona con ese id</h3>'.mysql_error();
		}else{
			echo 'Error en la Base de Datos'. mysql_error();
		}
		mysql_free_result($result);
		return $id;
	}
	function buscarpersonaM($movil)
	{
		$id = '?';
		$query = "SELECT id_persona,nombre,apellido,movil,mail FROM personas 
		WHERE movil = '".$movil."'"; 
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$id = $row['id_persona'];
			$_SESSION['id'] = $row['id_persona']; 
			$_SESSION['nombre'] = $row['nombre'];
			$_SESSION['apellido'] = $row['apellido'];
			$_SESSION['movil'] = $row['movil'];
			$_SESSION['mail'] = $row['mail'];
		}else if (mysql_num_rows($result) > 1){
			echo '<h3>Hay varias personas con el mismo movil ' .$movil .'</h3>';
		}else if(mysql_num_rows($result) == 0){
			echo '<h3>No existe niguna persona con ese movil :'.$movil.'<h3/>';
		}else {
			die('Fallo en la Base de Datos' . mysql_error());
		}
		mysql_free_result($result);
		return $id;
	}
	function nuevolibroM($id)					//Añadir un Nuevo libro por Identificador de la perosona
	{
		if ($id != "?"){
			echo '<form action = "imprimir.php" method = "post">';
			echo '<a href = "admin.php"> << Volver <a/>';
			echo '<input name = "NuevoLibroM" type = "submit" value = "Confirmar">';
			echo '<form>';
		}else{
			echo '<a href = "comprar.php"> Volver <a/>';
		}
	}
	function nuevolibroID($id)					//Añadir un Nuevo libro por Identificador de la perosona
	{
		buscarpersonaID($id);
		$nombre = $_SESSION['nombre'];					// Estas variables las devuelve la funcion buscar persona por Identificador
		$apellido = $_SESSION['apellido'];
		if ($nombre != "?"){
			echo '<form action = "imprimir.php" method = "post">';
			echo '<a href = "admin.php"> << Volver <a/>';
			echo '<input name = "NuevoLibroID" type = "submit" value = "Confirmar">';
			echo '<form>';
		}else{
			echo '<a href = "comprar.php"> Volver <a/>';
		}
	}
	function nuevolibroNP()
	{
		echo '<form action = "imprimir.php" method = "post">';
		echo '<a href = "admin.php"> << Volver <a/>';
		echo '<input name = "NuevoLibroNP" type = "submit" value = "Confirmar">';
		echo '<form>';
	}
	function checkcantidad ($cantidad)
	{
		;
	}
	function espagado($estado)
	{
		$result = false;
		if ($estado == "Pagado"){
			$result = true;
		}else {
			$result = false;
		}
		return $result;
	}
	function esvendido ($estado)
	{
		$result = false;
		if ($estado == "Vendido"){
			$result = true;
		}else {
			$result = false;
		}
		return $result;
	}
	function esboton($estado)
	{
		$result = false;
		$result = !espagado($estado) && esvendido($estado);
		return $result;
	}
	function inicializarfilas ($filas)
	{
		for ($i = 0 ; $i <= $filas ; $i++){
			$_SESSION['id_vendedor'. $i] = '?';
			$_SESSION['nombre'. $i] = '?';
			$_SESSION['apellido'. $i] = '?';
			$_SESSION['isbn'. $i] = '?';
			$_SESSION['descripcion'. $i] = '?';
			$_SESSION['cantidad'. $i] = -13;
		}
	}
	function librorepetido ($isbn,$idvendedor,$estado)
	{
			$repetido = false;
			$query = "SELECT id_vendedor,estado,isbn FROM compraventa
			WHERE id_Vendedor = '". $idvendedor ."' AND isbn = ".$isbn." 
			AND estado = '".$estado."' LIMIT 0 , 30";
			$result = mysql_query($query);
			if ($result){
				if (mysql_num_rows($result) > 1){
					$repetido = true;
				}else {
					$repetido = false;
				}
			}else{
				die ('Error en la BBDDD' . mysql_error());
			}
		return $repetido;
	}
	function identificarventa($isbn,$idvendedor,$estado)
	{
		$query = "SELECT id_cv FROM compraventa
		WHERE id_Vendedor = '". $idvendedor ."' AND isbn = '".$isbn."' 
		AND estado = '".$estado."' LIMIT 0 , 30";
		$result = mysql_query($query);
		if ($result){
			$pos = 0;
			while ($row = mysql_fetch_assoc($result)){
				$id_cv[$pos] = $row['id_cv'];
				$pos = $pos + 1;
			}
		}else{
			echo 'Error en la base de datos' . mysql_error();
		}
		return $id_cv;
	}
	function addventaunica($id_cv,$isbn,$cantidad)
	{
		$date = date('Y:m:d:G:i:s');
		$query  = "UPDATE compraventa set estado = 'Vendido' , fecha_salida = '".$date."' 
		WHERE id_cv ='".$id_cv[0]."'";
		$result = mysql_query($query);
		if ($result){
			$cantidad = $cantidad - 1;						//Modificar la cantidad de libros en el almacen
			$query = "UPDATE libros SET cantidad = ".$cantidad." 
			WHERE isbn = '".$isbn."'";
			$result = mysql_query($query);
			if (!$result){
				die ('Problemas al actualizar los libros' .mysql_error());
			}
		}else{
			die ('Error en la Venta' . mysql_error());
		}
	}
	function pagounico ($id_cv)
	{
		$query  = "UPDATE compraventa SET estado = 'Pagado' 
		WHERE estado = 'Vendido' AND id_cv = '".$id_cv[0]."'";
		$result = mysql_query($query);
		confinsert($result);
	}
	function fichaID($id)
	{
		$query = "SELECT id_persona,nombre,apellido,movil,mail,descripcion,libros.isbn,estado FROM libros,personas,compraventa
		WHERE libros.isbn = compraventa.isbn AND id_persona = id_vendedor and id_persona = ".$id.";";
		$result = mysql_query($query);
		$pos = 0;
		while ($row = mysql_fetch_assoc($result)){
			$nombre = $row['nombre'];
			$apellido = $row['apellido'];
			$movil = $row['movil'];
			$correo = $row['mail'];
			$descripcion[$pos] = $row['descripcion'];
			$isbn[$pos] = $row['isbn'];
			$estado[$pos] = $row['estado'];
			$pos = $pos + 1;
		}
		echo '<h3 align = "center">Ficha personal Segunda Mano	 </h3>';
		echo '<h3>Datos Personales	:</h3>';
		echo '<br/>';
		echo '<h4>ID	: ' . $id . '</h4>';
		echo 'Nombre	: ' . $nombre;
		echo '<br/>';
		echo '<br/>';
		echo 'Apellidos	: ' . $apellido;
		echo '<br/>';
		echo '<br/>';
		echo 'Movil	: ' . $movil;
		echo '<br/>';
		echo '<br/>';
		echo 'Correo	: ' . $correo;
		echo '<hr/>';
		echo '<h3>Libros en Depósito	: </h3>';
		$len = mysql_num_rows($result);
		echo '<ol>';
		for ($i = 0 ; $i < $len ; $i++){
			echo '<li>';
			echo 'ISBN	: ' . $isbn[$i];
			echo '<br/>';
			echo 'Descripcion	: ' . $descripcion[$i];
			echo '<br/>';
			echo 'Estado	: ' . $estado[$i];
			echo '<br/>';
			echo '<br/>';
			echo '</li>';
		}
		echo '</ol>';
		echo '<hr/>';	
		aviso();
	}
		function fichaM($movil)
	{
		$query = "SELECT id_persona,nombre,apellido,movil,mail,descripcion,libros.isbn,estado FROM libros,personas,compraventa
		WHERE libros.isbn = compraventa.isbn AND id_persona = id_vendedor and movil = ".$movil.";";
		$result = mysql_query($query);
		$pos = 0;
		while ($row = mysql_fetch_assoc($result)){
			$id = $row['id_persona'];
			$nombre = $row['nombre'];
			$apellido = $row['apellido'];
			$movil = $row['movil'];
			$correo = $row['mail'];
			$descripcion[$pos] = $row['descripcion'];
			$isbn[$pos] = $row['isbn'];
			$estado[$pos] = $row['estado'];
			$pos = $pos + 1;
		}
		echo '<h3 align = "center">Ficha personal Segunda Mano	</h3>';
		echo '<h3>Datos Personales	:</h3>';
		echo '<h4>ID	: ' . $id . '</h4>';
		echo 'Nombre	: ' . $nombre;
		echo '<br/>';
		echo '<br/>';
		echo 'Apellidos	: ' . $apellido;
		echo '<br/>';
		echo '<br/>';
		echo 'Movil	: ' . $movil;
		echo '<br/>';
		echo '<br/>';
		echo 'Correo	: ' . $correo;
		echo '<hr/>';
		echo '<h3>Libros en Depósito	: </h3>';
		$len = mysql_num_rows($result);
		echo '<ol>';
		for ($i = 0 ; $i < $len ; $i++){
			echo '<li>';
			echo 'ISBN	: ' . $isbn[$i];
			echo '<br/>';
			echo 'Descripcion	: ' . $descripcion[$i];
			echo '<br/>';
			echo 'Estado	: ' . $estado[$i];
			echo '<br/>';
			echo '<br/>';
			echo '</li>';
		}
		echo '</ol>';
		echo '<hr/>';
		aviso();
	}
	function aviso ()
	{
		echo '<h3 align = "center">¡¡Aviso Importante!! ¡¡No tirar esta ficha!!</h3>';
		echo '<h4>La pérdida de esta ficha es responsabilidad del usuario, si no se presenta será mas dificil una buena gestión de sus libros de segunda mano en la libreria, no pudiendo ser pagados o reclamados</h4>';
	}
?>
