<?php
	if(session_id() == '' || !isset($_SESSION)) { 
        //session_set_cookie_params(constant('timeC'), constant('path'), $domain, true, true);
        session_start();
        ob_start();
    }
	if( !isset($_SESSION['usuario']) ){
		header('Location: ../vistas/vista_ingresar');
		exit();
	}
	/**
	* Autores: Luis Alberto García Rodríguez
	*          Carlos 
	*/
	Class Usuarios
    {
        private $id;
        private $tipo;
        private $ape_paterno;
        private $ape_materno;
        private $nombres;
        private $pass;
        private $telefono1;
        private $email;
        private $fechaRegistro;
        private $activo;

        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $tipo = "", 
                            $ap_paterno = "", $ap_materno = "", 
                            $nombres = "", $pass = "", 
                            $telefono1 = "", $email = "", 
                            $fecha_registro = "", $activo = "") 
        {
            $this->id                 = $id;
            $this->tipo               = $tipo;
            $this->ape_paterno        = $ap_paterno;
            $this->ape_materno        = $ap_materno;
            $this->nombres            = $nombres;
            $this->pass               = $pass;
            $this->telefono1          = $telefono1;
            $this->email              = $email;
            $this->fechaRegistro      = $fecha_registro;
            $this->activo             = $activo;
        }

        public function Buscar($buscar = '')
        {
        	include('../config/conexion.php');

	        if (!empty($buscar) ) {

	        	$busqueda = htmlspecialchars( mysqli_real_escape_string($enlace, $buscar) );

				$sql = "SELECT * FROM usuarios WHERE 
			    id LIKE '%".$busqueda."%' OR 
			    tipo LIKE '%".$busqueda."%' OR 
			    correo LIKE '%".$busqueda."%' OR
			    nombres LIKE '%".$busqueda."%' OR  
			    ape_materno LIKE '%".$busqueda."%' OR  
			    ape_paterno LIKE '%".$busqueda."%' ";
				
				$resultadoEsp = mysqli_query($enlace, $sql);
				$count = mysqli_num_rows($resultadoEsp);
				
				if(isset($count)) { 
					if($count > 0) { 
						$contenido = '
							<table class="bordered highlight striped centered responsive-table">
								<thead>
									<tr>
										<th>Id usuario</th>
										<th>Tipo de Usuario</th>
										<th>Correo</th>
										<th>Nombre(s)</th>
										<th>Apellido Paterno</th>
										<th>Apellido Materno</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>';
						while ($row = $resultadoEsp->fetch_object()){ 
							$contenido .= '
									<tr>
										<td>'.$row->id.'</td>
										<td>'.$row->tipo.'</td>
										<td>'.$row->correo.'</td>
										<td>'.$row->nombres.'</td>
										<td>'.$row->ape_paterno.'</td>
										<td>'.$row->ape_materno.'</td>
										<td>
											<a href="../modelos/modelo_usuarios?id=<?= $row->id ?>&editar=2" class="btn yellow darken-1" title="Editar usuario">Editar</a>
											<button type="button" class="btn red" onclick="eliminar_usuario(\''.$row->nombres.'\', \''.$row->ape_paterno.'\', '.$row->id.')" title="Eliminar usuario">Borrar</button>
										</td>
									</tr>';
						} 
						$contenido .= '
								</tbody>
							</table>';
					}else{
						$contenido = '<div class="card amber lighten-4 center">
             						<div class="card-content red-text">
                    				<p>Busca de nuevo; Usuario inexistente...</p>
                  				</div>
                			</div>';
					} 
				}
			}

			echo $contenido;
        }

        public function Ver_todos()
        {
        	include('../config/conexion.php');
			
			$query = "SELECT * FROM usuarios;";
			$resultado = mysqli_query($enlace, $query);
			
			$contenido = '
				<table class="bordered highlight striped centered responsive-table">
					<thead>
						<tr>
							<th>Id usuario</th>
							<th>Tipo de Usuario</th>
							<th>Correo</th>
							<th>Nombre(s)</th>
							<th>Apellido Paterno</th>
							<th>Apellido Materno</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>';
			while ($row = $resultado->fetch_object()){
				$contenido .= '
						<tr>
							<td>'.$row->id.'</td>
							<td>'.$row->tipo.'</td>
							<td>'.$row->correo.'</td>
							<td>'.$row->nombres.'</td>
							<td>'.$row->ape_paterno.'</td>
							<td>'.$row->ape_materno.'</td>
							<td>
								<a href="../controladores/controlador_usuarios?id=<?= $row->id ?>&opc=2" class="btn yellow darken-1" title="Editar usuario">Editar</a>
								<button type="button" class="btn red" onclick="eliminar_usuario(\''.$row->nombres.'\', \''.$row->ape_paterno.'\', '.$row->id.');" title="Eliminar usuario">Borrar</button>
							</td>
						</tr>';
			}
			$contenido .= '
					</tbody>
				</table>';

			echo $contenido;
        }

        public function Eliminar($value)
        {
        	include('../config/conexion.php');

        	$query = "DELETE FROM `usuarios` WHERE `id_usuario` = ".$value;
			$resultado = mysqli_query($enlace,$query);

			if($resultado){
				$_SESSION['flash'] = "UsE";
				$contenido = "Usuario eliminado";
			}
			else{
				$contenido = "Usuario no eliminado";
			}

			echo $contenido;
        }
    }

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if($_SESSION['tipo'] === "Administrador") {

			$obj_usuarios = new Usuarios();
		
			if (isset($_POST['Busqueda']) && $_POST['Busqueda'] != "") {
				
				$obj_usuarios->Buscar($_POST['Busqueda']);
			
			}

			if (isset($_POST['ID']) && $_POST¨['ID'] != "") {
				
				$obj_usuarios->Eliminar($_POST['ID']);

			}
			
		}
		
	}//Fin del if SERVER

//$query = "SELECT * FROM usuarios;";
//$resultado = mysqli_query($enlace, $query);
?>