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
            // Implementasi materi Conditional Attributes
            'is_expensive' => $this->when($this->price > 1000, true, false),
            'stock' => $this->stock,
            // Implementasi materi Conditional Attributes
            // 'category' => new CategorySimpleResource($this->category), // before Conditional Attributes
            'category' => new CategorySimpleResource($this->whenLoaded('category')),    // after
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
