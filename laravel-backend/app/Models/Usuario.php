<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * Nombre de la tabla en la base de datos
     *
     * @var string
     */
    protected $table = 'usuario' ;

    /**
     * Clave primaria del modelo
     *
     * @var string
     */
    protected $primaryKey = 'idUsu' ;

    /**
     * Atributos que se pueden asignar masivamente
     *
     * @var array
     */
    protected $fillable = [ 
        'nombre', 'apellidos', 'email', 'foto', 'password', 'admin',
    ];

    /**
     * Atributos ocultos al serializar el modelo
     *
     * @var array
     */
    protected $hidden = [ 'password', ];

    /**
     * Desactiva las marcas de tiempo
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define los casts de atributos
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'password'  => 'hashed',
        ];
    }

    /**
     * Relación con RECETA (1:N)
     * @return Receta
     */
    public function recetas()
    {
        return $this->hasMany(Receta::class, 'idUsu');
    }

    /**
     * Relación con COMENTARIO (1:N)
     * @return Comentario
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idUsu');
    }

    /**
     * Relación con LISTA (1:N)
     * @return Lista
     */
    public function listas()
    {
        return $this->hasMany(Lista::class, 'idUsu');
    }
}
