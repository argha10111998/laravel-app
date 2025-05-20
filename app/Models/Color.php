<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Color extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'color';
    protected $fillable = [
        'color',
        'color_slug',
        'color_code',
    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class)->withPivot('price')->withTimestamps();
    // }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
