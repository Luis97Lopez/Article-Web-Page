<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_GET['idU']))
    {
        IrAPortada();
    }
    else
    {
        $usuario = GetUsuario($_GET['idU']);
        if(empty($usuario))
        {
            IrAPortada();
        }
    }
?>

<HTML>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../css/styles_perfilsss.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="cuerpo">
        <div class="cabecera bg-light">
            <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
        </div>
        <div class="perfil">
            <div class="layout">
                <div class="titulo"> <h1> Usuario </h1> </div>
                <div class="imagen">
                    <?php
                        $imagen = GetImagen($usuario['idUsuario']);
                        if(!empty($imagen))
                        {
                            echo "<img src='../php/imagen_pp.php?idI=".$imagen['idImagen']."'>";
                        }
                        else
                        {
                            echo "<img src='../media/perfil1.jpg'";
                        }
                        if(!empty($_SESSION) && $_SESSION['idUsuario'] == $usuario['idUsuario'])
                        {
                            echo "<a href='modificar_imagen_pp.php?idU=".$usuario['idUsuario']."'>
                                <button type='button' class='btn btn-primary' style='margin-left:15px; margin-top:15px;'>
                                    Modificar Imagen
                                </button>
                                </a>";
                        }
                    ?>
                </div>
                <div class="datos">
                    <?php
                        
                        echo "Usuario: <label class='nombre'> ". $usuario['usuario'] . " </label> <br>";
                        echo "Nombre: <label class='nombre'> ". $usuario['nombre'] . " " . $usuario['apellido'] .
                        " </label> <br>";
                        echo "Biografía: <label class='nombre'>" . $usuario['biografia'] ."</label>";
                        if(!empty($_SESSION) && $_SESSION['idUsuario'] == $usuario['idUsuario'])
                        {
                            echo "<a href='modificar_perfil.php?idU=".$usuario['idUsuario']."'>
                            <button type='button' class='btn btn-primary' style='margin-left:15px;'>
                                Modificar Perfil
                            </button>
                            </a>";
                            echo "<a href='articulos_por_autor.php?idU=".$usuario['idUsuario']."'>
                            <button type='button' class='btn btn-primary' style='margin-left:15px;'>
                                Ver mis artículos
                            </button>
                        </a>";
                            echo "<a href='conversaciones.php?idU=".$usuario['idUsuario']."'>
                                <button type='button' class='btn btn-primary' style='margin-left:15px;'>
                                    Ver mis conversaciones
                                </button>
                            </a>";
                        }
                        else{
                            echo "<a href='articulos_por_autor.php?idU=".$usuario['idUsuario']."'>
                            <button type='button' class='btn btn-primary' style='margin-left:15px;'>
                                Ver artículos
                            </button>
                            </a>";
                            echo "<a href='../php/agrega_conversacion.php?idUd=".$usuario['idUsuario']."&idUr=".$_SESSION['idUsuario']."'>
                                <button type='button' class='btn btn-primary' style='margin-left:15px;'>
                                    Mandar Mensaje
                                </button>
                            </a>";
                        }
                        echo "<a href='portada.php'>
                            <button type='button' class='btn btn-primary' style='margin-left:15px;'>
                                Regresar
                            </button>
                        </a>";
                    ?>
                </div>
            </div>
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
</HTML>