<?php
    include("funciones.php");
    session_start();
    if(isset($_SESSION['idUsuario']) || !isset($_GET['idC']))
    {
        $comentario = GetComentario($_GET['idC']);
        $conn = ConectarBD();
	    $qry = "delete from comentarios where idComentario=" . $_GET['idC'];
	    $rs = mysqli_query($conn,$qry);
        IrAArticulo($comentario['idArticulo']);
    }
?>