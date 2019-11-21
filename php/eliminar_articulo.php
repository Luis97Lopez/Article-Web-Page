<?php
    include("funciones.php");
    session_start();
    if(!isset($_SESSION['idUsuario']) || !isset($_GET['idA']))
    {
        IrAPortada();
    }
    else
    {
        if($_GET['idA'] == "")
        {
            IrAPortada();
        }
        else{
            $articulo = GetArticulo($_GET['idA']);
            if($articulo['idUsuario'] != $_SESSION['idUsuario'])
            {
                IrAPortada();
            }
            else{
                $conn = ConectarBD();

                $comentarios = GetComentarios($_GET['idA']);
                $qry_cmts = "delete from comentarios where idArticulo=".$_GET['idA'];
                mysqli_query($conn,$qry_cmts);

                $imagen = GetImagenArt($_GET['idA']);
                $qry_img = "delete from imagenes where idImagen=" . $imagen['idImagen'];
                mysqli_query($conn,$qry_img);

                $qry = "delete from articulos where idArticulo=" . $_GET['idA'];
                mysqli_query($conn,$qry);
                IrAArticulosPerfil($_SESSION['idUsuario']);
            }
        }
    }
?>