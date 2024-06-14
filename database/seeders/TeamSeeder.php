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

        
        $startYear = 1950;
        $endYear = date('Y');

        for ($year = $startYear; $year <= $endYear; $year++) {
            $response = $client->get("http://ergast.com/api/f1/{$year}/constructors");
            $xmlContent = $response->getBody()->getContents();

            $xmlObject = new SimpleXMLElement($xmlContent);
            $json = json_encode($xmlObject);
            $dataArray = json_decode($json, true);

            $teams = $dataArray['ConstructorTable']['Constructor'];

            foreach ($teams as $team) {
                $teamId = $team['@attributes']['constructorId'];

                if (!isset($uniqueConstructors[$teamId])) {
                    $uniqueConstructors[$teamId] = [
                        'name' => $team['Name']
                    ];
                }
            }
        }

        foreach($uniqueConstructors as $constructor){
            Team::create($constructor);
        }
    }
}
