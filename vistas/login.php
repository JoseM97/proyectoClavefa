<?php

    if(isset($_POST["btnLogin"])){
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";

        if(!$error_usuario && !$error_clave){
            $usuario=obtener_usuario($_POST["usuario"], md5($_POST["clave"]));

            if($usuario){
                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST['clave']);
                $_SESSION["idUsu"]=obtener_id_usuario($_SESSION["usuario"], $_SESSION["clave"]);
                $_SESSION["ultimo_acceso"]=time();
                header("Location:index.php");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="images/icon/logo.png">
    <title>Clave de FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

                <h2>login</h2>
                <?php
                        if(isset($_POST["btnRepa"]) || isset($_POST["btnGuardarRepa"])){
                            echo "Necesitas inciar sesión para mandar a reparar un instrumento.";
                        }

                        if(isset($_POST["btncarrito"]) || isset($_POST["btnEli"]) || isset($_POST["btnPedido"])){
                            echo "Necesitas inciar sesión para usar el carrito.";
                        }
                    ?>
                <div>
                    <form method="post" action="index.php">
                        <?php
                            if(isset($_SESSION["restringida"])){
                                echo "<p>Zona restringida</p>";
                                unset($_SESSION["restringida"]);
                            }

                            if(isset($_SESSION["tiempo"])){
                                echo "<p>Sesión caducada</p>";
                                unset($_SESSION["tiempo"]);
                            }
                        ?>
                        <div>
                            <div>
                                <label for="usuario">Email:</label>
                                <br />
                                <label for="clave">Contraseña:</label>

                            </div>
                            <div>
                                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["
                                    btnLogin"])) echo $_POST["usuario"]; ?>"/>
                                <?php
                                    if(isset($_POST["btnLogin"]) && $error_usuario){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                                <br />
                                <input type="password" name="clave" id="clave" />
                                <?php
                                    if(isset($_POST["btnLogin"]) && $error_clave){
                                        echo "*Campo vacío*";
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="formbajobtn">
                            <input class="btn btn-danger" type="submit" name="btnLogin" id="btnLogin" value="Entrar" />
                            <input class="btn btn-danger" type="submit" name="btnRegistro" id="btnRegistro"
                                value="Registrarse" />
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
            <div id="copy">
                <p>© 2010-2022 - Clave de FA - Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>