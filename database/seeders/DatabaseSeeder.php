<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Station;
use App\Models\Bike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Esto ya lo tienes
        $users = User::factory(10)->create();

        // 1. Crear perfiles para los usuarios generados
        foreach ($users as $user) {
            Profile::create([
                'user_id' => $user->id,
                'phone' => '600' . rand(100000, 999999),
                'address' => 'Campus Universitario ' . rand(1, 10)
            ]);
        }

        // 2. Crear estaciones
        $stationA = Station::create(['name' => 'Facultad de Ciencias', 'location' => 'Norte']);
        $stationB = Station::create(['name' => 'Biblioteca Central', 'location' => 'Centro']);

        // 3. Crear bicicletas
        Bike::create(['station_id' => $stationA->id, 'model' => 'BMX-Campus', 'status' => 'disponible']);
        Bike::create(['station_id' => $stationA->id, 'model' => 'BMX-Campus', 'status' => 'disponible']);
        Bike::create(['station_id' => $stationB->id, 'model' => 'Paseo-Campus', 'status' => 'en-mantenimiento']);
        Bike::create(['station_id' => $stationB->id, 'model' => 'Paseo-Campus', 'status' => 'disponible']);
    }
}