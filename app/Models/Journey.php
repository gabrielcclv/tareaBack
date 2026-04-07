<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $fillable = ['user_id', 'bike_id', 'start_station_id', 'end_station_id', 'active', 'started_at', 'ended_at'];

    public function user() { return $this->belongsTo(User::class); }
    public function bike() { return $this->belongsTo(Bike::class); }
    public function startStation() { return $this->belongsTo(Station::class, 'start_station_id'); }
    public function endStation() { return $this->belongsTo(Station::class, 'end_station_id'); }
}