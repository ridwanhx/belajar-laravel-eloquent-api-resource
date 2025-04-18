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
    


    // # Resource Collection
    // Secara default, Resource yang sudah kita buat, bisa kita gunakan untuk menampilkan data multiple object atau dalam bentuk JSON Array
    // Kita bisa menggunakan static method collection() ketika membuat Resource nya, dan gunakan parameter berisi data collection
    // Implementasi file: routes/api.php

    // Implementasi test
    public function testResourceCollection()
    {
        // jalankan seeder
        $this->seed(CategorySeeder::class);
        // panggil collection
        $categories = Category::all();
        $this->get('/api/categories')
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $categories[0]->id,
                    'name' => $categories[0]->name,
                    'created_at' => $categories[0]->created_at->toJson(),
                    'updated_at' => $categories[0]->updated_at->toJson(),
                ],
                [
                    'id' => $categories[1]->id,
                    'name' => $categories[1]->name,
                    'created_at' => $categories[1]->created_at->toJson(),
                    'updated_at' => $categories[1]->updated_at->toJson(),
                ],
            ],
        ]);
    }



    // # Custom Resource Collection
    // Kadang, kita ingin membuat class Resource Collection secara manual, tanpa menggunakan Resource Class yang sebelumnya sudah kita buat untuk single object
    // Pada kasus ini, kita bisa membuat Resource baru, namun menggunakan tambahan parameter --collection :
    // php artisan make:resource NamaCollection --collection
    // perbedaan dengan penulisan tanpa --collection sebelumnya, ia akan membuat resource yang turunan dari JSON Resource
    // Sedangkan untuk penulisan dengan parameter --collection, secara otomatis class Resource adalah turunan dari class ResourceCollection
    // Untuk mengambil informasi collection nya, kita bisa menggunakan attribute $collection di dalam isi dari class ResourceCollection nya
    // File Implementasi: CategoryCollection.php

    // Implementasi tes
    public function testCustomResourceCollection()
    {
        // jalankan seeder
        $this->seed([CategorySeeder::class]);

        // penggil semua data category
        $categories = Category::all();

        $this->get('/api/categories-custom')
        ->assertStatus(200)
        ->assertJson([
            'total' => 2,
            'data' => [
                [
                    'id' => $categories[0]->id,
                    'name' => $categories[0]->name,
                    // Implementasi materi Nested Resource
                    // karena sebelumnya pada CategorySimpleResource.php kita telah mendefinisikan id, dan name saja, serta kita juga sudah melakukan nested resource pada CategoryCollection.php maka perlu ada penyesuaian pada bagian test ini
                    // dimana kita akan mendisable bagian program dibawah ini agar tidak diikutsertakan kedalam test
                    // 'created_at' => $categories[0]->created_at->toJson(),
                    // 'updated_at' => $categories[0]->updated_at->toJson(),
                ],
                [
                    'id' => $categories[1]->id,
                    'name' => $categories[1]->name,
                    // Implementasi materi Nested Resource
                    // karena sebelumnya pada CategorySimpleResource.php kita telah mendefinisikan id, dan name saja, serta kita juga sudah melakukan nested resource pada CategoryCollection.php maka perlu ada penyesuaian pada bagian test ini
                    // dimana kita akan mendisable bagian program dibawah ini agar tidak diikutsertakan kedalam test
                    // 'created_at' => $categories[1]->created_at->toJson(),
                    // 'updated_at' => $categories[1]->updated_at->toJson(),
                ],
            ]
        ]);
    }



    // # Nested Resource
    // Saat kita menggunakan Resource, contoh pada Resource Collection, kita juga bisa menggunakan Resource lainnya
    // Secara default, method toArray() akan dikonversi menjadi JSON
    // Namun, kita bisa menggunakan Resource lain jika kita mau
    // File implementasi: CategorySimpleResource.php
}