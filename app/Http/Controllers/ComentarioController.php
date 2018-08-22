<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Publicacion;
use App\Models\Comentario;
use Illuminate\Http\Request;

/**
 * Description of ComentarioController
 *
 * @author antho
 */
class ComentarioController {
    
    public function registrar(Request $request) {

        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $publi = Publicacion::where("id_publicacion", $data["id_publiacion"])->first();
                if ($publi) {
                    $publicacion = Publicacion::find($publi->id);

                    $comentario = new Comentario();
                    $comentario->external_id=utilidades\UUID::v4();
                    $comentario->comentario = $data["comentario"];
                    $comentario->nombre_usuario = $data['nombre_usuario'];
                    $comentario->id_publicacion=$data['id_publicacion'];
                    $comentario->estado=true;
                    $comentario->publi()->associate($publicacion);
                    $comentario->save();

                    return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
                } else {
                    return response()->json(["mensaje" => "No se ha encontrado ningun dato", "siglas" => "NDE"], 203);
                }
            } catch (\Exception $ex) {
                return response()->json(["mensaje" => "Faltan Datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
        }
    }

    public function listar($id_publicacion) {
        $this->id = $id_publicacion;
        $lista = Publicacion::whereHas('publi', function ($ad) {
                    $ad->where('id_publicacion', $this->id);
                })->orderBy('created_at', 'desc')->get();
        $data = array();
        foreach ($lista as $value) {
            $data[] = ["Comentario"=>$value->comentario,"Nombre de Usuario"=>$value->nombre_usuario];
        }
        return response()->json($data, 200);
    }
    
    public function modificar(Request $request, $external_id) {
        $comenta = Comentario::where("external_id", $external_id)->first();
        if ($comenta) {
            if ($request->isJson()) {
                $data = $request->json()->all();
                $comentario = Comentario::find($comenta->id);
                $comentario->comentario = $data["comentario"];
                $comentario->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } else {
                return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
            }
        } else {
            return response()->json(["mensaje" => "No se ha encontrado ningun dato", "siglas" => "NDE"], 203);
        }
    }
    
    public function eliminar(Request $request, $external_id) {
        $comenta = Comentario::where("external_id", $external_id)->first();
        if ($comenta) {
            if ($request->isJson()) {
                $data = $request->json()->all();
                $comentario = Comentario::find($comenta->id);
                $comentario->estado=false;
                $comentario->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } else {
                return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
            }
        } else {
            return response()->json(["mensaje" => "No se ha encontrado ningun dato", "siglas" => "NDE"], 203);
        }
    }
}
