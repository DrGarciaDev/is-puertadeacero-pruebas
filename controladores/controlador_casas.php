<?php
	include ('../modelos/modelo_casas.php');

	$obj_casas = new Casas();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if($_SESSION['tipo'] === "Administrador") {
		
			if (isset($_POST['Busqueda_casa']) && $_POST['Busqueda_casa'] != "") {
				
				$obj_casas->Buscar_casa($_POST['Busqueda_casa']);
			
			}

			if (isset($_POST['ID_casa']) && $_POST['ID_casa'] != "") {
				
				$obj_casas->Eliminar_casa($_POST['ID_casa']);

			}
			
			if (array_key_exists('Dueno_agregar', $_POST) &&
				array_key_exists('Adeudo_agregar', $_POST) &&
				array_key_exists('Usuario_agregar', $_POST) ) {

				$obj_casas->set_dueno($_POST['Dueno_agregar']);
				$obj_casas->set_adeudo($_POST['Adeudo_agregar']);
				$obj_casas->set_usuario_id($_POST['Usuario_agregar']);

				$obj_casas->Agregar_casa();

			}

			if (array_key_exists('Id_editar', $_POST) &&
				array_key_exists('Tipo_editar', $_POST) &&
				array_key_exists('Nombres_editar', $_POST) &&
				array_key_exists('Ape_pat_editar', $_POST) &&
				array_key_exists('Ape_mat_editar', $_POST) &&
				array_key_exists('Telefono_editar', $_POST) &&
				array_key_exists('Correo_editar', $_POST) &&
				array_key_exists('Contrasena_editar', $_POST) &&
				array_key_exists('Contrasena2_editar', $_POST) ) {
				
				$obj_casas->set_id($_POST['Id_editar']);
				$obj_casas->set_tipo($_POST['Tipo_editar']);
				$obj_casas->set_nombres($_POST['Nombres_editar']);
				$obj_casas->set_ape_paterno($_POST['Ape_pat_editar']);
				$obj_casas->set_ape_materno($_POST['Ape_mat_editar']);
				$obj_casas->set_telefono($_POST['Telefono_editar']);
				$obj_casas->set_email($_POST['Correo_editar']);
				$obj_casas->set_pass($_POST['Contrasena_editar']);
				$obj_casas->set_pass2($_POST['Contrasena2_editar']);

				$obj_casas->Editar();

			}

		}

	}//Fin del if SERVER

?>