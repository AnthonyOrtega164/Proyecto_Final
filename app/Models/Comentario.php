<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Comentario
 *
 * @author antho
 */
class Comentario extends Model {

    protected $table = 'comentario';
    protected $primaryKey = 'id_comentario';
    public $timestamps = false;
    protected $fillable = ['comentario', 'created_at', 'updated_at', 'estado', 'nombre_usuario', 'id_publicacion'];
    protected $guarded = ['id_comentario'];

    public function publicacion() {
        return $this->belongsTo('App\Models\Publicacion', 'id_publicacion');
    }

}
