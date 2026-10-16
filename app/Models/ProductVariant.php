<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'name_fa', 'name_en', 'price_delta', 'stock', 'sort'];

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'fa' ? $this->name_fa : $this->name_en;
    }
}
