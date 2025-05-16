<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Administradores;
class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::all();
        $blog = Blog::all();
        $administradores = Administradores::all();

        return view('paginas.banner', array('banner' => $banner, 'blog' => $blog, 'administradores' => $administradores));
    }
}
