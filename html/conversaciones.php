<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_SESSION['idUsuario']) && !isset($_GET['idU']))
    {
        IrAPortada();
    }
    else if($_GET['idU']!="")
        {
            $usuario = GetUsuario($_GET['idU']);
            if($_SESSION['idUsuario'] != $usuario['idUsuario'])
            {
                IrAPortada();
            }
        }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/styles_conversaciones.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="cuerpo">
        <div class="cabecera bg-light">
            <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
        </div>
        <div class="layout">
            <h1 class="texto_conversacion"> Mis Conversaciones </span>
            <a href="perfil.php" style="float:right; ">
                <button type="button" class="btn btn-primary" style="margin-left:15px; margin-top:10px;">
                    Regresar
                </button>
            </a>
            <hr class="my-4" style="margin-top:10px !important;">
            <?php
                $conversaciones = GetConversaciones($_GET['idU']);
                if(empty($conversaciones))
                {
                        echo "<h1> No tienes conversaciones </h1>";
                }
                else
                {
                    while($registro = mysqli_fetch_array($conversaciones))
                    {
                        if($registro['idUsuario2'] == $_SESSION['idUsuario'])
                            $destinatario = GetUsuario($registro['idUsuario1']);
                        else
                            $destinatario = GetUsuario($registro['idUsuario2']);
                        echo "
                        <div id='chats'>
                            <a href='chat.php?idC=".$registro['idConversacion']."&idUr=".$_SESSION['idUsuario']."&idUd=".$destinatario['idUsuario']."'> <div class='chat'>
                                <div class='icono'>";
                                $imagen = GetImagen($destinatario['idUsuario']);
                                if(!empty($imagen))
                                    echo "<img src='../php/imagen_pp.php?idI=".$imagen['idImagen']."'>";
                                else
                                    echo "<img src='../media/perfil1.jpg'";
                                echo "</div>
                                <div class='usuario'> ".$destinatario['usuario']." </div>
                                <div class='ult_mensaje'> Último mensaje: <br> - PPPPEEEEEEEEENNNNNNNNNDDDDDDDIENTE </div>
                            </div> </a>
                        </div>
                        ";
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