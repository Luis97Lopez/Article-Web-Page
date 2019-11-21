<?php
    include("../php/funciones.php");
    if(isset($_POST['txtNombre']) && isset($_POST['txtApellido']) && isset($_POST['txtUsuario']) 
    && isset($_POST['txtPassword']) && isset($_POST['txtEmail']) && isset($_POST['txtConfPassword'])
    && isset($_POST['txtBiografia']) )
    {
        extract($_POST);
        if($txtNombre != "" && $txtApellido != "" && $txtUsuario!= "" && $txtPassword != "")
        {
            if($txtPassword == $txtConfPassword)
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
                    $qry = "insert into usuarios 
                            (usuario, password, tipo, correo, nombre, apellido, biografia) values 
                            ('$txtUsuario','$txtPassword',1, '$txtEmail','$txtNombre','$txtApellido','$txtBiografia')";
                    mysqli_query($conn,$qry);

                    $idUsr = mysqli_insert_id($conn);
                    
                    $qry_img = "insert into imagenes_pp (imagen, tipo, nombre, idUsuario) values
                                ('$contenido','$tipo','$nombre','$idUsr')";
                    mysqli_query($conn,$qry_img);
                    IrAPortada();
                }
            }
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
                    
                    if( document.getElementById("txtNombre").value=="" || 
                    document.getElementById("txtApellido").value=="" || 
                    document.getElementById("txtUsuario").value=="" ||
                    document.getElementById("txtEmail").value=="" ||
                    document.getElementById("txtPassword").value=="" ||
                    document.getElementById("txtConfPassword").value=="" ||
                    document.getElementById("imagen").value == "" ||
                    document.getElementById("txtBiografia").value == "")
                    {
                        alert("Datos inválidos, completa el formulario.")
                        return false;
                    }
                    if(document.getElementById("txtPassword").value != 
                    document.getElementById("txtConfPassword").value)
                    {
                        alert("Contraseñas no coinciden");
                        return false;
                    }
                    return true;
                }
            </script>
    </head>
    <body>
        <div class="registro">
            <a href="portada.php"> <img src="../media/logo.png"> </a>
            <h1> Registro de Usuario </h1>
            <form method="post" action="registro.php" onsubmit="return VerificaFRM()" enctype="multipart/form-data">
                <div class="apartados">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="txtUsuario">Usuario</label>
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" 
                            placeholder="Usuario">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtPassword">Contraseña</label>
                            <input type="password" class="form-control" name="txtPassword" id="txtPassword" 
                            placeholder="Contraseña">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtConfPassword">Confirma Contraseña</label>
                            <input type="password" class="form-control" id="txtConfPassword" name="txtConfPassword" 
                            placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="txtEmail">Email</label>
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" 
                            placeholder="Email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="txtNombre">Nombre(s)</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                            placeholder="Nombre(s)">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="txtApellido">Apellidos</label>
                            <input type="text" class="form-control" id="txtApellido" name="txtApellido"
                            placeholder="Apellidos">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="txtBiografia">Biografia</label>
                            <textarea class="form-control" id="txtBiografia" name="txtBiografia" 
                            rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row" style="padding-left: 130px;">
                        <div class="form-group">
                            <label for="imagen">Sube tu Imagen de Perfil</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registro</button>
                <a href="portada.php">
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                </a>
            </form>
            
        </div>
    </body>
</html>