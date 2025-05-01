<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opiniones;
use App\Models\Blog;

class OpinionesController extends Controller
{
    public function index()
    {
                $blog = Blog::all();

        return view('paginas.opiniones', array('opiniones' => Opiniones::all(), 'blog' => $blog));
    }
}
