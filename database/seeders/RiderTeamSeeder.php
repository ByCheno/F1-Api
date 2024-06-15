<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\RiderTeam;
use App\Models\Season;
use App\Models\Rider;
use App\Models\Team;
use SimpleXMLElement;

class RiderTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $client = new Client();

        $startYear = 1950;
        $endYear = date('Y'); 

        // Obtener el id de todas las seasons dado el año
        for($year = $startYear; $year <= $endYear; $year++) {

            // Guardar en $season_id el id de la temporada dado el año
            $season_id = Season::where('year', $year)->first()->id;

            //Obtener todos los equipos de la temnporada dado $year
            $response = $client->get("http://ergast.com/api/f1/{$year}/constructors");
            $xmlContent = $response->getBody()->getContents();

            $xmlObject = new SimpleXMLElement($xmlContent);
            $json = json_encode($xmlObject);
            $dataArray = json_decode($json, true);

            $teams = $dataArray['ConstructorTable']['Constructor'];

            // Ahora dado el id de la temporada y el id del equipo, obtener los pilotos de ese equipo
            foreach ($teams as $team) {
                $teamId = $team['@attributes']['constructorId'];

                // Guardar en $team_id el id del equipo dado el $teamId
                $team_id = Team::where('name', $team['Name'])->first()->id;

                $response = $client->get("http://ergast.com/api/f1/{$year}/constructors/{$teamId}/drivers");
                $xmlContent = $response->getBody()->getContents();

                $xmlObject = new SimpleXMLElement($xmlContent);
                $json = json_encode($xmlObject);
                $dataArray = json_decode($json, true);

                $drivers = $dataArray['DriverTable']['Driver'];

                foreach ($drivers as $driver) {
                    $rider = Rider::where('name', $driver['GivenName'] . ' ' . $driver['FamilyName'])->first();

                    if ($rider) {
                        $rider_id = $rider->id;

                        RiderTeam::create([
                            'rider_id' => $rider_id,
                            'team_id' => $team_id,
                            'season_id' => $season_id
                        ]);
                    } else {
                        // Manejar el caso cuando no se encuentra el piloto
                        echo "Rider not found: " . $driver['GivenName'] . ' ' . $driver['FamilyName'] . "\n";
                    }
                }
            }

        
        }
    }

}

