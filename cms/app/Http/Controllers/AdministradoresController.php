<?php

namespace App\Http\Controllers;

use App\Models\Administradores;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
    /*======================================
            EDITAR UN REGISTRO
    ========================================*/
    public function update($id,Request $request)
    {
        //Recoger los datos
        $datos = array(
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password_actual" => $request->input("password_actual"),
            "rol" => $request->input("rol"),
            "foto_actual" => $request->input("foto_actual"));

        $password = array("password" => $request->input("password"));
        $foto = array("foto" => $request->file("foto"));

        if(!empty($datos))
        {
            $validarDatos = Validator::make($datos, [
                "name" => "required", 
                "email" => "required|email",
                "rol" => "required",
            ]);
            if(!empty($password["password"]))
            {
                $validarPassword = Validator::make($password, [
                    "password" => "min:4"
                ]);
                if($validarPassword->fails())
                {
                    return redirect("/administradores")->with("no-validacion", "");
                } else {
                    $nuevaPassword = Hash::make($password['password']);
                }
            } else {
                $nuevaPassword = $datos["password_actual"];
            }
            if($foto["foto"] != null)
            {
                $validarFoto = Validator::make($foto, [
                    "foto" => "required|image|mimes:jpeg,png,jpg,gif|max:2048"
                ]);
                if($validarFoto->fails())
                {
                    return redirect("/administradores")->with("no-validacion", "");
                }           
            }
            if($validarDatos->fails())
            {
                return redirect("/administradores")->with("no-validacion", "");
            }else
            {
                if($foto["foto"] != null && $datos["foto_actual"] != "img/administradores/homero.png")
                {
                    if (!empty($datos["foto_actual"]) && file_exists($datos["foto_actual"]) && is_file($datos["foto_actual"])) {
                        unlink($datos["foto_actual"]);
                    }
                    
                    $aleatorio = mt_rand(0, 9999);
                    $ruta = "img/" . $aleatorio . "." . $foto["foto"]->guessExtension();
                    move_uploaded_file($foto["foto"], $ruta);

                }
                else
                {
                    $ruta = $datos["foto_actual"];
                }
                $datos = array(
                    "name" => $datos["name"],
                    "email" => $datos["email"],
                    "password" => $nuevaPassword,
                    "rol" => $datos["rol"],
                    "foto" => $ruta
                );
                $administrador = Administradores::where("id", $id)->update($datos);
                return redirect("/administradores")->with("ok-editar", "");
            }
        }
        else
        {
            return redirect("/administradores")->with("error", "");
        }
    }
    /*======================================
            ELIMINAR UN REGISTROS
    ========================================*/
    public function destroy($id, Request $request)
    {
        $validar = Administradores::where("id", $id)->get();
        

        if(!empty($validar) && $id != 1)
        {
            if (!empty($validar[0]["foto"]) && file_exists($validar[0]["foto"]) && is_file($validar[0]["foto"])) {
                unlink($validar[0]["foto"]);
            }
            $administradores = Administradores::where("id", $id)->delete();
            return "ok";
        }
        else
        {
            return "no-eliminar";
        }
    }
}
