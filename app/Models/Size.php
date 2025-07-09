<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Size extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'size';
    protected $fillable = ['size'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size', 'size_id', 'product_id')
                    ->withPivot('stock', 'sku', 'price')
                    ->withTimestamps();
    }
}