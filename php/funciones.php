<?php
    function ConectarBD()
    {
        $c = mysqli_connect("localhost","root","","proyecto");
        return $c;
    }

    function IrAPortada()
    {
        header("Location:http://localhost/Proyecto/html/portada.php");
    }

    function IrAUsuarios()
    {
        header("Location:http://localhost/Proyecto/html/usuarios.php");
    }

    function IrAClasificaciones()
    {
        header("Location:http://localhost/Proyecto/html/clasificaciones.php");
    }

    function IrASinAceptar()
    {
        header("Location:http://localhost/Proyecto/html/articulos_sin_aceptar.php");
    }

    function IrAArticulo($articulo)
    {
        header("Location:http://localhost/Proyecto/html/articulo.php?idA=".$articulo."");
    }

    function IrAPerfil($perfil)
    {
        header("Location:http://localhost/Proyecto/html/perfil.php?idU=".$perfil."");
    }

    function IrAConversacion($chat, $idUr, $idUd)
    {
        header("Location:http://localhost/Proyecto/html/chat.php?idC=".$chat."&idUr=".$idUr."&idUd=".$idUd."");
    }

    function IrAArticulosPerfil($perfil)
    {
        header("Location:http://localhost/Proyecto/html/articulos_por_autor.php?idU=".$perfil."");
    }

    function GetUsuario($pk)
    {
        $conn = ConectarBD();
        $consulta = "select idUsuario, usuario, tipo, nombre, apellido, biografia, correo, password
        from usuarios where $pk=idUsuario";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return mysqli_fetch_array($resultado);
        }
        else
            return array();
    }

    function GetComentario($pk)
    {
        $conn = ConectarBD();
        $consulta = "select idComentario, comentario, fecha, idUsuario, idArticulo from comentarios
        where $pk=idComentario";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return mysqli_fetch_array($resultado);
        }
        else
            return array();
    }

    function GetImagenArt($pk)
    {
        $conn = ConectarBD();
        $consulta = "select idImagen, imagen, tipo, nombre, idArticulo from imagenes where $pk=idArticulo";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return mysqli_fetch_array($resultado);
        }
        else
            return array();
    }

    function GetImagen($pk)
    {
        $conn = ConectarBD();
        $consulta = "select idImagen, imagen, tipo, nombre, idUsuario from imagenes_pp where $pk=idUsuario";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return mysqli_fetch_array($resultado);
        }
        else
            return array();
    }

    function GetClasificaciones()
    {
        $conn = ConectarBD();
        $consulta = "select idClasificacion, nombre from clasificaciones";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return $resultado;
        }
        else
            return array();
    }

    function GetComentarios($pk_a)
    {
        $conn = ConectarBD();
        $consulta = "select idComentario, comentario, fecha, idUsuario, idArticulo from comentarios
                    where idArticulo=$pk_a order by fecha desc";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return $resultado;
        }
        else
            return array();
    }

    function GetConversaciones($pk_u)
    {
        $conn = ConectarBD();
        $consulta = "select idConversacion, idUsuario1, idUsuario2, fecha from conversaciones
                    where idUsuario1=$pk_u or idUsuario2=$pk_u order by fecha desc";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return $resultado;
        }
        else
            return array();
    }

    function GetClasificacion($pk)
    {
        $conn = ConectarBD();
        $consulta = "select idClasificacion, nombre
        from clasificaciones where $pk=idClasificacion";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return mysqli_fetch_array($resultado);
        }
        else
            return array();
    }

    function GetArticulo($pk)
    {
        $conn = ConectarBD();
        $consulta = "select idArticulo, titulo, fecha, aprobado, texto, idClasificacion, idUsuario
        from articulos where $pk=idArticulo";
        $resultado = mysqli_query($conn, $consulta);
        if(mysqli_num_rows($resultado)>0)
        {
            return mysqli_fetch_array($resultado);
        }
        else
            return array();
    }

    function GetArticulos()
    {
        $conn = ConectarBD();
        $consulta = "select * from articulos where aprobado=1 order by fecha desc";
        return mysqli_query($conn, $consulta);
        $consulta = "select * from mensajes where idConversacion=".$pk." order by fecha asc";
        return mysqli_query($conn, $consulta);
    }
?>