<?php
    session_start();
    include("../php/funciones.php");
    if(isset($_POST['txtUsuario']) && isset($_POST['txtPassword']))
    {
        extract($_POST);
        if($_POST['txtUsuario']!= "" && $_POST['txtPassword'] != "")
        {
            $conn = ConectarBD();
            $qry = "select idUsuario, usuario, tipo, nombre from usuarios where 
				usuario='$txtUsuario' and password='$txtPassword'";
            $res = mysqli_query($conn,$qry);
            if(mysqli_num_rows($res)>0) //si encontro conicindencia
            {
                $usr = mysqli_fetch_array($res);
                $_SESSION['idUsuario'] = $usr["idUsuario"];
                $_SESSION['usuario'] = $usr["usuario"];
                $_SESSION['tipo'] = $usr["tipo"];
                $_SESSION['nombre'] = $usr["nombre"];
                header("Location:http://localhost/Proyecto/html/portada.php");
            }
            else  //el usuario y el password no existen
            {
                ?>
                <script type="text/javascript">
                    alert("El usuario y la contraseña no coinciden");
                </script>
                <?php
            }
        }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/styles_portadass.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script type="text/javascript">
            function VerificaFRM()
            {
                if(document.getElementById("txtPassword").value=="" || 
                document.getElementById("txtUsuario").value == "")
                {
                    alert("Datos inválidos. Completa formulario.");
                    return false;
                }
                return true;
            }
        </script>
   </head>
    <body  class="cuerpo">
        <div class="cabecera bg-light">
            <a href="portada.php"> <img src="../media/logo.png" class="logo">  </a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="layout">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="portada.php"> Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Clasificaciones
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                $resultado = GetClasificaciones();
                                while($registro = mysqli_fetch_array($resultado))
                                {
                                    echo "<a class='dropdown-item' href='articulos_por_clasificacion.php?idC=". 
                                    $registro['idClasificacion'] . "'>".$registro['nombre']." </a>";
                                }
                                ?>
                            </div>
                        </li>
                    </ul>
                    <div style="width:70%">
                    </div>
                    <?php
                        if(!isset($_SESSION['idUsuario']))
                        {
                    ?>
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Inicia Sesión </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4 py-3" action="portada.php" method="post" onsubmit="return VerificaFRM()">
                                            <div class="form-group">
                                            <label for="txtUsuario">Usuario</label>
                                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" 
                                            placeholder="Usuario">
                                            </div>
                                            <div class="form-group">
                                            <label for="txtPassword">Contraseña</label>
                                            <input type="password" class="form-control" id="txtPassword" name="txtPassword"
                                            placeholder="Contraseña">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Inicia Sesión</button>
                                        </form>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="registro.php">¿Eres nuevo? Regístrate</a>
                                        <!--
                                        <a class="dropdown-item" href="#">¿Contraseña Olvidada?</a>
                                        --->
                                    </div>
                                </li>
                                <li class="nav-item" style="margin-left:10px">
                                    <a class="nav-link" href="registro.php"> Regístrate </a>
                                </li>
                                <li class="nav-item" style="margin-left:10px; margin-top:4px">
                                    <a class="nav-link" href="perfil.php"> <i class="fas fa-user-alt"> </i> </a>
                                </li>
                            </ul>
                    <?php
                        }
                        else{
                    ?>
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        
                                        <?php 
                                            echo "Bienvenido " . $_SESSION['usuario'] . " <i class='fas fa-user-alt'> </i>";
                                        ?>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <?php
                                        echo "<a class='dropdown-item' href='perfil.php?idU=". $_SESSION['idUsuario'] .
                                        "'> Ver Perfil </a>";
                                        echo "<a class='dropdown-item' href='../php/logout.php'>Cerrar Sesión </a>";
                                        echo "<div class='dropdown-divider'></div>";
                                        echo "<a class='dropdown-item' href='agregar_articulo.php'>Agregar Artículo</a>";
                                        echo "<a class='dropdown-item' href='articulos_por_autor.php?idU=".
                                        $_SESSION['idUsuario']."'>Mis Artículos</a>";
                                        echo "<a class='dropdown-item' href='conversaciones.php?idU=".
                                        $_SESSION['idUsuario']."'>Mis Conversaciones </a>";
                                        if($_SESSION['tipo'] == 0)
                                        {
                                            echo "<div class='dropdown-divider'></div>";
                                            echo "<a class='dropdown-item' href='usuarios.php'>
                                            Ver Usuarios</a>";
                                            echo "<a class='dropdown-item' href='articulos_sin_aceptar.php'>
                                            Ver Artículos Pendientes</a>";
                                            echo "<a class='dropdown-item' href='clasificaciones.php'>
                                            Ver Clasificaciones</a>";

                                        }
                                        ?>
                                    </div>
                                </li>
                            </ul>
                    <?php
                        }
                    ?>
                    </div>
                </div>
        </nav>

        <div class="portada_cuadros1">
            <div class="titulo"> 
                <h1> Artículos Nuevos </h1>
            </div>
            <div class="layout">
                <div class="conjunto_cuadros1">
        <?php
            $articulos = GetArticulos();
            $i=0;
            while($i<4)
            {
                
                if(!empty($articulos) && $articulo = mysqli_fetch_array($articulos))
                {
                    $imagen = GetImagenArt($articulo['idArticulo']);
                    $clasificacion = GetClasificacion($articulo['idClasificacion']);
                    echo "<a href='articulo.php?idA=".$articulo['idArticulo']."' class='cuadros1";
                    if($i == 0 || $i == 3)
                        echo " cuadros1_grande";
                    else
                        echo " cuadros1_chico";
                    echo    "'> <img src='../php/imagen.php?idI=".$imagen['idImagen']."'>
                            <div class='cuadros1_parrafo'>
                                <span class='cuadros1_genero'> ".$clasificacion['nombre']." </span> <br>
                                <h1 class='cuadros1_titulo'> ".$articulo['titulo']." </h1>
                                <span class='cuadros1_fecha'> ".$articulo['fecha']." </span>
                            </div>
                        </a>
                        ";
                }
                else
                {
                    echo "
                        <a class='cuadros1";
                    if($i == 0 || $i == 3)
                        echo " cuadros1_grande";
                    else
                        echo " cuadros1_chico";
                        echo    "'> <img src='../media/logo.png'> </a>
                        "; 
                }
                    $i++;
            }
        ?>
                </div>
            </div>
        </div>

        <div class="portada_cuadros2">
            <div class="container my-4">
                <hr class="my-4">
                <div class="titulo"> 
                    <h1> Más Artículos </h1>
                </div>
                <div class="layout">
                    <!--Carousel Wrapper-->
                    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
                                               
                            <div class='carousel-inner' role='listbox'>                                
                            <?php
                                $z=0;
                                while($z<3)
                                {
                                    if($z==0)
                                        $cadena2 = "active";
                                    else
                                        $cadena2 = " ";
                                    
                                    echo "
                                    <div class='carousel-item " .$cadena2."'>
                                        <div class='row'>
                                    ";
                                    $i=0;
                                    while($i<3)
                                    {
                                        if($i==2) 
                                            $cadena = "clearfix d-none d-md-block";
                                        else
                                            $cadena = "";
                                        if(!empty($articulos) && $articulo = mysqli_fetch_array($articulos))
                                        {
                                            $imagen = GetImagenArt($articulo['idArticulo']);
                                            $clasificacion = GetClasificacion($articulo['idClasificacion']);
                                            echo " <div class='col-md-4 ". $cadena . "'> 
                                                    <a href=articulo.php?idA=".$articulo['idArticulo']." class='cuadros2'>
                                                        <img src='../php/imagen.php?idI=".$imagen['idImagen']."'>
                                                        <div class='cuadros2_parrafo'>
                                                            <span class='cuadros1_genero'> ".$clasificacion['nombre']."</span> <br>
                                                            <h1 class='cuadros1_titulo'> ".$articulo['titulo']." </h1>
                                                            <span class='cuadros1_fecha'> ".$articulo['fecha']." </span>
                                                        </div>
                                                    </a>
                                                </div>
                                            ";
                                        }
                                        else{
                                            echo "
                                                <div class='col-md-4 ".$cadena. "'>
                                                    <a class='cuadros2'>
                                                        <img src='../media/logo.png'>
                                                        <div class='cuadros2_parrafo'>
                                                        </div>
                                                    </a>
                                                </div>
                                            ";
                                        }   
                                        $i++;
                                    }
                                    echo "
                                        </div>
                                    </div>
                                    ";
                                    $z++;
                                }  
                            ?>
                        </div>

                        <!--Controls--> 
                        <div class="controls-top" style="text-align: center; margin-top:20px; color:black">
                            <a class="btn-floating" href="#multi-item-example" data-slide="prev">
                                <i class="fa fa-chevron-left" style="color:grey"></i></a>
                            <a class="btn-floating" href="#multi-item-example" data-slide="next">
                                <i class="fa fa-chevron-right" style="color:grey; margin-left:15px;"></i></a>
                        </div> <br>
                    </div>
                    <!--/.Controls-->
                </div>
                <!--/.Layout-->
            </div>
            <!--/.Carousel Wrapper-->
        </div>
        
                           
        
        <a href="articulos_por_fecha.php" style="text-decoration: none;"> <h1 class="ver"> Ver todos los artículos </h1> </a>

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