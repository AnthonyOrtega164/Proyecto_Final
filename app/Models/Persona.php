<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Persona
 *
 * @author Usuario
 */
class Persona extends Model {
    protected $table = 'persona';
    protected $primaryKey = 'correo_persona';
    public $timestamps = false;
    protected $fillable = ['nombre_persona', 'telefono_persona', 'foto_persona'];
    protected $guarded = ['correo_persona'];
    
    public function publicacion() {
        return $this->hasMany('App\Models\Publicacion', 'correo_persona');
    }

}
