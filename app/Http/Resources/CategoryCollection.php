<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Implementasi materi Custom Resource Collection
        return [
            // 'data' => $this->collection,
            // 'total' => count($this->collection)


            // Implementasi materi Nested Resource
            'data' => CategorySimpleResource::collection($this->collection),
            'total' => count($this->collection),
        ];
    }
}
