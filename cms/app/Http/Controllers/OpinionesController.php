<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opiniones;
use App\Models\Blog;
use App\Models\Administradores;
class OpinionesController extends Controller
{
    public function index()
    {
                $blog = Blog::all();
        $opiniones = Opiniones::all();
        $administradores = Administradores::all();
        return view('paginas.opiniones', array('opiniones' => Opiniones::all(), 'blog' => $blog, 'administradores' => $administradores));
    }
}
