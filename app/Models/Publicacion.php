<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model {
<<<<<<< HEAD
    /**
     * 
     * @param Modelo de publicacion, para la respectiva conexion y realizacion de la bd
     */
    /**
     *
     * @var $table referencia a la tabla
     */
=======

>>>>>>> 25cf6c50a8b1cbde60ae06afb54077ec9bf799cf
    protected $table = 'publicacion';
    /**
     *
     * @var $primaryKey referencia a la llave primaria de la tabla persona 
     */
    protected $primaryKey = 'id_publicacion';
    /**
     *
     * @var $filleable datos de la tabla persona  
     */
    protected $fillable = ['external_id','titulo','descripcion', 'estado', 'categoria','created_at','updated_at','correo_persona','ruta_imagen','telefono_persona'];
    /**
     *
     * @var $guaded datos sensibles
     */
    protected $guarded = ['id_publicacion'];
    
    public function persona( ) {
        return $this->belongsTo('App\Models\Persona','correo_persona'); 
    }

    public function comentario( ) {
        return $this->hasMany('App\Models\Comentario','id_publicacion'); 
    }

}
