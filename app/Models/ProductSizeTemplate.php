<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeTemplate extends Model
{
    use HasFactory;
    protected $table = 'product_size';
    
    // Add this fillable property with all the fields
    protected $fillable = [
        'product_id',
        'size_id',
        'quantity'
        // Add any other fields that need to be mass assignable
    ];
}