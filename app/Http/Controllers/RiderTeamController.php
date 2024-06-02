<?php

namespace App\Http\Controllers;

use App\Models\RiderTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Para validar los datos


class RiderTeamController extends Controller
{
    public function index(){
        $riderTeam = RiderTeam::all();

        if($riderTeam->isEmpty()){
            $data = [
                'message' => 'RiderTeam not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'RiderTeam found',
            'status' => 200
        ];

        return response()->json($riderTeam, $data['status']);
    }

    public function show($id){

        $riderTeam = RiderTeam::find($id);

        if(!$riderTeam){
            $data = [
                'message' => 'RiderTeam not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $data = [
            'message' => 'RiderTeam found',
            'status'  => 200
        ];

        return response()->json($riderTeam, $data['status']);
    }

    public function store(Request $request){

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $riderTeam = $this->createRiderTeam($validatedData['data']);

        if($riderTeam['status'] != 201){
            return response()->json($riderTeam, $riderTeam['status']);
        }

        $data = [
            'message' => 'RiderTeam created',
            'status' => 201
        ];

        return response()->json($riderTeam, $data['status']);
    }

    public function validateData($request){
        $validatedData = Validator::make($request->all(), [
            'season_id' => 'required',
            'rider_id' => 'required',
            'team_id' => 'required'
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

    public function createRiderTeam($data){
    
        $riderTeam = RiderTeam::create([
            'season_id' => $data['season_id'],
            'rider_id' => $data['rider_id'],
            'team_id' => $data['team_id']
        ]);

        if(!$riderTeam){
            return [
                'message' => 'RiderTeam not created',
                'status' => 500
            ];
        }

        return [
            'message' => 'RiderTeam created',
            'status' => 201
        ];
    }

    public function update(Request $request, $id){
    
        $riderTeam = RiderTeam::find($id);

        if(!$riderTeam){
            $data = [
                'message' => 'RiderTeam not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $validatedData = $this->validateData($request);

        if($validatedData['status'] != 200){
            return response()->json($validatedData, $validatedData['status']);
        }

        $riderTeam->season_id = $validatedData['data']['season_id'];
        $riderTeam->rider_id = $validatedData['data']['rider_id'];
        $riderTeam->team_id = $validatedData['data']['team_id'];
        $riderTeam->save();

        $data = [
            'message' => 'RiderTeam updated',
            'status' => 200
        ];

        return response()->json($riderTeam, $data['status']);
    }

    public function destroy($id){
        $riderTeam = RiderTeam::find($id);

        if(!$riderTeam){
            $data = [
                'message' => 'RiderTeam not found',
                'status' => 404
            ];
            return response()->json($data, $data['status']);
        }

        $riderTeam->delete();

        $data = [
            'message' => 'RiderTeam deleted',
            'status' => 204
        ];

        return response()->json($data, $data['status']);
    }
}
