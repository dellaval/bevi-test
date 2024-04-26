<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Modules\Products\Models\Products;
use Modules\Products\Http\Controllers\Interfaces\ProductsControllerInterface;

class ProductsController extends Controller implements ProductsControllerInterface
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Products::select('name', 'description', 'price')->get());
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => '',
            'stock_quantity' => 'required|numeric',
            'status' => Rule::in(["stock", "replacement", "missing"]),
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $obj = new Products();
        $obj->name = strip_tags($request->input('name'));
        $obj->description = strip_tags($request->input('description'));
        $obj->price = $request->price;
        $obj->stock_quantity = $request->stock_quantity;
        $obj->status = strip_tags($request->input('status'));
        $obj->save();
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
        return response()->json(Products::select('name', 'description', 'price')->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => '',
            'stock_quantity' => 'required|numeric',
            'status' => Rule::in(["stock", "replacement", "missing"]),
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $obj = Products::find($id);
        $obj->name = strip_tags($request->input('name'));
        $obj->description = strip_tags($request->input('description'));
        $obj->price = $request->price;
        $obj->stock_quantity = $request->stock_quantity;
        $obj->status = strip_tags($request->input('status'));
        $obj->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Products::destroy($id)){
            return response()->noContent();
        }
        return response()->json(['status' => 'ERROR'], 400);
    }
}
