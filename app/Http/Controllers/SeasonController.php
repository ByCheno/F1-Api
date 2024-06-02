<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Para validar los datos

class SeasonController extends Controller
{

    // Devuelve todas las temporadas
    public function index()
    {
        $seasons = Season::all();

        if($seasons->isEmpty()){
            $data = [
                'message' => 'No seasons found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }
            

        return response()->json($seasons, 200);
    }

    // Devuelve una temporada en concreto
    public function show($id)
    {
        $season_id = Season::find($id);

        //Comprobar si el id existe
        if(!$season_id){
            $data = [
                'message' => 'Season not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($season_id, 200);
    }

    // Funcion que crea una temporada llamando a las funciones validateData y createSeason
    public function store(Request $request)
    {
        $validatedData = $this->validateData($request);

        if ($validatedData['status'] != 200) {
            return response()->json($validatedData, $validatedData['status']);
        }

        $season = $this->createSeason($validatedData['data']);

        if ($season['status'] != 201) {
            return response()->json($season, $season['status']);
        }

        return response()->json($season, $season['status']);
    }

    // Se validan los datos de la petición
    public function validateData($request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return [
                'message' => 'Validation failed', 
                'status' => 400
            ];
        }

        return [
            'data' => $request->all(),
            'status' => 200
        ];
    }

    // Crea una temporada si los datos son validos
    public function createSeason($data)
    {
        $season = Season::create([
            'year' => $data['year']
        ]);

        // Comprobar si se ha creado la temporada
        if(!$season){
            return [
                'message' => 'Season not created', 
                'status' => 500
            ];
        }

        return [
            'seasons' => $season,
            'status' => 201
        ];
    }

    // Actualiza una temporada si existe
    public function update(Request $request, $id)
    {
        $season = Season::find($id);

        if(!$season){
            $data = [
                'message' => 'Season not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = $this->validateData($request);

        if ($validatedData['status'] != 200) {
            return response()->json($validatedData, $validatedData['status']);
        }

        $season->year = $validatedData['data']['year'];
        $season->save();

        return response()->json($season, $season['status']);
    }

    // Elimina una temporada
    public function destroy($id)
    {
        $data = Season::find($id);
        
        if(!$data){
            $data = [
                'message' => 'Season not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data->delete();

        $data = [
            'message' => 'Season deleted', 
            'status' => 204
        ];

        return response()->json($data, $data['status']);
    }
}