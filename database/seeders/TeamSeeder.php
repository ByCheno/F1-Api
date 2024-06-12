<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use SimpleXMLElement;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $uniqueConstructors = [];

        // Define el rango de temporadas que deseas cubrir
        $startYear = 1950;
        $endYear = date('Y'); // Hasta el año actual

        for ($year = $startYear; $year <= $endYear; $year++) {
            $response = $client->get("http://ergast.com/api/f1/{$year}/constructors");
            $xmlContent = $response->getBody()->getContents();

            $xmlObject = new SimpleXMLElement($xmlContent);
            $json = json_encode($xmlObject);
            $dataArray = json_decode($json, true);

            $drivers = $dataArray['ConstructorTable']['Constructor'];

            foreach ($drivers as $driver) {
                $driverId = $driver['@attributes']['constructorId'];

                // Almacenar el piloto solo si no está ya en la colección
                if (!isset($uniqueConstructors[$driverId])) {
                    $uniqueConstructors[$driverId] = [
                        'name' => $driver['Name']
                    ];
                }
            }
        }

        foreach($uniqueConstructors as $constructor){
            Team::create($constructor);
        }
    }
}
