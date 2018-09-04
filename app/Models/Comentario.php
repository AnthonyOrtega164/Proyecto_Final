<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Comentario
 *
 * @author antho
 */
class Comentario extends Model {
    /**
     * 
     * @param Modelo de comentario, para la respectiva conexion y realizacion de la bd
     */
    protected $table = 'comentario';
    protected $primaryKey = 'id_comentario';
    protected $fillable = ['external_id','comentario', 'created_at', 'updated_at', 'estado', 'nombre_persona', 'id_publicacion'];
    protected $guarded = ['id_comentario'];
    /**
     * 
     * @param Relacion con tabla Publicacion indexando mediante id_publicacion
     */
    public function publicacion() {
        return $this->belongsTo('App\Models\Publicacion', 'id_publicacion');
    }

}
