<html>
	<head>
		<title>Imprimir factura</title>
		<script type = "text/javascript" src = "funciones.js">
		</script>
	</head>
	<body>
	<?PHP
		require 'funciones.php';
		if ($_SESSION['conectado']){				// Directivas de Seguridad
				echo ('<h3>Se ha autentificado correctamente</h3>');
		}else {
			header ('Location: autentificacion.php');
		}
		conexion($_SESSION['user'],$_SESSION['pass']);
		if ($_SESSION['nombre'] != '?' || $_SESSION['filas'] != 0 || isset($_POST['Pagar'])){
			switch ($_POST){
				case isset($_POST['comprarNP']):   // Compra de Segunda Mano por Nueva Persona(NP)		
					insertpersona($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					echo 'Comprar por nueva persona		:';
					echo '<hr/>';
					echo 'ID	:' . $id;
					echo '<hr/>';
					echo 'Nombre	:  '.$_SESSION['nombre'];
					echo '<hr/>';
					echo 'Apellido	:  '. $_SESSION['apellido'];
					echo '<hr/>';
					echo 'Movil	:  '. $_SESSION['movil'];
					echo '<hr/>';
					echo 'Correo	:  '.$_SESSION['mail'];
					echo '<hr/>';
					echo 'Libros En Deposito	:';
					echo '<br/>';
					for ($i = 0 ; $i < $_SESSION['filas'] ; $i ++){
						addcompra($_SESSION['isbn'.$i],$id);
						addlibro($_SESSION['isbn'.$i]);
						echo 'ISBN	:' . $_SESSION['isbn'.$i];
						echo '<br/>';
						echo 'Descripcion	:'.$_SESSION['descripcion'.$i];
						echo '<br/>';
						$_SESSION['isbn'.$i] = '?';
						$_SESSION['descripcion'.$i] = '?';
					}
					echo '<hr/>';
				break;
			
				case isset($_POST['comprarM']) || isset($_POST['comprarID']): // Compra de libro de segunda mano normal
					$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					echo '<h3>Compra de libro de segunda mano por ID o Movil</h3>';
					echo 'ID	: ' . $id;
					echo '<hr/>';
					echo 'Nombre	: ' . $_SESSION['nombre'];
					echo '<hr/>';
					echo 'Apellido	: ' . $_SESSION['apellido'];
					echo '<hr/>';
					echo 'Movil	: ' . $_SESSION['movil'];
					echo '<hr/>';
					echo 'Correo	:  '.$_SESSION['mail'];
					echo '<hr/>';
					echo 'Libros a deposito';
					echo '<hr/>';
					for ($i = 0 ; $i < $_SESSION['filas'] ; $i ++){
						echo 'ISBN	: ' . $_SESSION['isbn'.$i];
						echo '<br/>';
						echo 'Descripcion	:' . $_SESSION['descripcion'.$i];
						echo '<br/>';
						addcompra($_SESSION['isbn'.$i],$id);
						addlibro($_SESSION['isbn'.$i]);
						$_SESSION['isbn'.$i] = '?';
						$_SESSION['descripcion'.$i] = '?';
						echo '<hr/>';
					}
					echo '<hr/>';
					echo '<h3>Libros añadidos Correctamente a la persona</h3>';
				break;
				
				case isset($_POST['NuevoLibroID']): // Añadir nuevo libro a la base de datos por identificador de persona
					echo '<h3> Has añadido un Libro por Identificador de la persona</h3>';
					echo '<hr/>';
					echo 'ID	: ' . $_SESSION['id'];
					echo '<hr/>';
					echo 'Nombre	: ' . $_SESSION['nombre'];
					echo '<hr/>';
					echo 'Apellido	: ' . $_SESSION['apellido'];
					echo '<hr/>';
					echo 'ISBN	: '. $_SESSION['isbn'];
					echo '<br/>';
					echo 'Descripcion	: ' .$_SESSION['descripcion'];
					echo '<br/>';
					echo 'Cantidad	: ' . $_SESSION['cantidad'];
					echo '<hr/>';
					insertlibro($_SESSION['isbn'],$_SESSION['descripcion'],$_SESSION['cantidad']);
					addcompra ($_SESSION['isbn'],$_SESSION['id']);
				break;
		
				case isset($_POST['NuevoLibroM']): // Añadir un nuevo libro a la base de datos por Movil de la persona
					echo '<h3> Has añadido un Libro por Movil de la persona</h3>';
					echo '<hr/>';
					echo 'ID	:' . $_SESSION['id'];
					echo '<hr/>';
					echo 'Nombre	: ' . $_SESSION['nombre'];
					echo '<hr/>';
					echo 'Apellido	: '.$_SESSION['apellido'];
					echo '<hr/>';
					echo 'ISBN	: ' .$_SESSION['isbn'];
					echo '<hr/>';
					echo 'Descripcion' . $_SESSION['descripcion'];
					echo '<hr/>';
					echo 'Cantidad	: ' . $_SESSION['cantidad'];
					echo '<hr/>';
					insertlibro($_SESSION['isbn'],$_SESSION['descripcion'],$_SESSION['cantidad']);
					addcompra ($_SESSION['isbn'],$_SESSION['id']);
				break;
		
				case isset($_POST['NuevoLibroNP']):
					echo '<h3> Has añadido un Libro por Nueva persona</h3>';
					insertpersona($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					echo 'Persona';
					echo  '<hr/>';
					echo 'ID	:' . $id;
					echo '<br/>';
					echo 'Nombre	: ' . $_SESSION['nombre'];
					echo '<br/>';
					echo 'Apellido	: ' . $_SESSION['apellido'];
					echo '<br/>';
					echo 'Movil	: ' . $_SESSION['movil'];
					echo '<br/>';
					echo 'Correo	: ' . $_SESSION['mail'];
					echo '<hr/>';
					echo 'Libro en Deposito	:';
					echo '<hr/>';
					echo 'ISBN	: ' . $_SESSION['isbn'];
					echo '<br/>';
					echo 'Descripcion	: ' . $_SESSION['descripcion'];
					echo '<br/>';
					echo 'Cantidad	: ' . $_SESSION['cantidad'];
					echo '<br/>';
					insertlibro($_SESSION['isbn'],$_SESSION['descripcion'],$_SESSION['cantidad']);
					addcompra ($_SESSION['isbn'],$id);
				break;
						
				case isset($_POST['vender']) :  // Inserccion en la base de datos de las ventas de Segunda Mano
					echo '<h3>Venta de Segunda Mano</h3>';
					for ($i = 0 ; $i < $_SESSION['filas'] ; $i ++){
						echo '<hr/>';
						echo 'ISBN	: ' . $_SESSION['isbn'.$i];
						echo'<br/>';
						echo 'ID_VENDEDOR		: ' . $_SESSION['id_vendedor'.$i];
						echo '<br/>';
						if (!librorepetido($_SESSION['isbn'.$i],$_SESSION['id_vendedor'.$i],'Almacen')){
							addventa($_SESSION['isbn'.$i],$_SESSION['id_vendedor'.$i],$_SESSION['cantidad'.$i]); // Venta de libro normal
						}else{
							$id_cv = identificar($_SESSION['isbn'.$i],$_SESSION['id_vendedor'.$i],'Almacen');
							addventaunica($id_cv,$_SESSION['isbn'.$i],$_SESSION['cantidad'.$i]);			// Venta de un unico libro con un vendedor con dos libros iguales
						}
						$_SESSION['isbn'.$i] = '?';
						$_SESSION['descripcion'.$i] = '?';
						$_SESSION['id_vendedor'.$i] = '?';
						$_SESSION['cantidad'.$i] = -13;
					}
				break;
		
				case isset($_POST['Pagar']):
						echo '<h3>Pagar libro de Segunda Mano</h3>';
						echo 'Pago	:';
						echo '<hr/>';
						echo 'Identificador del Vendedor	: '.$_POST['id_vendedor'];
						echo '<hr/>';
						echo 'ISBN	: ' . $_POST['isbn'];
						echo '<hr/>';
						echo 'Descripcion	: ' . $_POST['descripcion'];
						echo '<hr/>';
						pagar($_POST['id_vendedor'],$_POST['isbn']);
				break;
		
				default:
					echo '<h3>No ha elegido ninguna opcion disponible para hacer en la base de datos</h3>';
				break;
			}
		}
		$_SESSION['id'] = '?';
		$_SESSION['nombre'] = '?';
		$_SESSION['apellido'] = '?';
		$_SESSION['mail'] = '?';
		$_SESSION['movil'] = '?';
		$_SESSION['isbn'] = '?';
		$_SESSION['descripcion'] = '?';
		$_SESSION['cantidad'] = '?';
		$_SESSION['filas'] = 0;
		$_SESSION['estado'] = 0;
		$_SESSION['nuevo'] = false;
	?>
		<br/>
		<a href = "admin.php">Volver</a>
	</body>
</html>