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
            $this->fecha_registro     = $fecha_registro;
            $this->activo             = $activo;
        }

        /**
         * Gets the value of id
         */
        public function get_id()
        {
            return $this->id;
        }
        
        /**
         * Sets the value of id
         */
        public function set_id($id)
        {
            $this->id = $id;
        }

        /**
         * Gets the value of tipo
         */
        public function get_tipo()
        {
            return $this->tipo;
        }
        
        /**
         * Sets the value of tipo
         */
        public function set_tipo($tipo)
        {
            $this->tipo = $tipo;
        }

        /**
         * Gets the value of ape_paterno
         */
        public function get_ape_paterno()
        {
            return $this->ape_paterno;
        }
        
        /**
         * Sets the value of ape_paterno
         */
        public function set_ape_paterno($ape_paterno)
        {
            $this->ape_paterno = $ape_paterno;
        }

        /**
         * Gets the value of ape_materno
         */
        public function get_ape_materno()
        {
            return $this->ape_materno;
        }
        
        /**
         * Sets the value of ape_materno
         */
        public function set_ape_materno($ape_materno)
        {
            $this->ape_materno = $ape_materno;
        }

        /**
         * Gets the value of nombres
         */
        public function get_nombres()
        {
            return $this->nombres;
        }
        
        /**
         * Sets the value of nombres
         */
        public function set_nombres($nombres)
        {
            $this->nombres = $nombres;
        }

        /**
         * Gets the value of pass
         */
        public function get_pass()
        {
            return $this->pass;
        }
        
        /**
         * Sets the value of pass
         */
        public function set_pass($pass)
        {
            $this->pass = $pass;
        }

        /**
         * Gets the value of telefono1
         */
        public function get_telefono1()
        {
            return $this->telefono1;
        }
        
        /**
         * Sets the value of telefono1
         */
        public function set_telefono1($telefono1)
        {
            $this->telefono1 = $telefono1;
        }

        /**
         * Gets the value of email
         */
        public function get_email()
        {
            return $this->email;
        }
        
        /**
         * Sets the value of email
         */
        public function set_email($email)
        {
            $this->email = $email;
        }

        /**
         * Gets the value of fecha_registro
         */
        public function get_fecha_registro()
        {
            return $this->fecha_registro;
        }
        
        /**
         * Sets the value of fecha_registro
         */
        public function set_fecha_registro($fecha_registro)
        {
            $this->fecha_registro = $fecha_registro;
        }

        /**
         * Gets the value of activo
         */
        public function get_activo()
        {
            return $this->activo;
        }
        
        /**
         * Sets the value of activo
         */
        public function set_activo($activo)
        {
            $this->activo = $activo;
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

        public function Agregar($value)
        {
        	include('../config/conexion.php');

        	//###### FILTRO anti-XSS
			$nombre = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Nombres']) );
			$ape_pat = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Ape_pat']) );
			$ape_mat = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Ape_mat']) );
			$telefono = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Telefono']) );
			$correo = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Correo']) );
			$contrasena = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Contrasena']) );
			$contrasena2 = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Contrasena2']) );
	      	$tipo = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Tipo']) );
	      	//echo "Tipo: $tipo";
	      //$sql_Check_Mail = "SELECT * FROM usuarios WHERE correo = '$correo' and contrasena = '$contrasena' COLLATE utf8_bin ";
	      //$sql_Check_Mail = "SELECT * FROM usuarios WHERE correo = '$correo' and contrasena = BINARY '$contrasena' ";
			$sql_Check_Mail = "SELECT * FROM usuarios WHERE correo = 'htmlentities($correo)'; ";
			
			$result = mysqli_query($enlace, $sql_Check_Mail);
	      //la siguiente linea funciona igual a la que continúa después
	      //$count = $result->num_rows;
			$count = mysqli_num_rows($result);

			if($contrasena == $contrasena2){
				if($count > 0){
					$_SESSION['flash'] = "Error";
				}else {
					if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
						$passCifrado = password_hash($contrasena, PASSWORD_DEFAULT);
						/*
						if ($tipo == "Administrador"){
							$tip = 1;
						}elseif($tipo == "Usuario") {
							$tip = 2;
						}
						*/
						//var_dump($nombre, $ape_pat, $ape_mat, $curp, $correo, $contrasena, $tipo, $passCifrado);
						$sql_insert = "INSERT INTO usuarios VALUES('','$nombre','$ape_pat','$ape_mat','$telefono','$correo','$passCifrado','$tipo');";
						mysqli_query($enlace,$sql_insert)
							or die("ERROORRR");
						//$sql = "INSERT INTO `usuario` (`id`, `tipo_usuario`, `curp`, `correo`, `contrasena`, `nombres`, `ape_pat`, `ape_mat`) VALUES (NULL, \'admin\', \'hjc\', \'co\', \'lalala\', \'l\', \'l\', \'l\')";
						//echo 'Se ha registrado con exito';
						echo ' <script language="javascript">alert("Usuario registrado con éxito");</script> ';
	/*
						$_SESSION['flash'] = "UsA";
						//echo "<script>location.href='usuarios'</script>";
						header("Location: ver_usuarios");
						exit();
	*/
					}else{
						echo '<div class="alert alert-danger"><strong>Error!</strong> No es un correo...</div>';
					}
					
				}// fin del if count
			}else{
				echo '<div class="alert alert-danger"><strong>Error!</strong> Las contraseñas son distintas</div>';
			}//fin total del if checa contraseña
        }
    }

//$query = "SELECT * FROM usuarios;";
//$resultado = mysqli_query($enlace, $query);
?>