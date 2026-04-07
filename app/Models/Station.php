<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['name', 'location'];

    public function bikes()
    {
        return $this->hasMany(Bike::class);
    }
}