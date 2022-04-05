<?php
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    if(!$conexion){
        die("Imposible conectar");
    }
    mysqli_set_charset($conexion,"utf8");

    function obtener_producto($id){
        @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if(!$conexion){
            die("Imposible conectar");
        }

        mysqli_set_charset($conexion, "utf8");
        $consulta="select * from productos where idProdu='".$id."'";
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

    function obtener_clase($id){
        @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        if(!$conexion){
            die("Imposible conectar");
        }

        mysqli_set_charset($conexion, "utf8");
        $consulta="select * from clases where idClase='".$id."'";
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

    if(isset($_POST["btnEli"])){
        unset($_SESSION["lista"][$_POST["datoGuardar"]]);
    }

    if(isset($_POST["btnPedido"])){
        if($_SESSION["lista"] != null){
            $jsonArray=array();
            foreach ($_SESSION["lista"] as $valor) {
                if($valor[1]=="productos"){
                    
                    $jsonArray[]=obtener_producto($valor[0]);

                    $produc=obtener_producto($valor[0]);
                    @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                    if(!$conexion){
                        die("Imposible conectar");
                    }
                    mysqli_set_charset($conexion,"utf8");

                    $stock=$produc["stock"]-1;

                    $consulta="UPDATE productos SET stock='".$stock."' WHERE idProdu=".$produc["idProdu"];
                    $resultado=mysqli_query($conexion,$consulta);
                    if(!$resultado){
                        msqli_close();
                        die("Imposible realizar la consulta.");
                    }
                    $nueva_id=mysqli_insert_id($conexion);
                    mysqli_close($conexion);

                }else{
                    
                    $jsonArray[]=obtener_clase($valor[0]);
                }
            }
    
            $DateAndTime = date('Y-m-d h:i:s', time()); 

            @$conexion=mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            if(!$conexion){
                die("Imposible conectar");
            }
            mysqli_set_charset($conexion,"utf8");

            $idUsu=$_SESSION["idUsu"]["idUsu"];

            $consulta="INSERT INTO pedidos(idUsu, jsonPedido, fecha, precio) VALUES('".$idUsu."','".json_encode($jsonArray)."','".$DateAndTime."','".$_POST["datoGuardar"]."')";
            $resultado=mysqli_query($conexion,$consulta);
            if(!$resultado){
                msqli_close();
                die("Imposible realizar la consulta.");
            }
            $nueva_id=mysqli_insert_id($conexion);
            mysqli_close($conexion);
            unset($_SESSION["lista"]);
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
        
                <article class="espacioItem">
                    <h2>Carrito de la compra</h2>
                    <div class="retener">
                    <?php
                if(isset($_SESSION["lista"])){

                    $totalPedido = 0;
                    foreach ($_SESSION["lista"] as $valor) {
                        if($valor[1]=="productos"){
                            
                            $fila=obtener_producto($valor[0]);
                            
                            ?>
                                <div class="card">
                                    <img src="<?php echo $fila["url"] ?>" class="card-img-top" alt="<?php echo $fila["nombre"] ?>">
                                    <div>
                                        <form method="post" action="index.php">
                                            <h5 class="card-title"><?php echo $fila["nombre"] ?></h5>
                                            <p class="card-text"><?php echo $fila["precio"] ?>€</p>
                                            <input class="ocul" type="text" name="datoGuardar" id="datoGuardar" value="<?php echo key($_SESSION["lista"]) ?>"/>
                                            <button type="submit" name="btnEli" id="btnEli" class="btn btn-warning">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            $totalPedido += $fila["precio"];

                        }else{
                            
                            $fila=obtener_clase($valor[0]);

                            ?>

                                <div class="card">
                                    <img src="<?php echo $fila["url"] ?>" class="card-img-top" alt="<?php echo $fila["tipoClase"] ?>">
                                    <div class="card-body">
                                        <form method="post" action="index.php">
                                            <h5 class="card-title"><?php echo $fila["tipoClase"] ?></h5>
                                            <p class="card-text"><?php echo $fila["precio"] ?>€</p>
                                            <p class="card-text"><?php echo $fila["fecha"] ?></p>
                                            <input class="ocul" type="text" name="datoGuardar" id="datoGuardar" value="<?php echo key($_SESSION["lista"]) ?>"/>
                                            <button type="submit" name="btnEli" id="btnEli" class="btn btn-warning">Eliminar</button>
                                        </form>
                                        
                                    </div>
                                </div>

                            <?php
                            $totalPedido += $fila["precio"];
                        }
                        next($_SESSION["lista"]);
                    }

                }else{
                    echo "<h3>No hay nada en el carrito.</h3>";
                }

                    ?>
                    </div> 

                    <div>
                        <form method="post" action="index.php">
                            <span><strong>Total: </strong><?php if(isset($_SESSION["lista"])) echo $totalPedido ?>€</span>
                            <input class="ocul" type="text" name="datoGuardar" id="datoGuardar" value="<?php if(isset($_SESSION["lista"])) echo $totalPedido ?>"/>
                            <button type="submit" name="btnPedido" id="btnPedido" class="btn btn-danger">Comprar</button>
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