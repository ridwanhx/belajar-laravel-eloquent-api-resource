<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    // Implementasi materi Membuat Model
    protected $table = 'products',
    $primaryKey = 'id',
    $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    
    // Merelasikan categories (1) ke products (N)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
