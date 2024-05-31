<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index()
    {
        return Season::all();
    }

    public function store(Request $request)
    {
        $season = Season::create($request->all());
        return response()->json($season, 201);
    }

    public function show($id)
    {
        return Season::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $season = Season::findOrFail($id);
        $season->update($request->all());
        return response()->json($season, 200);
    }

    public function destroy($id)
    {
        Season::destroy($id);
        return response()->json(null, 204);
    }
}