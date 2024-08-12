<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductController\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::where('user_id', Auth('sanctum')->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth('sanctum')->id();
        return Product::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::where('user_id', Auth('sanctum')->id())->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::where('user_id', Auth('sanctum')->id())->findOrFail($id);
        $update = $product->update($request->validated());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('user_id', Auth('sanctum')->id())->findOrFail($id);
        return Response()->json([
            'message' => 'true'
        ]);
    }
}
