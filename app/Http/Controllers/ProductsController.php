<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products', [
            'products' => Products::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        $path = Storage::putFile('images', $request->file('image'));


        Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $path
        ]);

        return redirect()->route('products')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addProducts');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('products/edit', [
            'product' => Products::find($id)
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $products = Products::find($request->id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $file = $request->file('image');

        $path = $products->image;

        if (file_exists($file)) {
            Storage::delete($products->image);
            $path = Storage::putFile('images', $file);
        }

        $products->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $path,
        ]);
        return redirect()->route('products')
            ->with('success', 'Product created successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product = Products::find($request->id);
        Storage::delete($product->image);
        $product->delete();
        return redirect()->back();
    }

}
