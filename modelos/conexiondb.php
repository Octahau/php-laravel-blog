<?php

class Conexion
{
    static public function conectar()
    {
        $link = new PDO("mysql:host=localhost;dbname=blog-php",
                        "root",
                        "");
        return $link;
    }
}