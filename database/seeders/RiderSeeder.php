<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;
use App\Models\Rider;
use GuzzleHttp\Client;
use SimpleXMLElement;

class RiderSeeder extends Seeder
{
    public function run()
    {
        $client = new Client();
        $uniqueDrivers = [];

        // Define el rango de temporadas que deseas cubrir
        $startYear = 1950;
        $endYear = date('Y'); // Hasta el año actual

        for ($year = $startYear; $year <= $endYear; $year++) {
            $response = $client->get("http://ergast.com/api/f1/{$year}/drivers?limit=110");
            $xmlContent = $response->getBody()->getContents();

            $xmlObject = new SimpleXMLElement($xmlContent);
            $json = json_encode($xmlObject);
            $dataArray = json_decode($json, true);

            $drivers = $dataArray['DriverTable']['Driver'];

            foreach ($drivers as $driver) {
                $driverId = $driver['@attributes']['driverId'];

                // Almacenar el piloto solo si no está ya en la colección
                if (!isset($uniqueDrivers[$driverId])) {
                    $uniqueDrivers[$driverId] = [
                        'name' => $driver['GivenName'] . ' ' . $driver['FamilyName'],
                        'nationality' => $driver['Nationality']
                    ];
                }
            }
        }

        foreach($uniqueDrivers as $driver){
            Rider::create($driver);
        }
    }
}
