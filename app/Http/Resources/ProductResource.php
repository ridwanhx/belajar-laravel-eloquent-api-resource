<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategorySimpleResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ini adalah representasi dari Product
 * @mixin Product
 */

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    //  Implementasi materi Data Wrap
    // Inisiasi properti bernama wrap yang kemudian akan kita ubah nama nya dari yang awalnya secara default "data", menjadi "value"
    public static $wrap = 'value';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => new CategorySimpleResource($this->category),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
