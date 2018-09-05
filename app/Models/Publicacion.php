<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model {
    /**
     * 
     * @param Modelo de publicacion, para la respectiva conexion y realizacion de la bd
     */
    /**
     *
     * @var $table referencia a la tabla
     */
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
    /**
     * 
     * @param Relacion con tabla Persona indexando mediante correo_persona
     */
    public function persona( ) {
        return $this->belongsTo('App\Models\Persona','correo_persona'); 
    }
    /**
     * 
     * @param Relacion con tabla Comentario indexando mediante id_publicacion
     */
    public function comentario( ) {
        return $this->hasMany('App\Models\Comentario','id_publicacion'); 
    }

}
