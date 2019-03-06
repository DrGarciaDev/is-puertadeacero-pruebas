<?php
	include ('../modelos/modelo_usuarios.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if($_SESSION['tipo'] === "Administrador") {

			$obj_usuarios = new Usuarios();
		
			if (isset($_POST['Busqueda']) && $_POST['Busqueda'] != "") {
				
				$obj_usuarios->Buscar($_POST['Busqueda']);
			
			}

			if (isset($_POST['ID']) && $_POST['ID'] != "") {
				
				$obj_usuarios->Eliminar($_POST['ID']);

			}
			
			if (array_key_exists('Nombres', $_POST) ) {/*&&
				array_key_exists('Ape_pat', $_POST) &&
				array_key_exists('Ape_mat', $_POST) &&
				array_key_exists('Telefono', $_POST) &&
				array_key_exists('Correo', $_POST) &&
				array_key_exists('Contrasena', $_POST) &&
				array_key_exists('Contrasena2', $_POST) &&
				array_key_exists('Tipo', $_POST) ) {
				*/
				$obj_usuarios->set_tipo($_POST['Nombres']);

				echo $obj_usuarios->get_tipo();

			}

		}

	}//Fin del if SERVER

	$obj_usuarios->set_tipo("ADMIN");

	echo $obj_usuarios->get_tipo();

?>