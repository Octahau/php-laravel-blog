<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/ControladorBlog.php";
require_once "controladores/ControladorCorreo.php";
require_once "modelos/blogmodelo.php";
require "extensiones/vendor/autoload.php";



$plantilla = new ControladorPlantilla();
$plantilla -> ctrTraerPlantilla();