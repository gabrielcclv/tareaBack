<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1:1 Usuario - Perfil
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        // Estaciones
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->timestamps();
        });

        // Bicicletas (1:N Estación - Bicicletas)
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['disponible', 'no-disponible', 'en-mantenimiento', 'en-uso'])->default('disponible');
            $table->string('model');
            $table->timestamps();
        });

        // Tabla intermedia (M:N Usuario - Bicicletas) -> Trayectos
        Schema::create('journeys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bike_id')->constrained()->cascadeOnDelete();
            $table->foreignId('start_station_id')->constrained('stations');
            $table->foreignId('end_station_id')->nullable()->constrained('stations');
            $table->boolean('active')->default(true);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journeys');
        Schema::dropIfExists('bikes');
        Schema::dropIfExists('stations');
        Schema::dropIfExists('profiles');
    }
};