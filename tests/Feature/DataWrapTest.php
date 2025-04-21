<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataWrapTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // reset data
        Product::query()->delete();
        Category::query()->delete();
    }

    // # Data Wrap
    // Secara default, data JSON yang dibuat oleh Resource akan disimpan dalam attribute "data"
    // Jika kita ingin menggantinya, kita bisa ubah attribute yang bernama $wrap di Resource dengan nama attribute yang kita mau
    // Secara default, jika dalam toArray() kita mengembalikan array yang terdapat attribute sama dengan $wrap, maka data JSON tidak akan di wrap
    // File Implementasi : ProductResource.php, ProductSeeder.php, api.php, ProductController.php

    // Implementasi test
    public function testDataWrap()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil data pertama dari Product
        $product = Product::first();

        // jalankan test
        $this->get("/api/products/$product->id")
        ->assertStatus(200)
        ->assertJson([
            "value" => [
                'name' => $product->name,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name
                ],
                'price' => $product->price,
                'created_at' => $product->created_at->toJson(),
                'updated_at' => $product->updated_at->toJson(),
            ]
        ]);
    }
}
