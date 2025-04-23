<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResourceResponseTest extends TestCase
{
    // reset tables
    public function setUp(): void
    {
        parent::setUp();

        Product::query()->delete();
        Category::query()->delete();
    }



    // # Resource Response
    // Di method toArray() terdapat parameter Request, yang artinya kita bisa mengambil informasi pada HTTP Request jika dibutuhkan
    // Resource juga memiliki method withResponse() yang bisa kita override untuk mengubah Http Response

    // Implementasi test
    public function testResourceResponse()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $this->get('/api/products')
        ->assertStatus(200)
        // cek kesesuaian header
        ->assertHeader('X-Powered-By', 'Muhamad Ridwan');
    }


    // Response Method
    // Atau saat membuat Resource Object, terdapat method response() yang bisa kita gunakan juga untuk memanipulasi data response

    // Implementasi
    public function testResponseMethod()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil data pertama saat query dijalankan
        $product = Product::first();

        $this->get("/api/products/$product->id")
        ->assertStatus(200)
        ->assertHeader('X-Powered-By', 'Lorem Ipsum');
    }
}
