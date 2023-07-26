<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateUserWeather;
use App\Models\User;

class CheckWeatherUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:check-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::getUpdatableWeatherUsers()
            ->each(fn($user) => UpdateUserWeather::dispatch($user));

    }
}
