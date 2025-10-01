<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos
     *
     * @var string
     */
    protected $table = 'lista' ;

    /**
     * Clave primaria del modelo
     *
     * @var string
     */
    protected $primaryKey = 'idLis' ;

    /**
     * Atributos que se pueden asignar masivamente
     *
     * @var array
     */
    protected $fillable = [ 
        'nombre_lista', 'idUsu',
    ];

    /**
     * Desactiva las marcas de tiempo
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con USUARIO (N:1)
     * @return Usuario
     */
    public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'idUsu');
    }

    /**
     * relación N:N entre Lista y Receta
	 * - modelo a recuperar
	 * - tabla pivote (intermedia)
	 * - clave foránea del modelo en que me encuentro
	 * - clave foránea del modelo con quien me relaciono
     * @return void
     */
	public function recetas()
	{
		return $this->belongsToMany(Receta::class, 'lista_receta', 'idLis', 'idRec') ;
	}

}
