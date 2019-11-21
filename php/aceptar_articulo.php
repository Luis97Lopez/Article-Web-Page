<?php
    include("funciones.php");
    if(isset($_GET['idA']) && $_GET['idA'] != "")
    {
        $conn = ConectarBD();
        $qry = "update articulos set aprobado=1 where idArticulo='".$_GET['idA']."'";
        mysqli_query($conn,$qry);
        IrASinAceptar();
    }
    else
    {
        IrAPortada();
    }
?>