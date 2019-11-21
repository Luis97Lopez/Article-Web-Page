<?php
    include("funciones.php");
    session_start();
    echo $_GET['idA'];
    echo $_GET['idU'];
    if(isset($_GET['idA']) && isset($_GET['idU']) && isset($_POST['txtComentario']))
    {
        if($_GET['idA'] != "" && $_GET['idU'] != "" )
        {
            if($_SESSION['idUsuario'] == $_GET['idU'])
            {
                $date = date("Y-m-d H:i:s");
                $conn = ConectarBD();
                $qry = "insert into comentarios (comentario, fecha, idArticulo, idUsuario) 
                values ('".$_POST['txtComentario']."',
                '".$date."',
                '".$_GET['idA']."',
                '".$_GET['idU']."'
                )";
                mysqli_query($conn,$qry);
                IrAArticulo($_GET['idA']);
            }
            else
                echo "error1";
                #IrAPortada();
        }
        else
            echo "error2";
            #IrAPortada();
    }
    else
        echo "error3";
        # IrAPortada();
?>