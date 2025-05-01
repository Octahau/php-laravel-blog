<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Blog;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categorias::all();
        $blog = Blog::all();

        return view('paginas.categorias', array('categorias' => $categorias, 'blog' => $blog));
    }
}
