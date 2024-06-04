<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = 'https://f1-motorsport-data.p.rapidapi.com/photos';

        $queryParams = [
            'year' => '2021'
        ];

        // Encabezados de la solicitud
        $headers = [
            'X-RapidAPI-Key' => '8abd4c6f90msh34f974bc40e6b57p1d161ajsna3ea6e7b871e',
            'X-RapidAPI-Host' => 'f1-motorsport-data.p.rapidapi.com',
        ];

        // Hacer la solicitud HTTP a la API
        $response = Http::withHeaders($headers)->get($url, $queryParams);

        // Verificar que la solicitud fue exitosa
        if ($response->successful()) {
            $data = $response->json();

            // Procesar y guardar los datos en la base de datos
            foreach ($data['photos'] as $photo) {
                Season::create([
                    'year' => $photo['year']
                ]);
            }
        } else {
            // Manejar errores de la API
            $this->command->error('Error al obtener datos de la API: ' . $response->body());
        }
    }
}
