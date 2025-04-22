<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDebugResource extends JsonResource
{
    // Implementasi materi Additional Metadata
    // override properties additional
    // public $additional = [
    //     "author" => "Muhamad Ridwan",
    // ];

    // Implementasi materi Additional Metadata - Additional Parameter Dinamis
    public static $wrap = 'data';

    public function toArray(Request $request): array
    {
        return [
            'author' => 'Muhamad Ridwan',
            'server_time' => now()->toDateTimeString(),
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
            ],
        ];
    }
}
