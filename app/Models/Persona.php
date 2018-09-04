<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Persona
 *
 * @author Usuario
 */
class Persona extends Model {
    /**
     * 
     * @param Modelo de persona, para la respectiva conexion y realizacion de la bd
     */
    protected $table = 'persona';
    protected $primaryKey = 'correo_persona';
    public $timestamps = false;
    protected $fillable = ['nombre_persona', 'telefono_persona', 'foto_persona'];
    protected $guarded = ['correo_persona'];
    /**
     * 
     * @param Relacion con tabla Publicacion indexando mediante correo_persona
     */
    public function publicacion() {
        return $this->hasMany('App\Models\Publicacion', 'correo_persona');
    }

}
