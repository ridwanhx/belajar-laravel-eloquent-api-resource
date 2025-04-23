<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConditionalAttributesTest extends TestCase
{
    // reset tables
    public function setUp(): void
    {
        parent::setUp();

        Product::query()->delete();
        Category::query()->delete();
    }



    // # Conditional Attributes
    // Pada beberapa kasus, ketika kita mengakses relation pada model di Resource, secara otomatis Laravel akan melakukan query ke database
    // Kadang hal ini berbahaya kalau ternyata relasinya sangatlah banyak, sehingga ketika mengubah menjadi JSON, akan sangat lambat
    // Kita bisa melakukan pengecekan Conditional Attribute, bisa kita gunakan untuk pengecekan boolean ataupun relasi


    // Conditional Method
    // Untuk melakukan pengecekan kondisi, kita bisa gunakan method berikut di Resource:

    // when(boolean, value, default)
    // params : kondisi boolean, value yang akan dimasukkan kedalam JSON, jika value tidak tersedia masukkan default nya.

    // whenHas(attribute, default)
    // params: misal jika suatu terdapat suatu attribute tertentu maka tampilkan, jika tidak cukup kembalikan nilai default nya
    
    // whenNotNull(attribute)
    // params: misal jika suatu attribute data nya tidak Null maka tampilkan, jika Null jangan tampilkan
    
    // mergeWhen(boolean, array)
    // params: misal jika kita ingin memasukkan beberapa data kedalam array(param 2), tapi hanya ketika kondisi boolean(param 1) terpenuhi / jika kondisi diawal true, maka lakukan merge untuk setiap data di dalam array
    
    // whenLoaded(relation)
    // params: misal jika kita ingin menampilkan data, contohnya dari Model Product ada relasi dengan Category, tapi dengan syarat kalau datanya sudah di load

    // Implementasi test
    public function testConditionalAttributes()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil data pertama dari Product
        $product = Product::first();

        // jalankan test
        $this->get("/api/products/$product->id")
        ->assertStatus(200)
        ->assertJson([
            'value' => [
                'name' => $product->name,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'price' => $product->price,
                'is_expensive' => $product->price > 1000,
                'created_at' => $product->created_at->toJson(),
                'updated_at' => $product->updated_at->toJson(),
            ]
        ]);
    }
}
