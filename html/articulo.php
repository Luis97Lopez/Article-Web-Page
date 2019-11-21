<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_GET['idA']))
    {
        IrAPortada();
    }
    else
    {
        $articulo = GetArticulo($_GET['idA']);
        if(empty($articulo))
        {
            IrAPortada();
        }
        else if ($articulo['aprobado'] == 0)
        {
            IrAArticulosPerfil($articulo['idUsuario']);
        }
    }
?>


<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../css/styles_articulos.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script>
            function VerificaComentario()
            {
                
                if(<?php 
                    if(empty($_SESSION))
                        echo "true";
                    else
                        echo "false";
                    ?>)
                {
                    alert("Inicia sesión para añadir comentario");
                    return false;
                }
                else if(document.getElementById("txtComentario").value == "")
                {
                    alert("Agrega texto al comentario");
                    return false;
                }
                return true;
                
            }
        </script>
    
    </head>
    <body class="cuerpo">
            <div class="cabecera bg-light">
                <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
            </div>
            <div class="articulo">
                <div class="layout">
                    <div class="titulo">
                        <?php
                            echo "<h1>".$articulo['titulo']."</h1>";
                        ?>
                    </div>
                    <hr class="my-4">
                    <div class="datos">
                        <span class="fecha">
                            <?php echo $articulo['fecha']?>
                        </span>
                        <?php
                            echo "<a href='perfil.php?idU=".$articulo['idUsuario']."' class='autor'>";
                             $usuario = GetUsuario($articulo['idUsuario']);
                            echo $usuario['nombre'] . " " . $usuario['apellido']; ?>
                        </a>
                    </div>
                    <div class="imagen">
                        <?php
                            $imagen = GetImagenArt($articulo['idArticulo']);
                            if(!empty($imagen))
                            {
                                echo "<img src='../php/imagen.php?idI=".$imagen['idImagen']."'>";
                            }
                            else
                            {
                                echo "<img src='../media/logo.png'";
                            }                        
                        ?>
                    </div>
                    <div class="texto">
                        <?php echo $articulo['texto'];?>
                    </div>
                    <div class="container_comentarios">
                        <div class="titulo"> <h1> Comentarios</h1> </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" 
                                role="tab" aria-controls="home" aria-selected="true">Comentarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" 
                                role="tab" aria-controls="profile" aria-selected="false">Añadir Comentario</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="conjunto_comentarios">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <?php
                            $comentarios = GetComentarios($articulo['idArticulo']);
                            if(!empty($comentarios))
                            {
                                while($registro = mysqli_fetch_array($comentarios))
                                {
                                    $usuario = GetUsuario($registro['idUsuario']);
                                    $imagen = GetImagen($usuario['idUsuario']);
                                    echo "
                                    <div class='comentarios'>
                                        <div class='comentario'>
                                            <div class='imagen_comentario'> 
                                                <img src='../php/imagen_pp.php?idI=".$imagen['idImagen']."'>
                                                <a href='../php/eliminar_comentario.php?idC=".$registro['idComentario']."' 
                                                class='boton' style='font-size:12px;  text-decoration:none;'> 
                                                <i class='far fa-trash-alt'></i> Eliminar </a>
                                            </div>
                                            <a href='perfil.php?idU=".$usuario['idUsuario']."'> 
                                                <h1 class='usuario_comentario'> ".$usuario['nombre']." </h1> 
                                            </a>
                                            <span class='fecha_comentario'> ".$registro['fecha']." </span>
                                            <span class='texto_comentario'> ".$registro['comentario']."</span>
                                        </div>
                                    </div>";
                                }
                            }
                            else
                            {
                                echo "
                                <div class='comentarios'>
                                    <div class='comentario'>
                                        <h1> No hay Comentarios </h1> 
                                        </div>         
                                </div>";
                            }
                            echo "
                            </div>";
                        ?>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <label for="txtComentario" style="margin-top:15px;">Comentario:</label>
                                <?php
                                    echo "<form action='../php/agregar_comentario.php?idU=".$_SESSION['idUsuario']."&idA=".$_GET['idA']."' method='post'  onsubmit='return VerificaComentario()'>";
                                ?>
                                    <textarea class="form-control" id="txtComentario" name="txtComentario" rows="3"></textarea> <br>
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                            </div>
                        </div>
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
</html>