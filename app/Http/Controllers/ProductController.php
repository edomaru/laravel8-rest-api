<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required|min:10|max:255',
            'price' => 'required|integer|min:100',
            'category_id' => 'required|exists:categories,id'
        ]);
    }

    public function store()
    {
        $data = $this->validateRequest();

        $product = Product::create($data); 

        return new ProductResource($product);
    }
    
    public function update(Product $product)
    {
        $data = $this->validateRequest();

        $product->update($data); 

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
