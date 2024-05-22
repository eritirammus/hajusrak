<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        $markers = Map::all();
        return Inertia::render('Map', [
            'markers' => $markers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
        ]);
        Map::create([
            'name' => $request->name,
            'description' => $request->description,
            'lat' => $request->lat,
            'lng' => $request->lng
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Map $map)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
        ]);
        $map->name = $request->name;
        $map->description = $request->description;
        $map->lat = $request->lat;
        $map->lng = $request->lng;
        $map->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        $map->delete();
    }
}
