<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // Implementasi materi Membuat Model
    protected $table = 'categories',
    $primaryKey = 'id',
    $keyType = 'int';
    public $incrementing = true,
    $timestamps = true;
    
    // Merelasikan categories (1) ke products (N)
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
