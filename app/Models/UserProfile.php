<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserProfile extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user_profile'; 

    protected $fillable = [
        'user_id',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
