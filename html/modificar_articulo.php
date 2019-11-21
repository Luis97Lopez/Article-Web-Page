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
            if(isset($_POST['txtTitulo']) && isset($_POST['texto']) && 
            isset($_POST['opciones']) && isset($_POST['fecha']))
            {
                $conn = ConectarBD();
                $qry = "update articulos set 
                titulo='".$_POST['txtTitulo']."', 
                texto='".$_POST['texto']."', 
                fecha='".$_POST['fecha']."', 
                aprobado='".$articulo['aprobado']."', 
                idClasificacion= '".$_POST['opciones']."', 
                idUsuario='".$_SESSION['idUsuario']."' 
                where idArticulo='".$_GET['idA']."'";
                mysqli_query($conn,$qry);
                IrAPortada();
            }
        }
        else
            IrAPortada();
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
            <h5> Datos necesarios para modificar artículo: </h5>
            <?php
                echo "<form action='modificar_articulo.php?idA=".$_GET['idA']."' method='post' 
                onsubmit='return VerificaFRM()'>";
            ?>
                <div class="apartados">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="txtTitulo">Título:</label>
                            <?php
                                echo "<input type='text' class='form-control' id='txtTitulo' name='txtTitulo'
                                value='".$articulo['titulo']."'>";
                            ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="texto">Texto</label>
                            <textarea class="form-control" id="texto" name="texto" rows="10"><?php echo $articulo['texto']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label class="my-1 mr-2" for="opciones">Clasificación:</label>
                            <select class="custom-select my-1 mr-sm-2" id="opciones" name="opciones">
                                <?php
                                    $clasificaciones = GetClasificaciones();
                                    while($registro = mysqli_fetch_array($clasificaciones))
                                    {
                                        if($registro['idClasificacion'] == $articulo['idClasificacion'])
                                        {
                                            echo "<option selected value='".$registro['idClasificacion']."'> 
                                            ".$registro['nombre']." </option>";
                                        }
                                        else
                                        {
                                            echo "<option value='".$registro['idClasificacion']."'> 
                                            ".$registro['nombre']." </option>";
                                        }   
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="fecha" class="my-1 mr-2">Fecha de Publicación</label>
                            <input class="form-control" type="date" id="fecha" name="fecha"
                                    <?php echo "value='".$articulo['fecha']."'"?>;
                            >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <a href="modificar_imagen.php?idA=<?php echo $articulo['idArticulo'] ?>">
                                <button type="button" class="btn btn-primary" style="margin-left:15px;">Modificar Imagen</button>
                            </a>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Modificar Artículo</button>
                <a href="portada.php">
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                </a>
            </form>
            
        </div>
    </body>
</html>