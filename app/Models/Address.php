<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
     protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'user_id'
    ];
    protected $fillable = [
        'user_id',
        'city',
        'street',
        'zipcode',
        'phone',
        'longitude',
        'latitude'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

 
}
