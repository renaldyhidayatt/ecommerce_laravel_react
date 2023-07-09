<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'slug_category',
        'image_category',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
