<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Para validar los datos

class RaceController extends Controller
{
    
    public function index(){
        $races = Race::all();

        if($races->isEmpty()){
            $data = [
                'message' => 'Race not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Se han encontrado las carreras',
            'status' => 200
        ];

        return response()->json($races, $data['status']);
    }

    public function show($id){

        $race = Race::find($id);

        if(!$race){
            $data = [
                'message' => 'Race not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $data = [
            'message' => 'Se ha encontrado la carrera',
            'status'  => 200
        ];

        return response()->json($race, $data['status']);
    }

    public function store(Request $request){

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $race = $this->createRace($validatedData['data']);

        if($race['status'] != 201){
            return response()->json($race, $race['status']);
        }

        $data = [
            'message' => 'Carrera creada',
            'status' => 201
        ];

        return response()->json($race, $data['status']);
    }

    public function validateData($request){
        $validatedData = Validator::make($request->all(), [
            'season_id' => 'required',
            'name' => 'required',
            'location' => 'required',
            'date' => 'required'
        ]);

        if($validatedData->fails()){
            return [
                'message' => 'Datos no validos',
                'status' => 400
            ];
        }

        return [
            'data' => $request->all(),
            'status' => 200
        ];
    }

    public function createRace($data){
    
        $race = Race::create([
            'season_id' => $data['season_id'],
            'name' => $data['name'],
            'location' => $data['location'],
            'date' => $data['date']
        ]);

        if(!$race){
            return [
                'message' => 'Error creando la carrera',
                'status' => 500
            ];
        }

        return [
            'message' => 'Carrera creada',
            'status' => 201
        ];
    }

    public function update(Request $request, $id){
    
        $race = Race::find($id);

        if(!$race){
            $data = [
                'message' => 'Race not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $race->season_id = $validatedData['data']['season_id'];
        $race->name = $validatedData['data']['name'];
        $race->location = $validatedData['data']['location'];
        $race->date = $validatedData['data']['date'];
        $race->save();

        $data = [
            'message' => 'Carrera actualizada',
            'status' => 200
        ];

        return response()->json($race, $data['status']);
    }

    public function destroy($id){
        $race = Race::find($id);

        if(!$race){
            $data = [
                'message' => 'Race not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $race->delete();

        $data = [
            'message' => 'Race deleted',
            'status' => 204
        ];

        return response()->json($data, $data['status']);
    }
    
}
