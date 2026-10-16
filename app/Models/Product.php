<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'subcategory_id', 'name_fa', 'name_en', 'desc_fa', 'desc_en',
        'price', 'stock', 'image', 'featured',
    ];

    protected $casts = ['featured' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'fa' ? $this->name_fa : $this->name_en;
    }

    public function getDescAttribute()
    {
        return app()->getLocale() === 'fa' ? $this->desc_fa : $this->desc_en;
    }
}
