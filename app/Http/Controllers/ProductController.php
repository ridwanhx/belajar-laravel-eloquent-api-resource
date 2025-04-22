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


    // Implementasi materi Pagination
    public function products_paging( Request $request )
    {
        $page = $request->get('page', 1);
        $products = Product::paginate(perPage: 2, page: $page);
        return new ProductCollection($products);
    }
}
