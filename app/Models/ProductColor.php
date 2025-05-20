<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductColor extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'product_color';
    protected $fillable = [
        
        'product_id',
        'color_id',

    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class)->withPivot('price')->withTimestamps();
    // }

}
