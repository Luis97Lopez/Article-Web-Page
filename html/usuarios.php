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
        <link rel="stylesheet" href="../css/styles_usuarios.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="cuerpo">
        <div class="cabecera bg-light">
            <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
        </div>
        <div class="layout">
            <span class="texto_busqueda"> Usuarios </span>
            
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
                $qry = "select * from usuarios";
                $resultado = mysqli_query($conn, $qry);
                if(mysqli_num_rows($resultado)>0)
                {
                    while($registro = mysqli_fetch_array($resultado))
                    {
                        echo "  <div id='chats'>
                        <div class='chat'>
                            <div class='icono'>";
                            $imagen = GetImagen($registro['idUsuario']);
                            if(!empty($imagen))
                                echo "<img src='../php/imagen_pp.php?idI=".$imagen['idImagen']."'>";
                            else
                                echo "<img src='../media/perfil1.jpg'>";
                            echo "</div>
                            <a  href=perfil.php?idU='".$registro['idUsuario']."' class='usuario'> ".$registro['usuario']." </a>
                            <div class='botones'>
                            ";
                            if($registro['tipo'] == 0)
                                echo "<a href='../php/hacer_admin.php?idU=".$registro['idUsuario']."' class='boton'> Quitar Admin </a>";
                            else
                                echo "<a href='../php/quitar_admin.php?idU=".$registro['idUsuario']."' class='boton'> Hacer Admin </a>";
                            echo"<a href='../php/eliminar_usuario.php?idU=".$registro['idUsuario']."' class='boton'> Eliminar </a> 
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