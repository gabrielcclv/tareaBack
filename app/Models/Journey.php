<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends Model
{
    protected $fillable = [
        'id',
        'id_curso',
        'nombre',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

}