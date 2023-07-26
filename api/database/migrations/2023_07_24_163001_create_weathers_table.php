<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('main')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->text('weather_array')->nullable();
            $table->decimal('main_temp', 10,2)->default(0);
            $table->decimal('main_feels_like', 10,2)->default(0);
            $table->decimal('main_temp_min', 10,2)->default(0);
            $table->decimal('main_temp_max', 10,2)->default(0);
            $table->decimal('main_pressure', 10,2)->default(0);
            $table->decimal('main_humidity', 10,2)->default(0);
            $table->decimal('main_sea_level', 10,2)->default(0);
            $table->decimal('main_grnd_level', 10,2)->default(0);
            $table->decimal('visibility', 10,2)->default(0);
            $table->decimal('wind_speed', 10,2)->default(0);
            $table->decimal('wind_deg', 10,2)->default(0);
            $table->decimal('wind_gust', 10,2)->default(0);
            $table->decimal('rain_1h', 10,2)->nullable();
            $table->decimal('rain_3h', 10,2)->nullable();
            $table->decimal('snow_1h', 10,2)->nullable();
            $table->decimal('snow_3h', 10,2)->nullable();
            $table->decimal('clouds_all', 10,2)->default(0);
            $table->datetime('calculated_at')->nullable();
            $table->integer('timezone_offset')->default(0);
            $table->string('sys_country')->nullable();
            $table->datetime('sys_sunrise')->nullable();
            $table->datetime('sys_sunset')->nullable();
            $table->string('city_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weathers');
    }
};
