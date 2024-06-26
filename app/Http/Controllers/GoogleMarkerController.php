<?php

namespace App\Http\Controllers;

use App\Models\GoogleMarker;
use Illuminate\Http\Request;

class GoogleMarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $markers = GoogleMarker::get();

        return response()->json(compact('markers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $marker = GoogleMarker::create($request->all());

        return response()->json(compact('marker'));
    }

    /**
     * Display the specified resource.
     */
    public function show(GoogleMarker $googleMarker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoogleMarker $googleMarker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marker = GoogleMarker::find($id);
        $marker->update($request->all());

        return response()->json(compact('marker'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        GoogleMarker::destroy($id);

        return response()->json(['message' => 'Marker deleted']);
    }
}