<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Administradores;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Importar para logs

class BlogController extends Controller
{
    /*=======================
    Mostrar registros
    =======================*/
    public function index()
    {
        $blog = Blog::all();
        $administradores = Administradores::all();
        return view('paginas.blog', array('blog' => $blog, 'administradores' => $administradores));
    }

    public function update($id, Request $request)
    {
        $datos = $request->only([
            'dominio', 'servidor', 'titulo', 'descripcion', 'palabras_claves', 'redes_sociales','sobre_mi','sobre_mi_completo'
        ]);

        // Obtener imágenes del request o mantener las actuales
        $datos['logo'] = $request->hasFile('logo') ? $request->file('logo') : $request->input('logo_actual');
        $datos['portada'] = $request->hasFile('portada') ? $request->file('portada') : $request->input('portada_actual');
        $datos['icono'] = $request->hasFile('icono') ? $request->file('icono') : $request->input('icono_actual');

        // Validaciones
        $validar = Validator::make($request->all(), [
            'dominio' => 'required|string|max:255',
            'servidor' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'palabras_claves' => 'required|string|max:255',
            'redes_sociales' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'portada' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'icono' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'sobre_mi' => 'required|string',
            'sobre_mi_completo' => 'required|string',
        ]);

        if ($validar->fails()) {
            return redirect("/")->withErrors($validar)->withInput();
        }

        // Procesar y mover imágenes
        foreach (['logo', 'portada', 'icono'] as $img) {
            if ($request->hasFile($img)) {
                $archivo = $request->file($img);
                $aleatorio = rand(100, 999);
                $rutaImagen = "img/blog/" . $img . $aleatorio . "." . $archivo->guessExtension();
        
                // Eliminar imagen anterior si existe
                if (!empty($datos[$img]) && file_exists(public_path($datos[$img]))) {
                    unlink(public_path($datos[$img]));
                }
        
                // Obtener dimensiones originales
                list($ancho, $alto) = getimagesize($archivo);
        
                // Definir tamaños específicos para cada imagen
                $dimensiones = [
                    'logo' => [700, 200],   // Logo cuadrado
                    'portada' => [700, 420], // Portada más ancha
                    'icono' => [144, 144]   // Icono pequeño
                ];
        
                $nuevoAncho = $dimensiones[$img][0];
                $nuevoAlto = $dimensiones[$img][1];
        
                // Crear nueva imagen
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        
                // Verificar tipo de imagen y crear imagen de origen
                $extension = strtolower($archivo->guessExtension());
                switch ($extension) {
                    case "png":
                        $origen = imagecreatefrompng($archivo);
                        imagealphablending($destino, false);
                        imagesavealpha($destino, true);
                        break;
                    case "jpeg":
                    case "jpg":
                        $origen = imagecreatefromjpeg($archivo);
                        break;
                    default:
                        continue 2; // Si el formato no es soportado, salta la iteración
                }
        
                // Redimensionar la imagen
                imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        
                // Guardar la imagen en el servidor
                $rutaCompleta = public_path($rutaImagen);
                if ($extension === "png") {
                    imagepng($destino, $rutaCompleta);
                } else {
                    imagejpeg($destino, $rutaCompleta, 90);
                }
        
                // Liberar memoria
                imagedestroy($origen);
                imagedestroy($destino);
        
                // Actualizar la ruta en los datos
                $datos[$img] = $rutaImagen;
            }
        }
        

        // Convertir palabras clave a JSON
        if (!empty($datos["palabras_claves"])) {
            $datos["palabras_claves"] = json_encode(array_map('trim', explode(",", $datos["palabras_claves"])));
        }

        // Validar JSON en redes sociales
        if (!empty($datos["redes_sociales"])) {
            json_decode($datos["redes_sociales"]);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect("/")->with('error-editar', 'Error: Formato JSON inválido en redes sociales');
            }
        }
        // Mover todos los ficheros temporales de blog al destino final
        $origen = glob(public_path('img/temp/blog/*')); // Asegura que la ruta sea absoluta
        foreach ($origen as $fichero) {
            $nombreFichero = basename($fichero); 
            $rutaDestino = public_path("img/blog/".$nombreFichero); // Ruta correcta en 'public/img/blog/'

                if (copy($fichero, $rutaDestino)) {
                    unlink($fichero); // Borra el archivo temporal si la copia fue exitosa
                }
        }
        $blog = Blog::find($id); 

        // Verificar si el blog existe antes de acceder a sus valores
        if (!$blog) {
            return redirect("/")->with('error-editar', 'Error: No se encontró el registro');
        }
        
        // Definir URL base del servidor
        $urlTemp = $blog->servidor . 'img/temp/blog';
        $urlFinal = $blog->servidor . 'img/blog';
        
        // Reemplazar rutas en los campos de texto
        $datos['sobre_mi'] = str_replace('src="' . $urlTemp, 'src="' . $urlFinal, $datos['sobre_mi']);
        $datos['sobre_mi_completo'] = str_replace('src="' . $urlTemp, 'src="' . $urlFinal, $datos['sobre_mi_completo']);
        
        // Actualizar base de datos
        $actualizado = Blog::where('id', $id)->update($datos);

        return $actualizado ? redirect("/")->with('ok-editar', 'Registro actualizado correctamente')
                            : redirect("/")->with('error-editar', 'No se pudo actualizar el registro');
    }
}
