<?php

    @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if(!$conexion){
        die("Imposible conectar");
    }
    mysqli_set_charset($conexion,"utf8");

    if(isset($_POST["btnGuardarRepa"])){

        $error_apellidos=$_POST["apellidos"]=="";
        $error_nombre=$_POST["nombre"]=="";
        $error_comentario=$_POST["comentario"]=="";
        $error_dni=$_POST["dni"]=="" || strlen($_POST["dni"])!=9 || !is_numeric(substr($_POST["dni"],0,8)) || strtoupper(substr($_POST["dni"],8,1))<"A" || strtoupper(substr($_POST["dni"],8,1))>"Z" || LetraNIF(substr($_POST["dni"],0,8))!=strtoupper(substr($_POST["dni"],8,1))||repetido($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
        $error_email=$_POST["email"]=="";

        $errores=$error_apellidos || $error_nombre || $error_comentario || $error_dni || $error_email;
    
    @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    if(!$conexion){
        die("Imposible conectar");
    }
    mysqli_set_charset($conexion,"utf8");

    if(!$errores){
        if(isset($_POST["subscripcion"])){
            $subs="si";
        }else{
            $subs="no";
        }

        $idUsu=$_SESSION["idUsu"]["idUsu"];

        if($idUsu){
            $consulta="INSERT INTO reparaciones(idUsu, comentario, tipoInst, nombre, apellidos, dni, email, limpiar) VALUES('".$idUsu."','".$_POST['comentario']."','".$_POST['tipo']."','".$_POST['nombre']."','".$_POST['apellidos']."','".$_POST['dni']."','".$_POST['email']."','".$subs."')";
            $resultado=mysqli_query($conexion,$consulta);
            if(!$resultado){
                msqli_close();
                die("Imposible realizar la consulta.");
            }
            $nueva_id=mysqli_insert_id($conexion);
        }

        mysqli_close($conexion);
        header("Location:index.php");
        exit;
    }else{
        mysqli_close($conexion);
    }

    }

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="images/icon/logo.png">
        <title>Clave de FA</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="css/estilo.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
    </head>
    <body>
        <header>
            <div id="volar">
                <div id="cabecera">
                    <label for="menu">
                        <span><img src="images/icon/menu.png" width="100" height="100" alt=""></span>
                    </label>
                    <input type="checkbox" name="menu" id="menu" />
                    <nav class="menudesplegado">
                        <ul id="ul">
                            <li><form method="post" action="index.php"><button type="submit" name="btnRepa" id="btnRepa">Reparaciones</button></form></li>
                            <li><form method="post" action="index.php"><button type="submit" name="btnProdu" id="btnProdu">Productos</button></form></li>
                            <li><form method="post" action="index.php"><button type="submit" name="btnclases" id="btnclases">Clases</button></form></li>
                            <li><form method="post" action="index.php"><button type="submit" name="btnFina" id="btnFina">Financiación</button></form></li>
                        </ul>
                    </nav>

                    <a href="index.php"><img src="images/icon/logo.png" width="120" height="120" alt=""></a>
                </div>
        
                <div id="iconoscabecera">
                    <form method="post" action="index.php"><button type="submit" name="btnclases" id="btnclases"><img id="btnclases" name="btnclases" src="images/icon/book.png" alt=""></button></form>

                    <form method="post" action="index.php"><button type="submit" name="btnUsu" id="btnUsu"><img id="btnUsu" name="btnUsu" src="images/icon/user.png" alt=""></button></form>
                    
                    <form method="post" action="index.php"><button type="submit" name="btncarrito" id="btncarrito"><img id="btncarrito" name="btncarrito" src="images/icon/carrito.png" alt=""></button></form>
                </div>
            </div>
        </header>
        <main>
            <section>
                <h1>.</h1>
        
                <article class="espacio">
                    
                    <h2>Reparaciones</h2>
                    <p>Rellene el siguiente formulario detallando lo que le sucede al instrumento y vaya a la tienda.</p>
                    <div>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <div>
                            <div>
                                <label for="apellidos">Apellidos:</label>
                                <br/>
                                <label for="nombre">Nombre:</label>
                                <br/>
                                <label for="tipo">Tipo:</label>
                                <br/>
                                <label for="dni">DNI:</label>
                                <br/>
                                <label for="email">Email:</label>
                                <br/>
                                <label for="comentario">Descripción.</label>
                                <br/>
                            </div>
                            <div>
                                <input type="text" name="apellidos" id="apellidos" placeholder="apellidos..." value="<?php if(isset($_POST["btnGuardarRepa"])) echo $_POST["apellidos"]?>"/>
                                <?php
                                    if(isset($_POST["btnGuardarRepa"]) && $error_apellidos){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                                <br/>
                                <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php if(isset($_POST["btnGuardarRepa"])) echo $_POST["nombre"]?>"/>
                                <?php
                                    if(isset($_POST["btnGuardarRepa"]) && $error_nombre){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                                <br/>
                                <select name="tipo" id="tipo" class="form-select">
                                    <option value="cuerda">Cuerda</option>
                                    <option value="viento" selected>Viento</option>
                                    <option value="percusion">Percusión</option>
                                    <option value="otro">Otro</option>
                                </select>
                                <br/>
                                <input type="text" name="dni" id="dni" placeholder="DNI..." value="<?php if(isset($_POST["btnGuardarRepa"])) echo $_POST["dni"]?>"/>
                                <?php
                                    if(isset($_POST["btnGuardarRepa"]) && $error_dni){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                                <br/>
                                <input type="text" name="email" id="email" placeholder="email..." value="<?php if(isset($_POST["btnGuardarRepa"])) echo $_POST["email"]?>"/>
                                <?php
                                    if(isset($_POST["btnGuardarRepa"]) && $error_email){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                                <br/>
                                <textarea id="comentario" name="comentario" rows="4" cols="50" value="<?php if(isset($_POST["btnGuardarRepa"])) echo $_POST["comentario"]?>"></textarea>
                                <?php
                                    if(isset($_POST["btnGuardarRepa"]) && $error_comentario){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                                <br/>
                                <div>
                                    <input type="checkbox" name="subscripcion" id="subscripcion" <?php if(isset($_POST["btnGuardarRepa"]) && isset($_POST["subscripcion"])) echo "checked"; ?>/>
                                    <label for="subscripcion">Limpiar instrumento</label>
                                </div>
                            </div>
                            </div>
                        <div class="formbajobtn">
                            <input class="btn btn-danger" type="submit" name="btnGuardarRepa" id="btnGuardarRepa" value="Guardar"/>
                            <input class="btn btn-danger" type="submit" name="btnBorrarCampos" id="btnBorrarCampos" value="Borrar"/>
                        </div>
                        </form>
                    </div>
                    
                </article>
            </section>
        </main>

        <footer>
            <div>
                <div id="horario">
                    <p>Puedes contactarnos por teléfono en el 9X XXX XX XX.</p>
                    <p>Lunes a Viernes de 10:00h a 20:00h y Sábados de 11:00 - 14:00</p>
                </div>
                <div id="enlacesfooter">
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btncono" id="btncono"><strong>Conócenos mejor</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnFina" id="btnFina"><strong>Financiación</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnCooki" id="btnCooki"><strong>Política de cookies</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnPriva" id="btnPriva"><strong>Política de privacidad</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnServi" id="btnServi"><strong>Condiciones de servicio</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnLegal" id="btnLegal"><strong>Aviso legal</strong></button></form></p>
                </div>
                <div id="iconosfooter">
                    <a href=""><img src="images/icon/what.png" alt="whatsapp" width="50"></a>
                    <a href=""><img src="images/icon/insta.png" alt="instagram" width="50"></a>
                    <a href=""><img src="images/icon/you.png" alt="youtube" width="50"></a>
                    <a href=""><img src="images/icon/face.png" alt="facebook" width="50"></a>
                    <a href=""><img src="images/icon/twi.png" alt="twitter" width="50"></a>
                </div>
                <div id="copy"><p>© 2010-2022 - Clave de FA - Todos los derechos reservados.</p></div>
            </div>
        </footer>
    </body>
</html>