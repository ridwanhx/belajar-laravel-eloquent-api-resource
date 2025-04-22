<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertNotNull;

class AdditionalMetadataTest extends TestCase
{
    // reset tables
    public function setUp(): void
    {
        parent::setUp();

        Product::query()->delete();
        Category::query()->delete();
    }



    // # Additional Metadata
    // Kadang, kita infin menambahkan attribute tambahan selain "data"
    // Untuk attribute tambahan yang statis / tidak berubah nilai nya, kita bisa tambahkan di Resource dengan cara meng-overridde properties $additional

    // Implementasi test
    public function testAdditionalMetadata()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil elemen / data pertama hasil seeding diatas
        $product = Product::first();

        // jalankan test
        $this->get("/api/products-debug/$product->id")
        ->assertStatus(200)
        ->assertJson([
            'author' => 'Muhamad Ridwan',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'price'=> $product->price,
            ],
        ]);
    }


    // Additional Parameter Dinamis
    // Jika kita butuh tambahan additional parameter yang dinamis, kita bisa langsung saja buat di dalam toArray()
    // Yang penting adalah ada attribute yang sama dengan $wrap
    // File Implementasi : ProductDebugResource.php
    public function testAdditionalParameterDinamis()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil elemen / data pertama hasil seeding diatas
        $product = Product::first();

        // jalankan test
        $response = $this->get("/api/products-debug/$product->id")
        ->assertStatus(200)
        ->assertJson([
            'author' => 'Muhamad Ridwan',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'price'=> $product->price,
            ],
        ]);

        assertNotNull($response->json('server_time'));
    }
}
