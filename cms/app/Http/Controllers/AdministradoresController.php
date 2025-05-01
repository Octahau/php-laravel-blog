<?php

namespace App\Http\Controllers;

use App\Models\Administradores;
use Illuminate\Http\Request;
use App\Models\Blog;

class AdministradoresController extends Controller
{
    public function index()
    {
        $administradores = Administradores::all();
        $blog = Blog::all();

        return view('paginas.administradores', array("administradores" => $administradores, 'blog' => $blog));
    }
}
