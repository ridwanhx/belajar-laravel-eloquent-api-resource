<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResourceTest extends TestCase
{
    // reset
    public function setUp(): void
    {
        parent::setUp();

        // reset Product
        Product::query()->delete();
        // reset category
        Category::query()->delete();
    }

    // # Resource
    // Resource merupakan representasi dari cara melakukan transformasi dari Model menjadi Array / JSON yang kita inginkan
    // Untuk membuat Resource, kita bisa menggunakan perintah :
    // php artisan make:resource NamaResource
    // Class Resource yang kita buat, nantinya adalah class turunan dari class JsonResource, dan kita perlu mengubah implementasi dari method toArray nya
    // File Implementasi: CategoryResource.php

    // Cara Kerja Resource
    // Resource adalah implementasi/representasi dari single object data yang ingin kita transform menjadi Array / JSON
    // Semua data attribute di model, bisa kita akses menggunakan $this, hal ini karena Resource akan melakukan proxy call ke model yang sedang digunakan
    // Setelah resource dibuat, kita bisa kembalikan data di Controller atau di Route, dan Laravel secara otomatis mengerti bahwa response ini berupa Resource
    // File implementasi : CategoryResource.php, api.php, CategoryController.php, ResourceTest.php

    public function testResource()
    {
        // jalankan seeder
        $this->seed([CategorySeeder::class]);

        // ambil data pertama dari Category
        $category = Category::first();

        // jalankan test
        $this->get("/api/categories/$category->id")
        ->assertStatus(200) // pastikan status = 200
        ->assertJson([
            'data' => [ // wrap data by default
                'id' => $category->id,
                'name' => $category->name,
                'created_at' => $category->created_at->toJson(),
                'updated_at' => $category->updated_at->toJson()
            ]
        ]);
    }

    // Wrap Attribute
    // Secara default, data JSON yang kita kembalikan dalam method toArray() akan di wrap dalam attribute bernama "data" seperti pada implementasi diatas
    // Jika kita ingin mengubah nama attribute di JSON nya, kita bisa ubah menggunakan attribute $wrap di resource nya
}
