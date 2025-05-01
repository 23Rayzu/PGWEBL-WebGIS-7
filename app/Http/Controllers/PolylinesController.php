<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolylinesModel;

class PolylinesController extends Controller
{
    protected $polylines;

    public function __construct()
    {
        $this->polylines= new PolylinesModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        // Validate Reuqest
        $request->validate(
            [
                'name'=>'required|unique:polylines,name',
                'description'=>'required',
                'geom_polyline'=>'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2408',
            ],
            [
                'name.required'=>'Name is required',
                'name.unique'=>'Name already exist',
                'description.required'=>'Description is required',
                'geom_polyline.required'=>'Polyline is required',
            ]
            );

              // Get image File
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'name' => $request->name,
            'geom' => $request->geom_polyline,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // create data
        if (!$this->polylines->create($data)) {
            return redirect()->route('map')->with('success', 'Polyline Failed to add');
        }

        //redirect to map
        return redirect()->route('map')->with('success', 'Polyline Has Been Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
