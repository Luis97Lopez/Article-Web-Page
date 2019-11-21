<?php
    include("funciones.php");
    session_start();
    if(!isset($_SESSION['idUsuario']) || $_SESSION['tipo'] != 0 || !isset($_GET['idC']))
    {
        IrAPortada();
    }
    else
    {
        $conn = ConectarBD();
	    $qry = "delete from clasificaciones where idClasificacion=" . $_GET['idC'];
	    mysqli_query($conn,$qry);
        IrAClasificaciones();
    }
?>