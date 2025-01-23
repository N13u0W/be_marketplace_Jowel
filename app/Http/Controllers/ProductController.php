<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::join('product_types', 'products.product_type_id', '=', 'product_types.id')
        ->select('products.*', 'product_types.type_name')
        ->get();
        return response([
            "message" => "product type list",
            "data" => $data,
        ]);
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'products_name' => 'required|UNIQUE:products,products_name',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);  
        $imagename = time().'.'.$request->img_url->extension();

        $request->img_url->move(public_path('image'), $imagename);

        Product::create([
            'product_type_id' => $request->product_type_id,
            'products_name' => $request->products_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'img_url' => url('/images/'.$imagename),
            'img_name' =>$imagename
        ]);

        return response(["message" => "product name created succesfully"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $data = Product::find($id);
        if (is_null($data)){
            return response([
                "message" => "product type not found",
                "data" => [],
            ],404);
        }
        return response([
            "mesage" => "product type list",
            "data" => $data,
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_type_id' => 'required',
            'products_name' => 'required|unique:products,products_name',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);  
        

        $data = Product::find($id);
        if (is_null($data)){
            return response([
                "message" => "product type not found",
                "data" => [],
            ],404);
        }
        $imageName = time().'.'.$request->img_url->extension();
        $request->img_url->move(public_path('image'), $imageName);

        $data->product_type_id = $request->product_type_id;
        $data->products_name = $request->products_name;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->img_url = $request->img_url;
        $data->img_name = $imageName;
        $data->save();
        return response(["message" => "product type update succes"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $data = Product::find($id);
        if (is_null($data)){
            return response([
                "message" => "product type not found",
                "data" => [],
            ],404);
        }

        $data->delete();

        return response([
            "mesage" => "product type list",
            "data" => $data,
        ]);
    }
}
