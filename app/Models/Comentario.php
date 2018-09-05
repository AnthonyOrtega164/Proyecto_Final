<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Comentario
 *
 * @author antho
 */
class Comentario extends Model {
<<<<<<< HEAD
    /**
     * 
     * @param Modelo de comentario, para la respectiva conexion y realizacion de la bd
     */
    /**
     *
     * @var $table referencia a la tabla 
     */
=======

>>>>>>> 25cf6c50a8b1cbde60ae06afb54077ec9bf799cf
    protected $table = 'comentario';
    /**
     *
     * @var $primaryKey referencia a la llave primaria de la tabla persona
     */
    protected $primaryKey = 'id_comentario';
    /**
     *
     * @var $filleable datos de la tabla persona 
     */
    protected $fillable = ['external_id','comentario', 'created_at', 'updated_at', 'estado', 'nombre_persona', 'id_publicacion'];
    /**
     *
     * @var $guaded datos sensibles
     */
    protected $guarded = ['id_comentario'];

    public function publicacion() {
        return $this->belongsTo('App\Models\Publicacion', 'id_publicacion');
    }

}
