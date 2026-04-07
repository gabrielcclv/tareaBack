<?php

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
protected $fillable = [
    'id',
    'nombre',
    ];

    public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'rol');
    }
}