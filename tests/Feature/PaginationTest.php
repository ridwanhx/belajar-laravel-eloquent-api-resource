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

class PaginationTest extends TestCase
{
    // reset tables
    public function setUp(): void
    {
        parent::setUp();

        Product::query()->delete();
        Category::query()->delete();
    }



    // # Pagination
    // Jika kita mengirim data Pagination ke dalam Resource Collection, secara otomatis Laravel akan menambahkan informasi link dan juga meta (paging) secara otomatis
    // Attribute links berisi informasi link menuju page sebelum dan setelahnya
    // Attribute meta berisi informasi paging
    // File implementasi : api.php, ProductController.php

    // Implementasi test
    public function testPagination()
    {
        // jalankan seeders
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // do test
        $response = $this->get('/api/products-paging')
        ->assertStatus(200);

        assertNotNull($response->json('data'));
        assertNotNull($response->json('links'));
        assertNotNull($response->json('meta'));
    }
}
