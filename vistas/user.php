<?php
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion){
        die("Imposible conectar");
    }
    mysqli_set_charset($conexion,"utf8");

    if(isset($_POST["btnComprarProdu"])){
        $idProdu=obtener_id_producto($_POST["datoGuardar"]);

        $id;
        foreach ($idProdu as $valor) {
            $id=$valor;
        }

       $_SESSION["lista"][]=array($id, "productos");
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
                            <li><form method="post" action="index.php"><button type="submit" name="btnFina" id="btnFina">Financiaci??n</button></form></li>
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
                    
                <h2>Usted est?? logeado correctamente</h2>
                <form action="index.php" method="post">
                    <input class="btn btn-warning" type="submit" name="btnCerrarSesion" value="Salir"/>
                </form>

                <div>
                    <img class="ima" src="images/2.jpg" alt="menu" width="100%">
                </div>

                <h2>Productos recomendados</h2>
                    <div id="destacados">
                        <?php
                            $consulta="select * from productos WHERE destacado='si'";
                            $resultado=mysqli_query($conexion,$consulta);

                            while($fila=mysqli_fetch_assoc($resultado)){
                                ?>

                                    <div class="card" style="width: 18rem;">
                                    <form method="post" action="index.php">
                                        <input class="ocul" type="text" name="datoGuardar" id="datoGuardar" value="<?php echo $fila["idProdu"] ?>"/>
                                        <button class="btnIma" type="submit" name="btnDetalleProdu" id="btnDetalleProdu">
                                            <img src="<?php echo $fila["url"] ?>" class="card-img-top" alt="<?php echo $fila["nombre"] ?>">
                                        </button>
                                    </form>
                                        <div class="card-body">
                                            <form method="post" action="index.php">
                                                <h5 class="card-title"><?php echo $fila["nombre"] ?></h5>
                                                <input class="ocul" type="text" name="datoGuardar" id="datoGuardar" value="<?php echo $fila["nombre"] ?>"/>
                                                <p class="card-text"><?php echo $fila["precio"] ?>???</p>
                                                <button type="submit" name="btnComprarProdu" id="btnComprarProdu" class="btn btn-warning">Comprar</button>
                                            </form>
                                            
                                        </div>
                                    </div>

                                <?php
                            }
                        ?>
                    </div>
                    
                </article>
            </section>
        </main>

        <footer>
            <div>
                <div id="horario">
                    <p>Puedes contactarnos por tel??fono en el 9X XXX XX XX.</p>
                    <p>Lunes a Viernes de 10:00h a 20:00h y S??bados de 11:00 - 14:00</p>
                </div>
                <div id="enlacesfooter">
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btncono" id="btncono"><strong>Con??cenos mejor</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnFina" id="btnFina"><strong>Financiaci??n</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnCooki" id="btnCooki"><strong>Pol??tica de cookies</strong></button></form></p>
                    <p><form method="post" action="index.php"><button class="paraBotones" type="submit" name="btnPriva" id="btnPriva"><strong>Pol??tica de privacidad</strong></button></form></p>
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
                <div id="copy"><p>?? 2010-2022 - Clave de FA - Todos los derechos reservados.</p></div>
            </div>
        </footer>
    </body>
</html>