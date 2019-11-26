<?php
    session_start();
    include("funciones.php");

    if(!isset($_SESSION['idUsuario']) && !isset($_GET['idUr']) && !isset($_GET['idUd']))
    {
        IrAPortada();
    }
    else if($_GET['idUd'] == "")
    {
        IrAPortada();
    }
    else if($_GET['idUr'] == "")
    {
        IrAPerfil($_GET['idUd']);
    }
    else
    {
        if($_SESSION['idUsuario'] == $_GET['idUr'])
        {
            $date = date("Y-m-d H:i:s");
            $conn = ConectarBD();
            $qry = "insert into conversaciones (idUsuario1, idUsuario2, fecha) 
            values ('".$_GET['idUr']."',
            '".$_GET['idUd']."',
            '".$date."'
            )";
            mysqli_query($conn,$qry);

            $idC = mysqli_insert_id($conn);

            IrAConversacion($idC, $idUr, $idUd);
        }
    }
?>