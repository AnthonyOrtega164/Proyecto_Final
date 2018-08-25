<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Publicacion
 *
 * @author antho
 */
class Publicacion extends Model {

    protected $table = 'publicacion';
    protected $primaryKey = 'id_publicacion';
    protected $fillable = ['external_id','titulo','descripcion', 'estado', 'categoria','ubicacion','created_at','updated_at','correo_persona','ruta_imagen'];
    protected $guarded = ['id_publicacion'];
    
    public function persona( ) {
        return $this->belongsTo('App\Models\Persona','correo_persona'); 
    }

    public function comentario( ) {
        return $this->hasMany('App\Models\Comentario','id_publicacion'); 
    }

}
