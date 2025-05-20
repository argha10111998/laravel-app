<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'category'; 

    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id'
    ];

    /**
     * Get the user that owns the profile.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
