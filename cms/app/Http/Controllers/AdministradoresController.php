<?php

namespace App\Http\Controllers;

use App\Models\Administradores;
use Illuminate\Http\Request;
use App\Models\Blog;

class AdministradoresController extends Controller
{
    /*======================================
            MOSTRAR TODOS LOS REGISTROS
    ========================================*/
    public function index()
    {
        $administradores = Administradores::all();
        $blog = Blog::all();

        return view('paginas.administradores', array("administradores" => $administradores, 'blog' => $blog));
    }
    /*======================================
            MOSTRAR UN REGISTRO
    ========================================*/
    public function show($id)
    {
        $administrador = Administradores::where("id", $id) ->get();
        $blog = Blog::all();

        if(count($administrador) != 0){
            return view(    'paginas.administradores', array("status" => 200, "administradores" => $administrador, 'blog' => $blog));
        }
        else
        {
            return view(    'paginas.administradores', array("status" => 404));
        }
    }

}
