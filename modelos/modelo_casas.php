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
	Class Casas
    {
        private $id;
        private $dueno;
        private $adeudo;
        private $usuario_id;
       
        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $dueno = "",
                            $adeudo = "", $usuario_id = "") 
        {
            $this->id           = $id;
            $this->dueno        = $dueno;
            $this->adeudo       = $adeudo;
            $this->usuario_id   = $usuario_id;
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
         * Gets the value of dueno
         */
        public function get_dueno()
        {
            return $this->dueno;
        }
        
        /**
         * Sets the value of dueno
         */
        public function set_dueno($dueno)
        {
            $this->dueno = $dueno;
        }
        
        /**
         * Gets the value of adeudo
         */
        public function get_adeudo()
        {
            return $this->adeudo;
        }
        
        /**
         * Sets the value of adeudo
         */
        public function set_adeudo($adeudo)
        {
            $this->adeudo = $adeudo;
        }

        /**
         * Gets the value of usuario_id
         */
        public function get_usuario_id()
        {
            return $this->usuario_id;
        }
        
        /**
         * Sets the value of usuario_id
         */
        public function set_usuario_id($usuario_id)
        {
            $this->usuario_id = $usuario_id;
        }


        public function Buscar_casa($buscar = '')
        {
        	include('../config/conexion.php');

	        if (!empty($buscar) ) {

	        	$busqueda = htmlspecialchars( mysqli_real_escape_string($enlace, $buscar) );

                $sql = "SELECT * FROM casas WHERE 
                id LIKE '%".$busqueda."%' OR 
                dueno LIKE '%".$busqueda."%' OR  
                adeudo LIKE '%".$busqueda."%' ";      
                
                $resultadoEsp = mysqli_query($enlace, $sql);
                $count = mysqli_num_rows($resultadoEsp);
				
				if(isset($count)) { 
					if($count > 0) { 
						$contenido = '
							<table class="bordered highlight striped centered responsive-table">
                                <thead>
                                    <tr>
                                        <th>Id Casa</th>
                                        <th>Dueño(s)</th>
                                        <th>Adeudo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
						while ($row = $resultadoEsp->fetch_object()){ 
							$contenido .= '
									<tr>
                                        <td>'.$row->id.'</td>
                                        <td>'.$row->dueno.'</td>
                                        <td>'.$row->adeudo.'</td>
                                        <td>
                                            <a href="casa_editar?id='.$row->id.'" class="btn orange darken-1" title="Editar casa">Editar</a>
                                            <button type="button" class="btn red" onclick="eliminar_casa(\''.$row->dueno.'\', \''.$row->adeudo.'\', '.$row->id.')" title="Eliminar casa">Borrar</button>
                                        </td>
                                    </tr>';
						} 
						$contenido .= '
								</tbody>
                            </table>';
					}else{
						$contenido = '<div class="card amber lighten-4 center">
                                        <div class="card-content red-text">
                                        <p>Busca de nuevo; casa inexistente...</p>
                                    </div>
                                </div>';
					} 
				}
			}

			echo $contenido;
        }

        public function Ver_todas_casas()
        {
        	include('../config/conexion.php');
			
			$contenido = '<h4>Todas las casas</h4>';
            
            $query = "SELECT * FROM casas;";
            $resultado = mysqli_query($enlace, $query);
        
            $contenido .= '
                <table class="bordered highlight striped centered responsive-table">
                    <thead>
                        <tr>
                            <th>Id Casa</th>
                            <th>Dueño(s)</th>
                            <th>Adeudo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            while ($row = $resultado->fetch_object()) { 
                $contenido .= '
                        <tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->dueno.'</td>
                            <td>'.$row->adeudo.'</td>
                            <td>
                                <a href="casa_editar?id=<?= $row->id ?>" class="btn orange darken-1" title="Editar casa">editar</a>
                                <button type="button" class="btn red" onclick="eliminar_casa(\''.$row->dueno.'\', \''.$row->adeudo.'\', '.$row->id.')" title="Eliminar casa">Borrar</button>
                            </td>
                        </tr>';
                } 
                $contenido .= '
                    </tbody>
                </table>';

			echo $contenido;
        }

        public function Eliminar_casa($value)
        {
        	include('../config/conexion.php');

            $id = htmlspecialchars( mysqli_real_escape_string($enlace, $value) );

            $query = "DELETE FROM casas WHERE id = ".$id;
            $resultado = mysqli_query($enlace,$query);

            if($resultado){
                $_SESSION['flash'] = "CaE";
                $contenido = "Casa eliminada";
            }
            else {
                $contenido = "Casa no eliminada";
            }

			echo $contenido;
        }

        public function Agregar_casa()
        {
        	include('../config/conexion.php');

        	//###### FILTRO anti-XSS
			$dueno = trim(strtoupper(htmlspecialchars( mysqli_real_escape_string($enlace, $this->dueno) ) ) );
            $adeudo = htmlspecialchars( mysqli_real_escape_string($enlace, $this->adeudo) );
            $usuario = htmlspecialchars( mysqli_real_escape_string($enlace, $this->usuario_id) );

            $sql_insert = "INSERT INTO casas(dueno,adeudo,usuario_id) VALUES('$dueno', $adeudo, $usuario);";

            //DEVUELVE TRUE SI LA CONSULTA CON INSERT SE REALIZA CON EXITO
            if (mysqli_query($enlace, $sql_insert) === TRUE) {
                $contenido = 'Casa registrada con éxito';
            }
            else {
                $contenido = 'Casa No registrada, intentalo nuevamente';
            }
            echo $contenido;
        }

        public function Editar()
        {
            include('../config/conexion.php');

            $id = htmlspecialchars( mysqli_real_escape_string($enlace, $this->id) );
            $dueno = htmlspecialchars(mysqli_real_escape_string($enlace, $this->dueno ) );
            $ape_pat = htmlspecialchars(mysqli_real_escape_string($enlace, $this->adeudo ) );
            $ape_mat = htmlspecialchars(mysqli_real_escape_string($enlace, $this->usuario_id ) );
            $telefono = htmlspecialchars(mysqli_real_escape_string($enlace, $this->telefono ) );
            $correo = htmlspecialchars(mysqli_real_escape_string($enlace, $this->email ) );
            $contrasena = htmlspecialchars(mysqli_real_escape_string($enlace, $this->pass ) );
            $contrasena2 = htmlspecialchars(mysqli_real_escape_string($enlace, $this->pass2 ) );
            $tipo = htmlspecialchars(mysqli_real_escape_string($enlace, $this->tipo ) );
            
            $contenido = "Sin movimientos";

            if($contrasena === $contrasena2){
                if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
                    $passCifrado = password_hash($contrasena, PASSWORD_DEFAULT);
                    $query = "UPDATE usuarios SET tipo = '" . $tipo . "', telefono = '" . $telefono . "', 
                        correo = '" . $correo . "', contrasena = '" . $contrasena . "', dueno = '" . $dueno . "', 
                        adeudo = '" . $ape_pat . "', usuario_id = '" . $ape_mat . "' WHERE id =".$id;
                    $resultado = mysqli_query($enlace, $query);
                    if ($resultado) {
                        $_SESSION['flash'] = "UsEd";
                        $contenido = 'Usuario Actualizado con éxito';
                    }
                }else{
                    $contenido = 'Ingrese correo valido, vuelve a intentarlo';
                }
            }else{
                $contenido = 'Las contraseñas no coinciden, vuelve a intentarlo';
            }

            echo $contenido;
        }

    }//FIN DE LA CLASE USUARIOS

?>