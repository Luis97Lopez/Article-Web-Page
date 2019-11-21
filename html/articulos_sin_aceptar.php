<?php
    session_start();
    include("../php/funciones.php");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/styles_lista_articulos.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="cuerpo">
        <div class="cabecera bg-light">
            <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
        </div>
        <div class="layout">
                <span class="texto_busqueda"> Últimos artículos </span>
                <a href="portada.php" style="float:right; ">
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">
                        Regresar
                    </button>
                </a>
                <hr class="my-4" style="margin-top:10px !important;">
                <?php
                $conn = ConectarBD();
                    $qry = "select idArticulo, titulo, fecha, aprobado, texto, idClasificacion, idUsuario from articulos
                            where aprobado=0 order by fecha desc";
                    $resultado = mysqli_query($conn, $qry);
                    if(mysqli_num_rows($resultado)>0)
                    {
                        while($registro = mysqli_fetch_array($resultado))
                        {
                ?>          
                            <div class="articulo_busqueda">
                                <?php
                                    $imagen = GetImagenArt($registro['idArticulo']);
                                    echo "<a href='articulo.php?idA=".$registro['idArticulo']."' class='busqueda_imagen'>
                                        <img src='../php/imagen.php?idI=".$imagen['idImagen']."'>";
                                ?>
                                </a>
                                <div class="busqueda_info">
                                    <div class="info_apartado"> 
                                        <?php
                                            $clasificacion = GetClasificacion($registro['idClasificacion']);
                                            echo "<a href='articulos_por_clasificacion.php?idC=".
                                            $clasificacion['idClasificacion']."' class='clasificacion'> 
                                                ".$clasificacion['nombre']." </a>";
                                        ?>
                                    </div>
                                    <div class="info_apartado"> 
                                        <?php
                                            echo "<a href='articulo.php?idA=".$registro['idArticulo']."' 
                                            class='titulo'>".$registro['titulo']."</a>";
                                        ?>
                                    </div>
                                    <div class="info_apartado"> 
                                        <?php
                                            $usuario = GetUsuario($registro['idUsuario']);
                                            echo "<a href='perfil.php?idU=".$registro['idUsuario']."' 
                                            class='autor'>".$usuario['usuario']."</a>";
                                        ?>
                                    </div>
                                    <div class="info_apartado"> 
                                        <?php
                                            echo "<span class='fecha'> 
                                            ".$registro['fecha']."
                                            </span>";
                                        ?>
                                    </div>
                                    <div class="info_apartado"> 
                                        <?php
                                        echo "  <a href='../php/aceptar_articulo.php?idA=".$registro['idArticulo']."' 
                                                class='boton'> <i class='fas fa-check'></i> Aceptar  </a>
                                                <a href='../php/eliminar_articulo.php?idA=".$registro['idArticulo']."' 
                                                class='boton'> <i class='fas fa-times'></i> Rechazar </a>";                                        
                                        ?>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>



        <!----------------------SCRIPTS ---------------------->
        <script src="https://kit.fontawesome.com/c443ffec66.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" 
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
        crossorigin="anonymous"></script>
    </body>
</html>