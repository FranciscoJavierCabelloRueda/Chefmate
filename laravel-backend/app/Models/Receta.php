<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos
     *
     * @var string
     */
    protected $table = 'receta' ;

    /**
     * Clave primaria del modelo
     *
     * @var string
     */
    protected $primaryKey = 'idRec' ;

    /**
     * Atributos que se pueden asignar masivamente
     *
     * @var array
     */
    protected $fillable = [ 
        'titulo', 'descripcion', 'ingredientes', 'pasos', 'foto', 'idUsu',
    ];

    /**
     * Desactiva las marcas de tiempo
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con COMENTARIO (1:N)
     * @return Comentario
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idRec');
    }

    /**
     * Relación con USUARIO (N:1)
     * @return Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsu');
    }

    /**
     * relación N:N entre Receta y Lista
	 * - modelo a recuperar
	 * - tabla pivote (intermedia)
	 * - clave foránea del modelo en que me encuentro
	 * - clave foránea del modelo con quien me relaciono
     * @return void
     */
	public function listas()
	{
		return $this->belongsToMany(Lista::class, 'lista_receta', 'idRec', 'idLis') ;
	}

    
}
