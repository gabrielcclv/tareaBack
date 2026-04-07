<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)
        ->as('reservas')
        ->withPivot(['reserved_at', 'returned_at']);
    }

    public function reservasActivas() {
        return $this->books()->wherePivotNull('returned_at');
    }

    public function reservasDevueltas() {
        return $this->books()->wherePivotNotNull('returned_at');
    }

    // Relación 1:1 entre usuario y perfil
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relación 1:N con los trayectos
    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }

    // Relación M:N entre usuario y bicicletas
    public function usedBikes()
    {
        return $this->belongsToMany(Bike::class, 'journeys')
            ->as('trayecto')
            ->withPivot(['start_station_id', 'end_station_id', 'active', 'started_at', 'ended_at'])
            ->withTimestamps();
    }
}