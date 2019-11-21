<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_SESSION['idUsuario']) && !isset($_GET['idA']))
    {
        IrAPortada();
    }
    else if($_GET['idA']!="")
    {
        $articulo = GetArticulo($_GET['idA']);
        if($_SESSION['idUsuario'] != $articulo['idUsuario'])
        {
            IrAPortada();
        }

        if(!empty($_FILES['imagen']['tmp_name']))
        {
            $nombre = $_FILES['imagen']['name'];
            $tipo = $_FILES['imagen']['type'];
            $nombreTemporal = $_FILES['imagen']['tmp_name'];
            $tamanio = $_FILES['imagen']['size'];
            
            //recuperar el contenido del archivo
            $fp = fopen($nombreTemporal,"r");
            $contenido = fread($fp,$tamanio);
            fclose($fp);

            $contenido = addslashes($contenido);
            $conn = ConectarBD();
            
            $imagen = GetImagenArt($_GET['idA']);

            $qry = "update imagenes set 
                    imagen='".$contenido."',
                    tipo='".$tipo."',
                    nombre='".$nombre."'
                    where idImagen='".$imagen['idImagen']."'";
            
            mysqli_query($conn,$qry);
            IrAArticulo($_GET['idA']);
        }
        
    }
?>

<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../css/styles_registro.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
            <script type="text/javascript">
                function VerificaFRM()
                {
                    
                    if(document.getElementById("imagen").value == "" )
                    {
                        alert("Datos inválidos, completa el formulario.")
                        return false;
                    }
                    return true;
                }
            </script>
    </head>
    <body>
        <div class="registro">
            <a href="portada.php"> <img src="../media/logo.png"> </a>
            <h1> 
            <?php
                echo " ¡Hola ".$_SESSION['usuario']."!";
            ?>    
             - Modificar imagen del Artículo:  
            <?php 
                echo $articulo['titulo'] . "</h1>";

                echo "<form method='post' action='modificar_imagen.php?idA=".$_GET['idA']."'
                onsubmit='return VerificaFRM()' enctype='multipart/form-data'>";
            ?>
           
                <div class="apartados">
                    <div class="form-row" style="padding-left: 130px;">
                        <div class="form-group">
                            <label for="imagen">Sube tu nueva Imagen del Artículo</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Modificar Imagen</button>
                <?php
                    echo "<a href='modificar_0articulo.php?idA=".$_GET['idA']."'>";
                ?>
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                </a>
            </form>
            
        </div>
    </body>
</html>