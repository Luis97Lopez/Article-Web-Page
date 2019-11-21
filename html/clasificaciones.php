<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_SESSION['idUsuario']) || $_SESSION['tipo'] != 0)
    {
        IrAPortada();
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/styles_lista_clasificaciones.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="cuerpo">
        <div class="cabecera bg-light">
            <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
        </div>
        <div class="layout">
            <span class="texto_busqueda"> Clasificaciones </span>
            
            <a href="portada.php" style="float:right; ">
                <button type="button" class="btn btn-primary" style="margin-left:15px;">
                    Regresar
                </button>
            </a>
            <a href="agregar_clasificacion.php" style="float:right;">
                <button type="button" class="btn btn-primary" style="margin-left:15px;">
                    Agregar
                </button>
            </a>
            <hr class="my-4" style="margin-top:20px !important;">

            <?php
                $conn = ConectarBD();
                $qry = "select idClasificacion, nombre from clasificaciones";
                $resultado = mysqli_query($conn, $qry);
                if(mysqli_num_rows($resultado)>0)
                {
                    while($registro = mysqli_fetch_array($resultado))
                    {
                        echo "  <div class='articulo_busqueda'>
                                    <div class='busqueda_info'>
                                        <div class='info_apartado'>". $registro['nombre']." </div>
                                        <div class='info_apartado'> 
                                            <a href='../html/modificar_clasificacion.php?idC=".
                                            $registro['idClasificacion']."' class='boton'> 
                                            <i class='fas fa-edit'></i> Editar  </a>
                                            
                                            <a href='../php/eliminar_clasificacion.php?idC=".
                                            $registro['idClasificacion']."' class='boton'> 
                                            <i class='far fa-trash-alt'></i> Eliminar </a>
                                        </div>
                                    </div>
                                </div>";
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