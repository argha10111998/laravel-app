<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductSize extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'product_size';
    protected $fillable = [
        
        'product_id',
        'size_id',
        'price',

    ];

    // public function products()
    // {
    //     return $this->belongsTo(Product::class)->unique('product_id','size_id')->withTimestamps();
    // }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

}
