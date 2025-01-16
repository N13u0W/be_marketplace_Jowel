<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_type_id' => 'required|exists:product_type_id',
            'products_name' => 'required|unique:products,products_name',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->img_url->extension();

        $request->img_url->move(public_path('images'), $imageName);

        Product::create([
            'product_type_id' => $request->product_type_id,
            'products_name' => $request->products_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'img_url' => url('/images/'.$imageName),
            'img_name' => $imageName,
        ]);

        return response(["message" => "Product is created successfully"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
