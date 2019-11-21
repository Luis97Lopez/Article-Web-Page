<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_SESSION['idUsuario']))
    {
        IrAPortada();
    }
    else{
        if(isset($_POST['txtTitulo']) && isset($_POST['texto']) && 
        isset($_POST['opciones']) && isset($_POST['fecha']))
        {
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
                $qry = "insert into articulos (titulo, texto, fecha, aprobado, idClasificacion, idUsuario) 
                values ('".$_POST['txtTitulo']."',
                '".$_POST['texto']."',
                '".$_POST['fecha']."',
                '0',
                '".$_POST['opciones']."',
                '".$_SESSION['idUsuario']."'
                )";
                mysqli_query($conn,$qry);

                $idArt = mysqli_insert_id($conn);
                    
                $qry_img = "insert into imagenes (imagen, tipo, nombre, idArticulo) values
                            ('$contenido','$tipo','$nombre','$idArt')";
                mysqli_query($conn,$qry_img);

                IrAArticulosPerfil($_SESSION['idUsuario']);
            }
        }
    }
?>

<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../css/styles_agregar_articulo.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <script>
                function VerificaFRM()
                {
                    if(document.getElementById("txtTitulo").value == "")
                    {
                        alert("Título faltante");
                        return false;
                    }
                    else if(document.getElementById("texto").value == "")
                    {
                        alert("Texto faltante");
                        return false;
                    }
                    else{
                        opciones = document.getElementById("opciones");
                        if(opciones.options[opciones.selectedIndex].value == 0)
                        {
                            alert("Escoge una opción de género");
                            return false;
                        }
                        else if(document.getElementById("fecha").value == "")
                        {
                            alert("Escoge una fecha");
                            return false;
                        }
                        else if(document.getElementById("imagen").value == "")
                        {
                            alert("Escoge una imagen para el artículo");
                            return false;
                        }
                    }
                    return true;
                }
            </script>    
    </head>
    <body>
        <div class="registro">
            <a href="portada.php"> <img src="../media/logo.png"> </a>
            <?php
                echo "<h1> ¡Hola ".$_SESSION['usuario']."! </h1>";
            ?>
            <h5> Datos necesarios para publicar artículo: </h5>
            <form action="agregar_articulo.php" method="post" onsubmit="return VerificaFRM()" enctype="multipart/form-data">
                <div class="apartados">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="txtTitulo">Título:</label>
                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo"
                            placeholder="Título">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="texto">Texto</label>
                            <textarea class="form-control" id="texto" name="texto" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label class="my-1 mr-2" for="opciones">Clasificación:</label>
                            <select class="custom-select my-1 mr-sm-2" id="opciones" name="opciones">
                                <option selected value="0"> Escoge una opción....</option>
                                <?php
                                    $clasificaciones = GetClasificaciones();
                                    while($registro = mysqli_fetch_array($clasificaciones))
                                    {
                                        echo "<option value='".$registro['idClasificacion']."'> 
                                        ".$registro['nombre']." </option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="fecha" class="my-1 mr-2">Fecha de Publicación</label>
                            <input class="form-control" type="date" id="fecha" name="fecha">
                        </div>
                    </div>
                    <div class="form-row" style="padding-left: 130px;">
                        <div class="form-group">
                            <label for="imagen">Sube la Imagen de tu Artículo</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Publicar</button>
                <a href="portada.php">
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                </a>
            </form>
            
        </div>
    </body>
</html>