<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'author', 'description',
        'full_description', 'price', 'image', 'quantity',
        'is_new', 'is_hit', 'status', 'publisher',
        'publication_year', 'pages', 'language', 'cover_type', 'article',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_hit' => 'boolean',
        'status' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Скоупы для быстрой фильтрации каталога
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeHits($query)
    {
        return $query->where('is_hit', true);
    }
}