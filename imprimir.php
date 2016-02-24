<html>
	<head>
		<title>Imprimir factura</title>
		<script type = "text/javascript">
			function imprimir(){
				var objeto=document.getElementById('deposito');  //obtenemos el objeto a imprimir
				var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
				ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
				ventana.document.close();  //cerramos el documento
				ventana.print();  //imprimimos la ventana
				ventana.close();  //cerramos la ventana
			}
		</script>
		<style type="text/css" media="printxt">
		@media print {
			#deposito {display:block;}
			#ventaprecio {display:block;}
			#cabecera {display:none;}
		}
		</style>
	</head>
	<body>
	<?PHP
		require 'funciones.php';
		if (!$_SESSION['conectado']){				// Directivas de Seguridad
			header ('Location: autentificacion.php');
		}
		conexion($_SESSION['user'],$_SESSION['pass']);
	?>  
		<div id = "deposito">
			<h3 align = "center">Deposito de libros de Segunda Mano </h3>
			<hr/>
			<p> Correo de la Librería	: PUNTOCLIPLASROZAS@GMAIL.COM</p>
			<p>Teléfono : 917105556</p>
			<p>Direccion	: Cuesta San Francisco 11 CP : 28231 Las Rozas (Madrid)</p>
			<hr/>
	<?PHP //div para elegir la parte de la web que se imprimirá para el cliente excluir la parte de venta
		if ($_SESSION['nombre'] != '?' || $_SESSION['filas'] != 0 || isset($_POST['Pagar'])){
				if (isset($_POST['comprarNP'])){   // Compra de Segunda Mano por Nueva Persona(NP)		
					insertpersona($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					echo '<hr/>';
					echo '<h4>ID	:' . $id . '</h4>';
					echo '<br/>';
					echo 'Nombre	:  '.$_SESSION['nombre'];
					echo '<br/>';
					echo 'Apellido	:  '. $_SESSION['apellido'];
					echo '<br/>';
					echo 'Movil	:  '. $_SESSION['movil'];
					echo '<br/>';
					echo 'Correo	:  '.$_SESSION['mail'];
					echo '<br/>';
					echo 'Fecha de Deposito	: '.date('d') . '   de   ' .date('M'). '  Año  ' .date('Y');
					echo '<br/>';
					echo '<h3 aling = "center">Libros En Deposito	:</h3>';
					echo '<br/>';
					echo '<ol>';
					for ($i = 0 ; $i < $_SESSION['filas'] ; $i ++){
						echo '<li>';
						addcompra($_SESSION['isbn'.$i],$id);
						addlibro($_SESSION['isbn'.$i]);
						echo 'ISBN	:' . $_SESSION['isbn'.$i];
						echo '<br/>';
						echo 'Descripcion	:'.$_SESSION['descripcion'.$i];
						echo '<br/>';
						$_SESSION['isbn'.$i] = '?';
						$_SESSION['descripcion'.$i] = '?';
						echo '</li>';
					}
					echo '</ol>';
					echo '<hr/>';
					aviso();
					echo '<button onclick="imprimir();"> Imprimir Deposito </button>';
				}
				if (isset($_POST['comprarM']) || isset($_POST['comprarID'])){ // Compra de libro de segunda mano normal
					if ($_SESSION['id'] == '?'){   // Persona duplicada en la base de datos, mismo correo, mismo movil, mismo nombre mismo apellido, con diferente id
						$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					}else {
						$id = $_SESSION['id'];
					}
					echo '<h4>ID Cliente	: ' . $id . '</h4>';
					echo '<br/>';
					echo 'Nombre	: ' . $_SESSION['nombre'];
					echo '<br/>';
					echo 'Apellido	: ' . $_SESSION['apellido'];
					echo '<br/>';
					echo 'Movil	: ' . $_SESSION['movil'];
					echo '<br/>';
					echo 'Correo	:  '.$_SESSION['mail'];
					echo '<br/>';
					echo 'Fecha de Deposito	: '.date('d') . '   de   ' .date('M'). '  Año  ' .date('Y');
					echo '<br/>';
					echo '<h3 aling = "Center">Libros a deposito</h3>';
					echo '<hr/>';
					echo '<ol>';
					for ($i = 0 ; $i < $_SESSION['filas'] ; $i ++){
						echo '<li>';
						echo 'ISBN	: ' . $_SESSION['isbn'.$i];
						echo '<br/>';
						echo 'Descripción	:' . $_SESSION['descripcion'.$i];
						echo '<br/>';
						addcompra($_SESSION['isbn'.$i],$id);
						addlibro($_SESSION['isbn'.$i]);
						$_SESSION['isbn'.$i] = '?';
						$_SESSION['descripcion'.$i] = '?';
						echo '<br/>';
						echo '</li>';
					}
					echo '</ol>';
					echo '<hr/>';
					aviso();
					echo '<button onclick="imprimir();"> Imprimir Deposito </button>';
				}
				
				if (isset($_POST['NuevoLibroID'])){ // Añadir nuevo libro a la base de datos por identificador de persona
					echo '<h3> Nuevo Libro a Depósito</h3>';
					echo '<hr/>';
					echo 'ID Cliente	: <h3>' . $_SESSION['id'] . '</h3>';
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
					aviso();
					insertlibro($_SESSION['isbn'],$_SESSION['descripcion'],$_SESSION['cantidad']);
					addcompra ($_SESSION['isbn'],$_SESSION['id']);
					echo '<button onclick="imprimir();"> Imprimir Deposito </button>';
				}
		
				if (isset($_POST['NuevoLibroM'])){ // Añadir un nuevo libro a la base de datos por Movil de la persona
					echo '<h3> Nuevo Libro a Depósito</h3>';
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
					aviso();
					insertlibro($_SESSION['isbn'],$_SESSION['descripcion'],$_SESSION['cantidad']);
					addcompra ($_SESSION['isbn'],$_SESSION['id']);
					echo '<button onclick="imprimir();"> Imprimir Deposito </button>';
				}
		
				if (isset($_POST['NuevoLibroNP'])){
					echo '<h3>Nuevo Libro a Depósito</h3>';
					insertpersona($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					$id = devolverid($_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['movil'],$_SESSION['mail']);
					echo 'Persona';
					echo  '<hr/>';
					echo 'ID	:<h3>' .$id . '<h3>';
					echo '<br/>';
					echo 'Nombre	: ' . $_SESSION['nombre'];
					echo '<br/>';
					echo 'Apellido	: ' . $_SESSION['apellido'];
					echo '<br/>';
					echo 'Movil	: ' . $_SESSION['movil'];
					echo '<br/>';
					echo 'Correo	: ' . $_SESSION['mail'];
					echo '<hr/>';
					echo '<h3 align = "center"> Libro en Depósito	: </h3>';
					echo 'hr/>';
					echo 'ISBN	: ' . $_SESSION['isbn'];
					echo '<br/>';
					echo 'Descripcion	: ' . $_SESSION['descripcion'];
					echo '<br/>';
					echo 'Cantidad	: ' . $_SESSION['cantidad'];
					echo '<br/>';
					aviso();
					insertlibro($_SESSION['isbn'],$_SESSION['descripcion'],$_SESSION['cantidad']);
					addcompra ($_SESSION['isbn'],$id);
					echo '<button onclick="imprimir();"> Imprimir Deposito </button>';
				}
			?>
		</div>
		<div id = "ventaprecio">
			<?PHP
				if (isset($_POST['vender'])){  // Inserccion en la base de datos de las ventas de Segunda Mano
					echo '<h3 aling = "center">Libros vendidos</h3>';
					for ($i = 0 ; $i < $_SESSION['filas'] ; $i ++){
						echo 'ISBN	: ' . $_SESSION['isbn'.$i];
						echo'<br/>';
						echo 'Descripcion	: ' . $_SESSION['descripcion'.$i];
						echo '<br/>';
						echo 'ID_VENDEDOR		: ' . $_SESSION['id_vendedor'.$i];
						echo '<br/>';
						if (!librorepetido($_SESSION['isbn'.$i],$_SESSION['id_vendedor'.$i],'Almacen')){
							addventa($_SESSION['isbn'.$i],$_SESSION['id_vendedor'.$i],$_SESSION['cantidad'.$i]); // Venta de libro normal
						}else{
							$id_cv = identificarventa($_SESSION['isbn'.$i],$_SESSION['id_vendedor'.$i],'Almacen');
							addventaunica($id_cv,$_SESSION['isbn'.$i],$_SESSION['cantidad'.$i]);			// Venta de un unico libro con un vendedor con dos libros iguales
						}
						$_SESSION['isbn'.$i] = '?';
						$_SESSION['descripcion'.$i] = '?';
						$_SESSION['id_vendedor'.$i] = '?';
						$_SESSION['cantidad'.$i] = -13;
					}
					echo '<hr/>';
				}
				if (isset($_POST['Pagar'])){
						echo '<h3 align = "center">Pago de Libro</h3>';
						echo '<hr/>';
						echo 'Identificador del Vendedor	: '.$_POST['id_vendedor'];
						echo '<hr/>';
						echo 'ISBN	: ' . $_POST['isbn'];
						echo '<hr/>';
						echo 'Descripcion	: ' . $_POST['descripcion'];
						echo '<hr/>';
						if (!librorepetido($_POST['isbn'],$_POST['id_vendedor'],'Vendido')){
							pagar($_POST['id_vendedor'],$_POST['isbn']);
						}else {
							$id_cv = identificarventa($_POST['isbn'],$_POST['id_vendedor'],'Vendido');
							pagounico($id_cv);
						}
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
		</div>
	</body>
</html>