<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Brand extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'brand'; 

    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
