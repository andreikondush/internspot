<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;

class AddCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds cities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonData = file_get_contents(dirname(__DIR__, 2) . '/Cities/cz.json');

        $cities = json_decode($jsonData, true);

        if (is_array($cities)) {
            foreach ($cities as $city) {
                City::updateOrCreate([
                    'name' => $city['city']
                ]);
            }
        }

        $this->info('Cities have been successfully added to the system.');
    }
}
