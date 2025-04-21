<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertContains;

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



    // # Data Wrap Collection
    // Khusus untuk mengubah attribute $wrap untuk Collection, kita tidak bisa menggunakan NamaResource::collection(), hal ini karena kode tersebut sebenarnya akan membuat object AnonymousResourceCollection, bukan menggunakan Resource yang kita buat
    // Jika hasil result JSON ResourceCollection.toArray() mengandung attribute yang terdapat di $wrap, maka Laravel tidak akan melakukan wrap, namun jika tidak ada, maka akan melakukan wrap
    // File Implementasi ProductCollection.php, api.php, ProductController.php

    // Implementasi test
    public function testDataWrapCollection()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // simpan output dari halaman yang dituju kedalam var response
        $response = $this->get('/api/products')
        // pastikan status 200
        ->assertStatus(200);
        // ambil semua names dari response
        $names = $response->json("data.*.name");
        // lakukan iterasi sebanyak 5x
        for ( $i = 1; $i <= 5; $i++ ) {
            // pastikan string berikut(jarum) ada didalam iterable $names(jerami)
            assertContains("Product $i of Gadget", $names);
        }
        
        for ( $i = 1; $i <= 5; $i++ ) {
            // pastikan string berikut(jarum) ada didalam iterable $names(jerami)
            assertContains("Product $i of Automotive", $names);
        }
    }
}
