<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_SESSION['idUsuario']) || !isset($_GET['idUd']) || !isset($_GET['idUr']))
    {
        IrAPortada();
    }
    else
    {
        
        if($_GET['idC'] == "" ||$_GET['idUd'] == "" || $_GET['idUr'] == "")
        {
            IrAPortada();
        }

        $conversacion = GetArticulo($_GET['idC']);
        $remitente = GetUsuario($_GET['idUr']);
        $destinatario = GetUsuario($_GET['idUd']);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/styles_chatssss.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script>
            function VerificaMensaje()
            {
                if(document.getElementById("txtComentario").value == "")
                {
                    alert("Agrega texto al mensaje");
                    return false;
                }
                return true;
            }
        </script>
    
    </head>
    <body>
        <div class="ventana">
            <a href="portada.php"> <img src="../media/logo.png" class="logo"> </a>
            <div class="encabezado">
                <a class="usuario_icono" href="#"> 
                <?php
                    $imagen = GetImagen($destinatario['idUsuario']);
                    if(!empty($imagen))
                        echo "<img src='../php/imagen_pp.php?idI=".$imagen['idImagen']."'>";
                    else
                        echo "<img src='../media/perfil1.jpg'";
                ?>
                </a>
                <h1 class="usuario_nombre"> <?php echo $destinatario['nombre']." " . $destinatario['apellido'] ?> </h1>

            </div>
            
            <div class="mensajes">
                <?php
                    $mensajes = GetMensajes($_GET['idC']);
                    if(!empty($mensajes))
                    {
                        while($mensaje = mysqli_fetch_array($mensajes))
                        {
                            if($mensaje['idUsuarioDestinatario'] != $_SESSION['idUsuario'])
                            {
                                echo"
                                    <div class='mensaje derecha'>
                                        <h2 class='nombre_mensaje'> ".$remitente['usuario']."</h2>
                                        <span class='texto_mensaje'> ".$mensaje['mensaje']." </span><br>
                                        <span class='texto_mensaje'> ".$mensaje['fecha']." </span>
                                    </div>
                                ";
                            }
                            else
                            {
                                echo"
                                    <div class='mensaje izquierda'>
                                        <h2 class='nombre_mensaje'> ".$destinatario['usuario']."</h2>
                                        <span class='texto_mensaje'> ".$mensaje['mensaje']." </span> <br>
                                        <span class='texto_mensaje'> ".$mensaje['fecha']." </span>
                                    </div>
                                ";
                            }
                        }
                    }
                ?>
            </div>
            <div class="nuevo">
                    <?php
                        echo "<form action='../php/mandar_mensaje.php?idC=".$_GET['idC']."&idUr=".$_SESSION['idUsuario']."&idUd=".$_GET['idUd']."' method='post'  onsubmit='return VerificaMensaje()'>";
                    ?>
                    <textarea class="form-control" id="txtMensaje" name="txtMensaje" rows="3"></textarea> <br>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                    <?php echo "<a href='conversaciones.php?idU=".$_GET['idUr']."'>"; ?>
                        <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                    </a>
                </form>
            </div>
        </div>
    </body>
</html>