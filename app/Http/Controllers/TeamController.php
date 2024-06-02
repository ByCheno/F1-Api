<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Para validar los datos

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        if($teams->isEmpty()){
            $data = [
                'message' => 'No teams found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }
            

        return response()->json($teams, 200);
    }

    public function show($id){
        $team_id = Team::find($id);

        if(!$team_id){
            $data = [
                'message' => 'Team not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Team found', 
            'status' => 200
        ];

        return response()->json($team_id, $data['status']);
    }

    public function store(Request $request){

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $team = $this->createTeam($validatedData['data']);

        if($team['status'] != 201){
            return response()->json($team, $team['status']);
        }

        return response()->json($team, $team['status']);
    }

    public function validateData($request){
    
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if($validatedData->fails()){
            return [
                'message' => 'Validation failed', 
                'errors' => $validatedData->errors(), 
                'status' => 400
            ];
        }

        return [
            'data' => $request->all(),
            'status' => 200
        ];    
    }

    public function createTeam($data){
        
        $team = Team::create([
            'name' => $data['name']
        ]);

        if(!$team){
            return [
                'message' => 'Team not created', 
                'status' => 500
            ];
        }

        return [
            'team' => $team,
            'status' => 201
        ];
        
    }

    public function update(Request $request, $id){

        $team = Team::find($id);

        if(!$team){
            $data = [
                'message' => 'Team not found', 
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $team->name = $validatedData['data']['name'];
        $team->save();

        return response()->json($team, $team['status']);
    }

    public function destroy($id){

        $team = Team::find($id);

        if(!$team){
            $data = [
                'message' => 'Team not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $team->delete();

        $data = [
            'message' => 'Team deleted',
            'status' => 204
        ];

        return response()->json($data, $data['status']);
    }
}
