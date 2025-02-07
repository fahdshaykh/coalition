<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Storage::exists('products.json') ? json_decode(Storage::get('products.json'), true) : [];
        return view('products.index', compact('products'));
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
        $product_name = $request->product_name;
        $quantity = $request->quantity;
        $price = $request->price;

        $total_value = $quantity * $price;

        $datetime = Carbon::now()->toDateTimeString();

        $product = [
            'product_name' => $product_name,
            'quantity' => $quantity,
            'price' => $price,
            'total_value' => $total_value,
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ];

        $json = Storage::exists('products.json') ? json_decode(Storage::get('products.json'), true) : [];

        $json[] = $product;
        $jsonData = json_encode($json, JSON_PRETTY_PRINT);

        Storage::put('products.json', $jsonData);

        return response()->json(['success' => 'Success']);
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
