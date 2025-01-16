<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = ProductType::all();

        return response ([
            'id' => 1,
            'type_name' => "successfully"

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:product_types,type_name',
        ], [
            'type_name.required' => 'is required',
            'type_name.unique' => 'already exist',
        ]);

        $productType = ProductType::create([
            'type_name' => $request->type_name
        ]);

        return response(["masseage" => "Product type created succesfully!"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ProductType::find($id);

        if (is_null($data)){
            return response ([
                'message' => 'error Not Found',
                'data' => [],
            ], 404);
        }

        return response ([
            'message' => 'Product Type',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_name' => 'required|unique:product_types,type_name',
        ]);

        $data = ProductType::find($id);

        if (is_null($data)){
            return response ([
                'message' => 'error Not Found',
                'data' => [],
            ], 404);
        }

        $data->type_name = $request->type_name;
        $data->save();

        return response(['message => "Product Type update'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductType::find($id);

        if (is_null($data)){
            return response ([
                'message' => 'error Not Found',
                'data' => [],
            ], 404);
        }

        $data->delete();

        return response ([
            'message' => 'Product is deleted success',
            'data' => $data,
        ]);
    }
}
