<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Blog;
use App\Models\Administradores;
class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categorias::all();
        $blog = Blog::all();
        $administradores = Administradores::all();

        return view('paginas.categorias', array('categorias' => $categorias, 'blog' => $blog, 'administradores' => $administradores));
    }
}
