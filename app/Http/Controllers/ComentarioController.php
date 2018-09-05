<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller{
    /**
     * 
     * @param Request $request 
     * Controlador para registrar comentarios indexados por id_publicacion a cada publicacion
     * @return response json
     */
    public function registrar(Request $request) {
        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $publi = Publicacion::where("id_publicacion", $data["id_publicacion"])->first();
                if ($publi) {
                    $comentario = new Comentario();
                    $comentario->external_id = utilidades\UUID::v4();
                    $comentario->comentario = $data["comentario"];
                    $comentario->nombre_persona = $data['nombre_usuario'];
                    $comentario->id_publicacion = $data['id_publicacion'];
                    $comentario->save();
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
     * 
     * @param Request $request
     * Controlador para listar comentario utiliza como parametros de la consulta id_publicacion para que solo se listen los que estan indexados
     * @return response json
     */
    public function listar(Request $request) {
        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $publi = Publicacion::where("id_publicacion", $data["id_publicacion"])->first();
                $this->id = $data['id_publicacion'];
                if ($publi) {
                    $lista = Comentario::whereHas('publicacion', function ($ad) {
                                $ad->where('id_publicacion', $this->id);
                            })->where("estado", "true")->orderBy('created_at', 'desc')->get();
                    $data = array();
                    foreach ($lista as $value) {
                        $data[] = ["Comentario" => $value->comentario, "Nombre de Usuario" => $value->nombre_persona, "Fecha" => $value->created_at];
                    }
                    return response()->json($data, 200);
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
     * 
     * @param Request $request
     * Controlador para eliminar comentario, solo eliminado logico con estado true o falso
     * @return response json
     */
    public function eliminar(Request $request) {
        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $comentario = Comentario::where("external_id", $data['external_id'])->first();
                $comentario->estado = "false";
                $comentario->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } catch (Exception $ex) {
                return response()->json(["mensaje" => "Faltan Datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
        }
    }

}
