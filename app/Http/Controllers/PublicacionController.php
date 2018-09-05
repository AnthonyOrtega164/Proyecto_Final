<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller{
    /**
     * 
     * @param Request $request
     * Controlador para registrar publicaciones indexando con correo_persona a cada persona
     * @return response json
     */
    public function registrar(Request $request) {
        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $user = Persona::where("correo_persona", $data["correo_persona"])->first();
                if ($user) {
                    $publicacion = new Publicacion();
                    $publicacion->external_id = utilidades\UUID::v4();
                    $publicacion->titulo = $data["titulo"];
                    $publicacion->descripcion = $data["descripcion"];
                    $publicacion->categoria = $data['categoria'];
                    $publicacion->ruta_imagen = $data['ruta_imagen'];
                    $publicacion->telefono_persona = $data['telefono_persona'];
                    $publicacion->correo_persona = $data['correo_persona'];
                    $publicacion->save();

                    return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
                } else {
                    return response()->json(["mensaje" => "No se ha encontrado ningun dato", "siglas" => "NDE"], 203);
                }
            } catch (Exception $ex) {
                return response()->json(["mensaje" => "Faltan Datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
        }
    }
    
    /**
     * Controlador para listar todas la publicaciones que tengan estado true
     * @return response json
     */
    public function listar() {
        $lista = Publicacion::where('estado', "true")->orderBy('created_at', 'desc')->get();
        $data = array();
        foreach ($lista as $value) {
            $data[] = ["Titulo" => $value->titulo, "Descripcion" => $value->descripcion, "Foto" => $value->ruta_imagen, "Categoria" => $value->categoria, "Fecha" => $value->created_at->format("Y-m-d")];
        }
        return response()->json($data, 200);
    }

    /**
     * 
     * @param type $correo_persona
     * Controlador para listar por persona indexando como parametro el correo_persona
     * @return response json
     */
    public function listarUser($correo_persona) {
        $this->correo_persona = $correo_persona;
        $lista = Publicacion::whereHas('persona', function ($ad) {
                    $ad->where('correo_persona', $this->correo_persona)->where("estado", "true");
                })->orderBy('created_at', "desc")->get();
        $data = array();
        foreach ($lista as $value) {
            $data[] = ["Titulo" => $value->titulo, "Descripcion" => $value->descripcion, "Foto" => $value->ruta_imagen, "Categoria" => $value->categoria, "Fecha" => $value->created_at->format("Y-m-d")];
        }
        return response()->json($data, 200);
    }
    /**
     * 
     * @param Request $request
     * Controlador para modificar publicacion utilizando como principal parametro el external_id
     * @return response json
     */
    public function modificar(Request $request) {
        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $publicacion = Publicacion::where("external_id", $data['external_id'])->first();
                if (isset($data["titulo"])) {
                    $publicacion->titulo = $data["titulo"];
                }if (isset($data["categoria"])) {
                    $publicacion->categoria = $data["categoria"];
                }if (isset($data["descripcion"])) {
                    $publicacion->descripcion = $data["descripcion"];
                }if (isset($data["foto"])) {
                    $publicacion->ruta_imagen = $data["foto"];
                }
                $publicacion->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } catch (Exception $ex) {
                return response()->json(["mensaje" => "Faltan Datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
        }
    }
    /**
     * 
     * @param Request $request
     * Controlador para eliminar publicacion, eliminado logico por estado
     * @return response json
     */
    public function eliminar(Request $request) {
        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $publicacion = Publicacion::where("external_id", $data['external_id'])->first();
                $publicacion->estado ="false";
                $publicacion->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } catch (Exception $ex) {
                return response()->json(["mensaje" => "Faltan Datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
        }
    }

}
