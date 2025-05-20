<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductSizeQuantity extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'product_size_quantity';
    protected $fillable = [
        
        'product_id',
        'size_id',
        'quantity',

    ];

    // public function products()
    // {
    //     return $this->belongsTo(Product::class)->withPivot('price')->withTimestamps();
    // }

    

}
