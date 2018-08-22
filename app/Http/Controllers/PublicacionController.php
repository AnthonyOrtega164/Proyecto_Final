<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Publicacion;
use Illuminate\Http\Request;

/**
 * Description of PublicacionController
 *
 * @author antho
 */
class PublicacionController {

    public function registrar(Request $request) {

        if ($request->isJson()) {
            $data = $request->json()->all();
            try {
                $user = Persona::where("id_persona", $data["id"])->first();
                if ($user) {
                    $persona = Persona::find($user->id);

                    $publicacion = new Publicacion();
                    $publicacion->external_id=utilidades\UUID::v4();
                    $publicacion->titulo = $data["titulo"];
                    $publicacion->descripcion = $data["descripcion"];
                    $publicacion->categoria = $data['categoria'];
                    $publicacion->cordx = $data['cordx'];
                    $publicacion->cordy = $data['cordy'];
                    $publicacion->ruta_imagen = $data['ruta_imagen'];
                    $publicacion->id_persona=$data['id'];
                    $publicacion->estado=true;
                    $publicacion->user()->associate($persona);
                    $publicacion->save();

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

    public function listar() {

        $lista = Publicacion::where('estado', true)->orderBy('created_at', 'desc')->get();
        $data = array();
        foreach ($lista as $value) {
            $data[] = ["Titulo" => $value->titulo, "Descripcion" => $value->descripcion, "Foto" => $value->ruta_imagen, "Cordenada en X" => $value->cordx, "Cordenada en Y" => $value->cordy,
                "Categoria" => $value->categoria, "Fecha" => $value->created_at->format("Y-m-d"), "Estado" => $value->estado];
        }
        return response()->json($data, 200);
    }

    public function listarUser($id_persona) {
        $this->id = $id_persona;
        $lista = Publicacion::whereHas('user', function ($ad) {
                    $ad->where('id_persona', $this->id);
                })->orderBy('created_at', 'desc')->get();
        $data = array();
        foreach ($lista as $value) {
            $data[] = ["Titulo" => $value->titulo, "Descripcion" => $value->descripcion, "Foto" => $value->ruta_imagen, "Cordenada en X" => $value->cordx, "Cordenada en Y" => $value->cordy,
                "Categoria" => $value->categoria, "Fecha" => $value->created_at->format("Y-m-d"), "Estado" => $value->estado];
        }
        return response()->json($data, 200);
    }
    
    public function modificar(Request $request, $external_id) {
        $publi = Publicacion::where("external_id", $external_id)->first();
        if ($publi) {
            if ($request->isJson()) {
                $data = $request->json()->all();
                $publicacion = Publicacion::find($publi->id);
                if (isset($data["titulo"])) {
                    $publicacion->titulo = $data["titulo"];
                }if (isset($data["categoria"])) {
                    $publicacion->categoria = $data["categoria"];
                }if (isset($data["descripcion"])) {
                    $publicacion->descripcion = $data["descripcion"];
                }if (isset($data["foto"])) {
                    $publicacion->ruta_imagen= $data["foto"];
                }if (isset($data["cordx"])) {
                    $publicacion->cordx = $data["cordx"];
                }if (isset($data["cordy"])) {
                    $publicacion->cordy = $data["cordy"];
                }
                
                $publicacion->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } else {
                return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
            }
        } else {
            return response()->json(["mensaje" => "No se ha encontrado ningun dato", "siglas" => "NDE"], 203);
        }
    }
    
    public function eliminar(Request $request, $external_id) {
        $publi = Publicacion::where("external_id", $external_id)->first();
        if ($publi) {
            if ($request->isJson()) {
                $data = $request->json()->all();
                $publicacion = Publicacion::find($publi->id);
                $publicacion->estado=false;
                $publicacion->save();
                return response()->json(["mensaje" => "Opercion Exitosa", "siglas" => "OE"], 200);
            } else {
                return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "NDF"], 400);
            }
        } else {
            return response()->json(["mensaje" => "No se ha encontrado ningun dato", "siglas" => "NDE"], 203);
        }
    }

}
