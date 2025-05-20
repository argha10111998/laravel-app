<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'quantity',
        'image',
        'images',
        'category_id',
        'brand_id',
        'color_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function sizes()
    {
        // This is likely the problem - this relationship should match your actual table structure
        // If your pivot table doesn't have a price column, you shouldn't be trying to get it
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id')
                    ->withPivot('stock', 'sku') // Update these to match your actual columns
                    ->withTimestamps();
    }

    public function productsize()
    {
        // This relationship definition also needs to be checked
        return $this->hasMany(ProductSizeTemplate::class);
    }
}