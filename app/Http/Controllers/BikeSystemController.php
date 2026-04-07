<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Station;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class BikeSystemController extends Controller
{
    public function listStations()
    {
        $stations = Cache::remember('stations_list', 60, function () {
            return Station::with(['bikes' => function($query) {
                $query->where('status', 'disponible');
            }])->get();
        });

        return response()->json($stations);
    }

    public function showBike(Bike $bike)
    {
        return response()->json($bike);
    }

    public function listJourneys(User $user)
    {
        $journeys = $user->usedBikes()->get();
        return response()->json($journeys);
    }

    // Iniciar trayecto
    public function startJourney(User $user, Bike $bike)
    {
        // un usuario no puede tener más de un trayecto activo
        if ($user->journeys()->where('active', true)->exists()) {
            return response()->json(['error' => 'El usuario ya tiene un trayecto en curso.'], 400);
        }

        // una bicicleta que no esté disponible o esté en uso no puede alquilarse
        if ($bike->status !== 'disponible') {
            return response()->json(['error' => 'La bicicleta no está disponible.'], 400);
        }

        Journey::create([
            'user_id' => $user->id,
            'bike_id' => $bike->id,
            'start_station_id' => $bike->station_id,
            'active' => true,
            'started_at' => now(),
        ]);

        $bike->update(['status' => 'en-uso', 'station_id' => null]);

        return response()->json(['message' => 'Trayecto iniciado correctamente.']);
    }

    // Finalizar trayecto en una estación concreta
    public function endJourney(User $user, Station $station)
    {
        $journey = $user->journeys()->where('active', true)->first();

        if (!$journey) {
            return response()->json(['error' => 'El usuario no tiene trayectos activos.'], 404);
        }

        $journey->update([
            'active' => false,
            'end_station_id' => $station->id,
            'ended_at' => now(),
        ]);

        $journey->bike->update(['status' => 'disponible', 'station_id' => $station->id]);

        return response()->json(['message' => 'Trayecto finalizado en la estación: ' . $station->name]);
    }
}