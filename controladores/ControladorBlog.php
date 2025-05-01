<?php
class ControladorBlog
{
    static public function ctrMostrarBlog()
    {
        $tabla = "blog";
        $respuesta = BlogModelo :: mdlMostrarBlog($tabla);
        return $respuesta;
    }
    static public function ctrMostrarCategorias($item, $valor)
    {
        $tabla = "categorias";
        $respuesta = BlogModelo :: mdlMostrarCategorias($tabla, $item, $valor);
        return $respuesta;
    }

    static public function ctrMostrarConInnerJoin($desde, $cantidad,$item, $valor)
    {
        $tabla1 = "categorias";
        $tabla2 = "articulos";

        $respuesta = blogmodelo::mdlMostrarConInnerJoin($tabla1,$tabla2,$cantidad, $desde, $item, $valor);
        return $respuesta;
    }
    static public function ctrMostrarTotalArticulos($item, $valor)
    {
        $tabla = "articulos";
        $respuesta = BlogModelo::mdlMostrarTotalArticulos($tabla, $item, $valor);
        return $respuesta;
    }

    static public function ctrMostrarOpiniones($item, $valor)
    {
        $tabla1 = "opiniones";
        $tabla2 = "administradores";

        $respuesta = BlogModelo::mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor);
        return $respuesta;
    }
    static public function ctrEnviarOpinion()
    {
    if (isset($_POST["contenido_opinion"])) // Verifica que se envió el formulario correctamente
    {
        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nbre_opinion"]) &&
            filter_var($_POST["correo_opinion"], FILTER_VALIDATE_EMAIL) &&
            preg_match('/^[-\\$\\,\\.\\#\\"\\!\\¿\\?\\¡\\*\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["contenido_opinion"])
        ) {

            if(isset($_FILES["fotoOpinion"]["tmp_name"]) && !empty($_FILES["fotoOpinion"]["tmp_name"])) 
            {
                list($ancho, $alto) = getimagesize($_FILES["fotoOpinion"]["tmp_name"]);
            
                $nuevoAncho = 128;
                $nuevoAlto = 128;

                $directorio = "vistas/img/Usuarios/";
                if($_FILES["fotoOpinion"]["type"] == "image/jpeg")
                {
                    $aleatorio = mt_rand(100,9999);
                    $ruta = $directorio.$aleatorio.".jpg";

                    $origen = imagecreatefromjpeg($_FILES["fotoOpinion"]["tmp_name"]);

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagejpeg($destino, $ruta);
                }
                else if ($_FILES["fotoOpinion"]["type"] == "image/png")
                {
                    $aleatorio = mt_rand(100,9999);
                    $ruta = $directorio.$aleatorio.".png";

                    $origen = imagecreatefrompng($_FILES["fotoOpinion"]["tmp_name"]);

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagealphablending($destino, FALSE);
                    imagesavealpha($destino, TRUE);

                    imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagepng($destino, $ruta);
                }
                else return "error-formato";
            }
            else
            {
                $ruta = "vistas/img/Usuarios/usuario-default.png";
            }

            $tabla = "opiniones";
            
            
            $datos = array(
                "id_art" => $_POST["id_articulo"],
                "nbre_opinion" => $_POST["nbre_opinion"],
                "correo_opinion" => $_POST["correo_opinion"],
                "contenido_opinion" => $_POST["contenido_opinion"],
                "foto_opinion" => $ruta, // Reemplaza con la ruta correcta
                "fecha_opinion" => date("Y-m-d"),
                "id_adm" => 1 // Reemplaza con el id del administrador
            );

            $respuesta = BlogModelo::mdlEnviarOpinion($tabla, $datos);

            if ($respuesta === "ok") {
                return "La opinión se envió correctamente.";
            } else {
                return "Ocurrió un error al enviar tu opinión.";
            }
        } else {
            return "Por favor, verifica los campos ingresados.";
        }
    }
    return "No se recibió ningún dato.";
    }

    static public function ctrActualizarVistaArticulos($ruta)
    {
        $articulo = ControladorBlog::ctrMostrarConInnerJoin(0,1,"ruta_articulo",$ruta);
        $valor = $articulo[0]["vistas_articulo"] + 1;

        $tabla = "articulos";
        $respuesta = BlogModelo::mdlActualizarVistaArticulos($tabla, $valor, $ruta);
    }
    static public function ctrArticulosDestacados($item, $valor)
    {
        $tabla = "articulos";
        $respuesta = BlogModelo::mdlArticulosDestacados($tabla, $item, $valor);
        return $respuesta;
    }
    static public function ctrBuscador($desde,$cantidad,$busqueda)
    {
        $tabla1 = "categorias";
        $tabla2 = "articulos";

        $respuesta = BlogModelo::mdlBuscador($tabla1,$tabla2,$desde,$cantidad,$busqueda);
        return $respuesta;
    }
    static public function ctrTotalBuscador($busqueda)
    {
        $tabla = "articulos";
        $respuesta = BlogModelo::mdlTotalBuscador($tabla,$busqueda);
        return $respuesta;
    }
    static public function ctrTraerAnuncios($pagina)
    {
        $tabla = "anuncios";
        $respuesta = BlogModelo::mdlTraerAnuncios($tabla, $pagina);
        return $respuesta;
    }
    static public function ctrMostrarBanner($pagina)
    {
        $tabla = "banner";
        $respuesta = BlogModelo::mdlMostrarBanner($tabla, $pagina);
        return $respuesta;
    }
}