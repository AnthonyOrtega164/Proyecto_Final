<?php
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
    protected $fillable = ['external_id','comentario', 'created_at', 'updated_at', 'estado', 'nombre_persona', 'id_publicacion'];
    protected $guarded = ['id_comentario'];

    public function publicacion() {
        return $this->belongsTo('App\Models\Publicacion', 'id_publicacion');
    }

}
