<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_fa', 'name_en', 'desc_fa', 'desc_en', 'price', 'stock',
        'category_id', 'subcategory_id', 'image', 'featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->approved()->latest();
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'fa' ? $this->name_fa : $this->name_en;
    }

    public function getDescAttribute(): string
    {
        return app()->getLocale() === 'fa' ? ($this->desc_fa ?: $this->desc_en) : ($this->desc_en ?: $this->desc_fa);
    }

    /** [0 => main image, ...gallery paths] */
    public function gallery(): array
    {
        $paths = $this->images()->pluck('image')->all();
        return array_values(array_unique(array_merge([$this->image], $paths)));
    }

    public function avgRating(): ?float
    {
        $avg = $this->approvedReviews()->avg('rating');
        return $avg ? round($avg, 1) : null;
    }

    public function reviewsCount(): int
    {
        return $this->approvedReviews()->count();
    }
}
