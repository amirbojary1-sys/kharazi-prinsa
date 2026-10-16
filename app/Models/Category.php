<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['slug', 'name_fa', 'name_en', 'desc_fa', 'desc_en', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
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
