<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comentario extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos
     *
     * @var string
     */
    protected $table = 'comentario' ;

    /**
     * Clave primaria del modelo
     *
     * @var string
     */
    protected $primaryKey = 'idCom' ;

    /**
     * Atributos que se pueden asignar masivamente
     *
     * @var array
     */
    protected $fillable = [ 
        'comentario', 'valoracion', 'fecha_creacion', 'fecha_actualizacion', 'idUsu', 'idRec',
    ];

    /**
     * Desactiva las marcas de tiempo
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Formatear la fecha de creación.
     */
    public function getFechaCreacionAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * Formatear la fecha de actualización.
     */
    public function getFechaActualizacionAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans(); 
    }

    /**
     * Relación con USUARIO (N:1)
     * @return Usuario
     */
    public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'idUsu');
    }

    /**
     * Relación con RECETA (N:1)
     * @return Receta
     */
    public function recetas()
    {
        return $this->belongsTo(Receta::class, 'idRec');
    }
}