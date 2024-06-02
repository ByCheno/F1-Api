<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Para validar los datos

class ResultController extends Controller
{
    public function index(){
        $result = Result::all();

        if($result->isEmpty()){
            $data = [
                'message' => 'Result not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Result found',
            'status' => 200
        ];

        return response()->json($result, $data['status']);
    }

    public function show($id){

        $result = Result::find($id);

        if(!$result){
            $data = [
                'message' => 'Result not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $data = [
            'message' => 'Result found',
            'status'  => 200
        ];

        return response()->json($result, $data['status']);
    }

    public function store(Request $request){

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $result = $this->createResult($validatedData['data']);

        if($result['status'] != 201){
            return response()->json($result, $result['status']);
        }

        $data = [
            'message' => 'Result created',
            'status' => 201
        ];

        return response()->json($result, $data['status']);
    }

    public function validateData($request){
        $validatedData = Validator::make($request->all(), [
            'race_id' => 'required',
            'rider_team_id' => 'required',
            'position' => 'required'
        ]);

        if($validatedData->fails()){
            return [
                'message' => 'Validation error',
                'status' => 400
            ];
        }

        return [
            'data' => $request->all(),
            'status' => 200
        ];
    }

    public function createResult($data){
    
        $result = Result::create([
            'race_id' => $data['race_id'],
            'rider_team_id' => $data['rider_team_id'],
            'position' => $data['position']
        ]);

        if(!$result){
            return [
                'message' => 'Error creating result',
                'status' => 500
            ];
        }

        return [
            'message' => 'Result created',
            'status' => 201
        ];
    }

    public function update(Request $request, $id){
    
        $result = Result::find($id);

        if(!$result){
            $data = [
                'message' => 'Result not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $result->race_id = $validatedData['data']['race_id'];
        $result->rider_team_id = $validatedData['data']['rider_team_id'];
        $result->position = $validatedData['data']['position'];
        $result->save();

        $data = [
            'message' => 'Result updated',
            'status' => 200
        ];

        return response()->json($result, $data['status']);
    }

    public function destroy($id){
        $result = Result::find($id);

        if(!$result){
            $data = [
                'message' => 'Result not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $result->delete();

        $data = [
            'message' => 'Result deleted',
            'status' => 204
        ];

        return response()->json($data, $data['status']);
    }
}
