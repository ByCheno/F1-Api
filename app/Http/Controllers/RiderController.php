<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Para validar los datos


class RiderController extends Controller{

    // Devuelve todos los pilotos
    public function index()
    {
        $riders = Rider::all();

        if($riders->isEmpty()){
            $data = [
                'message' => 'No riders found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }
            

        return response()->json($riders, 200);
    }

    // Devuelve un piloto en concreto
    public function show($id)
    {
        $rider_id = Rider::find($id);

        //Comprobar si el id existe
        if(!$rider_id){
            $data = [
                'message' => 'Rider not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($rider_id, 200);
    }

    // Funcion que crea un piloto llamando a las funciones validateData y createRider
    public function store(Request $request)
    {
        $validatedData = $this->validateData($request);

        if ($validatedData['status'] != 200) {
            return response()->json($validatedData, $validatedData['status']);
        }

        $rider = $this->createRider($validatedData['data']);

        if ($rider['status'] != 201) {
            return response()->json($rider, $rider['status']);
        }

        return response()->json($rider, $rider['status']);
    }

    public function validateData($request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'nationality' => 'required'
        ]);

        if ($validatedData->fails()) {
            return [
                'message' => 'Validation error',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
        }

        return [
            'data' => $request->all(),
            'status' => 200
        ];
    }


    public function createRider($data)
    {
    
        $rider = Rider::create([
            'name' => $data['name'],
            'nationality' => $data['nationality']
        ]);
    
        if(!$rider){
            return [
                'message' => 'Error creating rider',
                'status' => 500
            ];
        }

        return [
            'message' => 'Rider created',
            'status' => 201
        ];
    }


    // Funcion que actualiza un piloto llamando a las funciones validateData y updateRider
    public function update(Request $request, $id)
    {
        
        $rider = Rider::find($id);

        if(!$rider){
            $data = [
                'message' => 'Rider not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = $this->validateData($request);

        if ($validatedData['status'] != 200) {
            return response()->json($validatedData, $validatedData['status']);
        }

        $rider->name = $validatedData['data']['name'];
        $rider->nationality = $validatedData['data']['nationality'];
        $rider->save();

        return response()->json($rider, $rider['status']);

    }

    // Funcion que elimina un piloto
    public function destroy($id){

        $rider= Rider::find($id);

        if(!$rider){
            $data = [
                'message' => 'Rider not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $rider->delete();

        $data = [
            'message' => 'Rider deleted', 
            'status' => 204
        ];

        return response()->json($data, $data['status']);
    }

}