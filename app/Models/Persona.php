<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model {
<<<<<<< HEAD
    /**
     * 
     * @param Modelo de persona, para la respectiva conexion y realizacion de la bd
     */
    /**
     *
     * @var $table referencia a la tabla  
     */
=======
>>>>>>> 25cf6c50a8b1cbde60ae06afb54077ec9bf799cf
    protected $table = 'persona';
    /**
     *
     * @var $primaryKey referencia a la llave primaria de la tabla persona
     */
    protected $primaryKey = 'correo_persona';
    /**
     *
     * @var $timestamps hace referencia a que no se utilizaran campos update_at y created_at
     */
    public $timestamps = false;
    /**
     *
     * @var $filleable datos de la tabla persona 
     */
    protected $fillable = ['nombre_persona', 'telefono_persona', 'foto_persona'];
    /**
     *
     * @var $guaded datos sensibles
     */
    protected $guarded = ['correo_persona'];
    
    public function publicacion() {
        return $this->hasMany('App\Models\Publicacion', 'correo_persona');
    }

}
