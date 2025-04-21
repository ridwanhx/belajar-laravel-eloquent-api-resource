<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Implementasi materi Data Wrap
        // ambil seluruh data Category, lalu untuk setiap data nya lakukan iterasi
        Category::all()->each(function ( Category $category ) {
            // lakukan perulangan sebanyak 5x
            for ( $i = 1; $i <= 5; $i++ ) {
                // generate / insert data untuk relasi products, dengan ketentuan sebagai berikut
                $category->products()->create([
                    // ketentuan untuk kolom name
                    'name' => "Product $i of $category->name",
                    // ketentuan untuk kolom price | min 100, max 1000
                    'price' => rand(100, 1000)
                ]);
            }
        });
    }
}
