<?php
    session_start();
    include("../php/funciones.php");
    if(!isset($_SESSION['idUsuario']) || $_SESSION['tipo'] != 0)
    {
        IrAPortada();
    }
    else{
        if(isset($_POST['txtNombre']))
        {
            $conn = ConectarBD();
            $qry = "insert into clasificaciones (nombre) values ('".$_POST['txtNombre']."')";
            mysqli_query($conn,$qry);
            IrAClasificaciones();
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
                    if(document.getElementById("txtNombre").value =="")
                    {
                        alert("Escribe un nombre de género");
                        return false;
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
            <h5> Datos necesarios para publicar clasificación: </h5>
            <form action="agregar_clasificacion.php" method="post" onsubmit="return VerificaFRM()">
                <div class="apartados">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="inputName">Nombre:</label>
                            <input type="texto" class="form-control" id="txtNombre" name="txtNombre" 
                            placeholder="Nombre">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="portada.php">
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                </a>
            </form>
            
        </div>
    </body>
</html>