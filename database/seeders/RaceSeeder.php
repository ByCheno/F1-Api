<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\Race;
use App\Models\Season;
use SimpleXMLElement;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();

        $startYear = 1950;
        $endYear = date('Y'); 

        for ($year = $startYear; $year <= $endYear; $year++) {
            $response = $client->get("http://ergast.com/api/f1/{$year}");
            $xmlContent = $response->getBody()->getContents();

            $xmlObject = new SimpleXMLElement($xmlContent);
            $json = json_encode($xmlObject);
            $dataArray = json_decode($json, true);

            // Obtener el array de carreras
            $races = $dataArray['RaceTable']['Race'];

            // Verificar que la temporada existe en la base de datos
            $season = Season::where('year', $year)->first();

            if ($season) {
                foreach ($races as $race) {
                    Race::create([
                        'season_id' => $season->id,
                        'name' => $race['RaceName'],
                        'location' => $race['Circuit']['Location']['Locality'],
                        'date' => $race['Date']
                    ]);
                }
            } else {
                echo "Season for year {$year} not found in the database.\n";
            }
        }
    }
}
