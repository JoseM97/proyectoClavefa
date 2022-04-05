<?php
    require "src/cfg_bd.php";

    function LetraNIF($dni)
	{
		$valor= (int) ($dni / 23);
		$valor *= 23;
		$valor= $dni - $valor;
		$letras= "TRWAGMYFPDXBNJZSQVHLCKEO";
		$letraNif= substr ($letras, $valor, 1);
		return $letraNif;
	}

    function repetido($conex,$tabla,$columna,$valor,$id_usuario="no_edit")
	{
		$rep=false;
		$clausula=" AND idUsu<>".$id_usuario;
		if($id_usuario=="no_edit")
			$clausula="";

		$consulta="select ".$columna." from ".$tabla." where BINARY ".$columna."='".$valor."'".$clausula;
		if($resultado=mysqli_query($conex,$consulta))
		{
			if(mysqli_num_rows($resultado)>0)
			{
				$rep=true;
				mysqli_free_result($resultado);
			}
		}
		else
		{
			$error="Imposible realizar la consulta. Error número: ".mysqli_errno($conex). ":".mysqli_error($conex);
			mysqli_close($conex);
			die($error);	
		}

		return $rep;

	}

    function obtener_usuario($usuario, $clave){
        @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if(!$conexion){
            die("Imposible conectar");
        }

        mysqli_set_charset($conexion, "utf8");
        $consulta="select * from usuarios where contraseña='".$clave."' and email='".$usuario."'";
        $resultado=mysqli_query($conexion, $consulta);

        if(!$resultado){
            msqli_close($conexion);
            die("Imposible conectar");
        }else{
            if(mysqli_num_rows($resultado)>0){
                $respuesta=mysqli_fetch_assoc($resultado);
            }else{
                $respuesta=false;
            }

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            return $respuesta;
        }
    }

    function obtener_id_usuario($usuario, $clave){
        @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if(!$conexion){
            die("Imposible conectar");
        }

        mysqli_set_charset($conexion, "utf8");
        $consulta="select idUsu from usuarios where contraseña='".$clave."' and email='".$usuario."'";
        $resultado=mysqli_query($conexion, $consulta);

        if(!$resultado){
            msqli_close($conexion);
            die("Imposible conectar");
        }else{
            if(mysqli_num_rows($resultado)>0){
                $respuesta=mysqli_fetch_assoc($resultado);
            }else{
                $respuesta="false";
            }

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            return $respuesta;
        }
    }
    
    function obtener_id_producto($nombre){
        @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if(!$conexion){
            die("Imposible conectar");
        }

        mysqli_set_charset($conexion, "utf8");
        $consulta="select idProdu from productos where nombre='".$nombre."'";
        $resultado=mysqli_query($conexion, $consulta);

        if(!$resultado){
            msqli_close($conexion);
            die("Imposible conectar");
        }else{
            if(mysqli_num_rows($resultado)>0){
                $respuesta=mysqli_fetch_assoc($resultado);
            }else{
                $respuesta="false";
            }

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            return $respuesta;
        }
    }

    function obtener_id_clase($fecha){
        @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if(!$conexion){
            die("Imposible conectar");
        }

        mysqli_set_charset($conexion, "utf8");
        $consulta="select idClase from clases where fecha='".$fecha."'";
        $resultado=mysqli_query($conexion, $consulta);

        if(!$resultado){
            msqli_close($conexion);
            die("Imposible conectar");
        }else{
            if(mysqli_num_rows($resultado)>0){
                $respuesta=mysqli_fetch_assoc($resultado);
            }else{
                $respuesta="false";
            }

            mysqli_free_result($resultado);
            mysqli_close($conexion);
            return $respuesta;
        }
    }

    session_name("clavefa");
    session_start();
    define("MINUTOS",5000);

    if(isset($_POST["btnCerrarSesion"])){
        session_destroy();
        header("Location:index.php");
        exit;
    }

    if(isset($_POST["btnUsu"]) || isset($_POST["btnLogin"]) || isset($_POST["btnRegistro"]) || isset($_POST["btnBorrarCampos"]) || isset($_POST["btnGuardar"])){
        if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){

            $datos_usu_logueado=obtener_usuario($_SESSION["usuario"], $_SESSION["clave"]);
    
            if($datos_usu_logueado){
                $tiempo_transc=time()-$_SESSION["ultimo_acceso"];
    
                if($tiempo_transc>MINUTOS*60){
                    session_unset();
                    $_SESSION["tiempo"]=true;
                    header("Location:index.php");
                    exit;
    
                }else{
                    $_SESSION["ultimo_acceso"]=time();
                    require "vistas/user.php";
                }
            }else{
                session_unset();
                $_SESSION["restringida"]=true;
                header("Location:index.php");
                exit;
            }
            
        }elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnBorrarCampos"]) || isset($_POST["btnGuardar"])){
            require "vistas/registro.php";
        }else{
            require "vistas/login.php";
        }

    }elseif(isset($_POST["btnRepa"]) || isset($_POST["btnGuardarRepa"])){
        if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){
            require "vistas/reparaciones.php";
        }else{
            require "vistas/login.php";
        }
    }elseif(isset($_POST["btnProdu"]) || isset($_POST["search"]) || isset($_POST["btnComprarProdu"])){
        require "vistas/productos.php";
    }elseif(isset($_POST["btnclases"]) || isset($_POST["searchclases"]) || isset($_POST["btnComprarClase"])){
        require "vistas/clases.php";
    }elseif(isset($_POST["btnDetalleProdu"])){
        require "vistas/ProductoDetalle.php";
    }elseif(isset($_POST["btnDetalleClase"])){
        require "vistas/claseDetalle.php";
    }elseif(isset($_POST["btnFina"])){
        require "vistas/financiacion.php";
    }elseif(isset($_POST["btncono"])){
        require "vistas/conocenos.php";
    }elseif(isset($_POST["btnCooki"])){
        require "vistas/politicaCookies.php";
    }elseif(isset($_POST["btnPriva"])){
        require "vistas/politicaPrivacidad.php";
    }elseif(isset($_POST["btnServi"])){
        require "vistas/condiciones.php";
    }elseif(isset($_POST["btnLegal"])){
        require "vistas/aviso.php";
    }elseif(isset($_POST["btncarrito"]) || isset($_POST["btnEli"]) || isset($_POST["btnPedido"])){
        if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){
            require "vistas/carrito.php";
        }else{
            require "vistas/login.php";
        }
    }else{
        require "vistas/principal.php";
    }
?>