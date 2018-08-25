<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
/**
 * Description of PersonaController
 *
 * @author antho
 */
class PersonaController extends Controller {

    public function inicioSesion(Request $request) {
        if ($request->json()) {
            try {
                $data = $request->json()->all();
                $user = Persona::where("correo_persona", $data["correo_persona"])->first();
                if (!$user) {
                    return response()->json([
                                "correo_persona" => $user->correo_persona,
                                "nombre_persona" => $user->nombre_persona,
                                "telefono_persona"=>$user->telefono_persona,
                                "foto_persona"=>$user->foto_persona,
                                "mensaje" => "Bienvenido, nuevo ususario!!", "siglas" => "OE"], 200);
                } else {
                    return response()->json(["mensaje" => "Bienvenido, ya esta registrado", "siglas" => "NDE"], 200);
                }
            } catch (\Exception $exc) {
                return response()->json(["mensaje" => "Faltan datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "DNF"], 400);
        }
    }

}
