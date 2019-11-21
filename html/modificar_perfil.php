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

        if(isset($_POST['txtNombre']) && isset($_POST['txtApellido']) && isset($_POST['txtUsuario']) 
        && isset($_POST['txtPassword']) && isset($_POST['txtEmail']) && isset($_POST['txtConfPassword'])
        && isset($_POST['txtBiografia']) )
        {
            extract($_POST);
            if($txtNombre != "" && $txtApellido != "" && $txtUsuario!= "" && $txtPassword != "")
            {
                if($txtPassword == $txtConfPassword)
                {
                    $conn = ConectarBD();
                    $qry = "update usuarios set 
                    usuario='".$txtUsuario."',
                    password='".$txtPassword."',
                    tipo='".$usuario['tipo']."',
                    nombre='".$txtNombre."',
                    apellido='".$txtApellido."',
                    biografia='".$txtBiografia."'
                    where idUsuario='".$_GET['idU']."'";
                    mysqli_query($conn,$qry);

                    IrAPerfil($_GET['idU']);
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
            <h1> 
            <?php
                echo " ¡Hola ".$_SESSION['usuario']."!";
            ?>    
             - Modificar mi Perfil </h1>
            <form method="post" action="modificar_perfil.php?idU=<?php echo $usuario['idUsuario'];?>" 
            onsubmit="return VerificaFRM();" enctype="multipart/form-data">
                <div class="apartados">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="txtUsuario">Usuario</label>
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" 
                            <?php echo "value='".$usuario['usuario']."'";?> >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtPassword">Contraseña</label>
                            <input type="password" class="form-control" name="txtPassword" id="txtPassword" 
                            <?php echo "value='".$usuario['password']."'";?> >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtConfPassword">Confirma Contraseña</label>
                            <input type="password" class="form-control" id="txtConfPassword" name="txtConfPassword" 
                            <?php echo "value='".$usuario['password']."'";?> >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="txtEmail">Email</label>
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" 
                            <?php echo "value='".$usuario['correo']."'";?>>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="txtNombre">Nombre(s)</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                            <?php echo "value='".$usuario['nombre']."'";?>>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="txtApellido">Apellidos</label>
                            <input type="text" class="form-control" id="txtApellido" name="txtApellido"
                            <?php echo "value='".$usuario['apellido']."'";?> >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label for="txtBiografia">Biografia</label>
                            <textarea class="form-control" id="txtBiografia" name="txtBiografia" 
                            rows="3"><?php echo $usuario['biografia'];?></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Modificar</button>
                <a href="portada.php">
                    <button type="button" class="btn btn-primary" style="margin-left:15px;">Regresar</button>
                </a>
            </form>
            
        </div>
    </body>
</html>