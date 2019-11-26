<?php
    include("funciones.php");
    session_start();
    if(isset($_GET['idC']) && isset($_GET['idUd']) && isset($_GET['idUr']) && isset($_POST['txtMensaje']))
    {
        if($_GET['idC'] != "" && $_GET['idUd'] != "" && $_GET['idUr'] != "")
        {
            if($_SESSION['idUsuario'] == $_GET['idUr'])
            {
                $date = date("Y-m-d H:i:s");
                $conn = ConectarBD();
                echo $qry = "insert into mensajes (mensaje, fecha, idConversacion, idUsuarioDestinatario) 
                values ('".$_POST['txtMensaje']."',
                '".$date."',
                '".$_GET['idC']."',
                '".$_GET['idUd']."'
                )";
                mysqli_query($conn,$qry);
                IrAConversacion($_GET['idC'],$_GET['idUr'], $_GET['idUd']);
            }
            else
                IrAPortada();
        }
        else
            IrAPortada();
    }
    else
        IrAPortada();
?>