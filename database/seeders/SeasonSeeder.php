<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\Season;
use SimpleXMLElement;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();

        // Hacer las solicitudes a la API
        $responses = [
            $client->get("https://ergast.com/api/f1/seasons"),
            $client->get("https://ergast.com/api/f1/seasons?limit=30&offset=30"),
            $client->get("https://ergast.com/api/f1/seasons?limit=30&offset=60"),
        ];

        // Procesar cada respuesta
        foreach ($responses as $response) {
            $this->convertXmlToJson($response);
        }
    }

    public function convertXmlToJson($response)
    {
        $xmlContent = $response->getBody()->getContents();

        // Convertir el contenido XML a un objeto SimpleXMLElement
        $xmlObject = new SimpleXMLElement($xmlContent);
        
        // Convertir el objeto SimpleXMLElement a JSON y luego a un array asociativo
        $json = json_encode($xmlObject);
        $dataArray = json_decode($json, true);

        // Verificar que la clave 'SeasonTable' existe en el array
        if (isset($dataArray['SeasonTable'])) {
            // Obtener el array de temporadas
            $seasonTable = $dataArray['SeasonTable'];
            if (isset($seasonTable['Season'])) {
                $seasons = $seasonTable['Season'];
                
                // Iterar sobre cada temporada y crear una entrada en la base de datos
                foreach ($seasons as $season) {
                    Season::create([
                        'year' => $season
                    ]);
                }
            } else {
                echo "Key 'Season' not found in 'SeasonTable'.";
            }
        } else {
            echo "Key 'SeasonTable' not found.";
        }
    }
}
