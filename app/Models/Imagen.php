<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Imagen
 *
 * @author antho
 */
class Imagen extends Model {

    protected $table = 'imagen';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false;
    protected $fillable = ['id_publicacion', 'ruta'];
    protected $guarded = ['id_imagen'];

    public function publicacion() {
        return $this->belongsTo('App\Models\Publiacion', 'id_publicacion');
    }

}
