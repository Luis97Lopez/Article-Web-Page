<?php
    include ("funciones.php");
    //verificar que existe el idI
    if(isset($_GET['idI']) && $_GET['idI']!="")
    {
        $conn = ConectarBD();
        $qry = "select tipo, imagen, nombre from imagenes where idImagen=" .  $_GET['idI'];
        $rs = mysqli_query($conn,$qry);
        $imagen = mysqli_fetch_array($rs);
        //cambiar el tipo de contenido del archivo
        header("Content-Type:" . $imagen['tipo']);
        echo $imagen["imagen"];
    }
?>