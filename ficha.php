<html>
	<head>
		<title>Ficha de cliente de Segunda Mano </title>
		<script type = "text/javascript">
			function imprimir(){
				var objeto=document.getElementById('ficha');  //obtenemos el objeto a imprimir
				var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
				ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
				ventana.document.close();  //cerramos el documento
				ventana.print();  //imprimimos la ventana
				ventana.close();  //cerramos la ventana
			}
		</script>
	</head>
	<body>
		<div id = "ficha">
		<?PHP
			require 'funciones.php';
			conexion($_SESSION['user'],$_SESSION['pass']);
			if (isset($_POST['ID']) || isset($_POST['Movil'])){
				if(isset($_POST['ID'])) {
					fichaID($_POST['ID']);
					echo '<a href = "gestion.php"><< Volver</a>';
					echo '<button onclick="imprimir();"> Imprimir Ficha </button>';
				}
				if (isset($_POST['Movil'])){
					fichaM($_POST['Movil']);
					echo '<a href = "gestion.php"><< Volver</a>';
					echo '<button onclick="imprimir();"> Imprimir Ficha </button>';				
				}
			}else {
					echo '<a href = "gestion.php"><< Volver</a>';
			}
		?>
		</div>
	</body>
</html>
