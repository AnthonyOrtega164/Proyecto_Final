<?php
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
    protected $fillable = ['external_id','titulo','descripcion', 'estado', 'categoria','created_at','updated_at','correo_persona','ruta_imagen','telefono_persona'];
    protected $guarded = ['id_publicacion'];
    
    public function persona( ) {
        return $this->belongsTo('App\Models\Persona','correo_persona'); 
    }

    public function comentario( ) {
        return $this->hasMany('App\Models\Comentario','id_publicacion'); 
    }

}
