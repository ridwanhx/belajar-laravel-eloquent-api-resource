<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    // Implementasi materi Resource
    // Cara Kerja Resource
    public function category_resource( $id ) {
        // ambil terlebih dahulu data category di Model Category berdasarkan id yang dikirim melalui parameter
        $category = Category::findOrFail($id);
        // kembalikan object baru yang dihasilkan dari CategoryResource berdasarkan object $category
        return new CategoryResource($category);
    } 
}
