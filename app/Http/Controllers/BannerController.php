<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Banner::all();
        return response([
            "message" => "Banner List",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);
        $imageName = time() . '.' . $request->img_url->extension();
        $request->img_url->move(public_path('images'), $imageName); 
        Banner::create([
            'img_url' => url('/images/' . $imageName),
            'img_name' => $imageName
        ]);
        return response(["message" => "Banner Created Success"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Banner Not Found",
                "data" => [],
            ], 404);
        }
        return response([
            "message" => "Banner Detail",
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Banner Not Found",
                "data" => [],
            ], 404);
        }
        $imageName = time() . '.' . $request->img_url->extension();
        $request->img_url->move(public_path('images'), $imageName);
        $data->img_url = $request->img_url;
        $data->img_name = $imageName;
        $data->save();
        return response(["message" => "Banner Updated Success"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Banner Not Found",
                "data" => [],
            ], 404);
        }
        
        $data->delete();
        return response([
            "message" => "Banner Deleted",
            "data" => $data
        ]);
    }
}
