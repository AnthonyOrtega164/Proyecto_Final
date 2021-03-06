<?php
namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
/**
 * Description of PersonaController
 *
 * @author antho
 */
class PersonaController {

    public function inicioSesion(Request $request) {
        if ($request->json()) {
            try {
                $data = $request->json()->all();
                $user = Persona::where("correo_persona", $data["correo_persona"])->first();
                if (!$user) {
                    $persona = new Persona();
                    $persona->nombre_persona=$data["nombre_persona"];
                    $persona->correo_persona = $data["correo_persona"];
                    $persona->telefono_persona = $data["telefono_persona"];
                    $persona->foto_persona = $data['foto_persona'];
                    $persona->save();
                    return response()->json(["mensaje" => "Bienvenido, nuevo ususario!!", "siglas" => "OE"], 200);
                } else {
                    return response()->json(["mensaje" => "Bienvenido, ya esta registrado", "siglas" => "OE"], 200);
                }
            } catch (\Exception $ex) {
                return response()->json(["mensaje" => "Faltan datos", "siglas" => "FD"], 400);
            }
        } else {
            return response()->json(["mensaje" => "La data no tiene el formato deseado", "siglas" => "DNF"], 400);
        }
    }

}
