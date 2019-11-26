<?php
    include("funciones.php");
    if(isset($_GET['idU']) && $_GET['idU'] != "")
    {
        $conn = ConectarBD();
        $qry = "update usuarios set tipo=1 where idUsuario='".$_GET['idU']."'";
        mysqli_query($conn,$qry);
        IrAUsuarios();
    }
    else
    {
        IrAPortada();
    }
?>