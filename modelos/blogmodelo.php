<?php
require_once "conexiondb.php";
class BlogModelo
{
    static public function mdlMostrarBlog($tabla)
    {
        $stmt = Conexion::conectar()-> prepare("select * from $tabla");
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlMostrarCategorias($tabla, $item, $valor)
    {
        if($item == null && $valor == null)
        {
            $stmt = Conexion::conectar()-> prepare("select * from $tabla");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        else
        {
            $stmt = Conexion::conectar()-> prepare("select * from $tabla where $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
        }
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlMostrarConInnerJoin($tabla1,$tabla2,$cantidad, $desde, $item, $valor)
    {
        if($item == null && $valor == null)
        {
            $stmt = Conexion:: conectar()->prepare("select $tabla1.*, $tabla2.*, 
            DATE_FORMAT(fecha_articulo, '%d.%m.%Y') as fecha_articulo from $tabla1 inner join $tabla2
            on $tabla1.id_categoria = $tabla2.id_cat order by $tabla2.id_articulo desc limit $desde, $cantidad");
            
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        else
        {
            $stmt = Conexion:: conectar()->prepare("select $tabla1.*, $tabla2.*, 
            DATE_FORMAT(fecha_articulo, '%d.%m.%Y') as fecha_articulo from $tabla1 inner join $tabla2
            on $tabla1.id_categoria = $tabla2.id_cat where $item = :$item order by $tabla2.id_articulo desc limit $desde, $cantidad");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
            $stmt -> close();
            $stmt = null;
    }
    static public function mdlMostrarTotalArticulos($tabla, $item, $valor)
    {
        if($item == null && $valor == null)
        {
            $stmt = Conexion::conectar()->prepare("select * from $tabla");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        else
        {
            $stmt = Conexion::conectar()->prepare("select * from $tabla where $item = :$item order by id_articulo desc");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt -> null;
    }

    static public function mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor)
    {
        $stmt = Conexion::conectar()->prepare("select $tabla1.*, $tabla2.* from $tabla1 inner join $tabla2 on $tabla1.id_adm = $tabla2.id_admin where $item = :$item");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlEnviarOpinion($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("insert into $tabla(id_art, nbre_opinion, correo_opinion, contenido_opinion, foto_opinion, fecha_opinion, id_adm) values(:id_art, :nbre_opinion, :correo_opinion, :contenido_opinion, :foto_opinion, :fecha_opinion, :id_adm)");
        
        $stmt -> bindParam(":id_art", $datos["id_art"], PDO::PARAM_INT);
        $stmt -> bindParam(":nbre_opinion", $datos["nbre_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":correo_opinion", $datos["correo_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":contenido_opinion", $datos["contenido_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":foto_opinion", $datos["foto_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_opinion", $datos["fecha_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_adm", $datos["id_adm"], PDO::PARAM_INT);
        
        if($stmt -> execute())
        {
            return "ok";
        }
        else
        {
            return "error";
        }
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlActualizarVistaArticulos($tabla, $valor, $ruta)
    {
        $stmt = Conexion::conectar()->prepare("update $tabla set vistas_articulo = :vistas_articulo where ruta_articulo = :ruta_articulo");
        
        $stmt -> bindParam(":vistas_articulo", $valor, PDO::PARAM_INT);
        $stmt -> bindParam(":ruta_articulo", $ruta, PDO::PARAM_STR);

        if($stmt -> execute())
        {
            return "ok";
        }
        else
        {
            return "error";
        }
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlArticulosDestacados($tabla, $item, $valor)
    {
        if($item != null && $valor != null)
        {
            $stmt = Conexion::conectar()->prepare("select * from $tabla where $item = :$item order by vistas_articulo desc limit 3");
            
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        else
        {
            $stmt = Conexion::conectar()->prepare("select * from $tabla order by id_articulo desc limit 3");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        $stmt = Conexion::conectar()->prepare("select * from $tabla where $item = :$item order by id_articulo desc limit 4");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlBuscador($tabla1,$tabla2,$desde,$cantidad,$busqueda)
    {
        $stmt = Conexion::conectar()->prepare("select $tabla1.*, $tabla2.*, DATE_FORMAT(fecha_articulo, '%d.%m.%Y') as fecha_articulo from $tabla1 inner join $tabla2 on $tabla1.id_categoria = $tabla2.id_cat where titulo_articulo like '%$busqueda%' or descripcion_articulo like '%$busqueda%' or contenido_articulo like '%$busqueda%' order by id_articulo desc limit $desde, $cantidad");
        
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlTotalBuscador($tabla, $busqueda)
    {
        $stmt = Conexion::conectar()->prepare("select * from $tabla where titulo_articulo like '%$busqueda%' or descripcion_articulo like '%$busqueda%' order by id_articulo desc");
        
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlTraerAnuncios($tabla, $pagina)
    {
        $stmt = Conexion::conectar()->prepare("select * from $tabla where pagina_anuncio = :pagina_anuncio");
        
        $stmt -> bindParam(":pagina_anuncio", $pagina, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    static public function mdlMostrarBanner($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE pagina_banner = :pagina_banner");

		$stmt -> bindParam(":pagina_banner", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

	}
}