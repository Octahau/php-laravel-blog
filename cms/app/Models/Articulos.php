<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    protected $table = 'articulos';
    
    //Aca hacemos un inner join con la tabla categorias para traer las categorias relacionadas
    public function categorias()
    {
        return $this->belongsTo('App\Models\Categorias', 'id_cat', 'id_categoria');
    }
}
