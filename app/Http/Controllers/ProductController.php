<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //  Implementasi materi Data Wrap
    public function data_wrap($id)
    {
        // cari data Product berdasarkan id
        $products = Product::find($id);
        return new ProductResource($products);
    }


    // Implementasi materi Data Wrap Collection
    public function data_wrap_collection()
    {
        $products = Product::all();
        return new ProductCollection($products);
    }
}
