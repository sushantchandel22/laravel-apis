<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productimage extends Model
{
    use HasFactory;

    protected $table = 'productimages';
    protected $fillable = [
        'product_id',
        'product_images'
    ];
    protected $hidden =[
        'id',
        'created_at',
        'updated_at',
        'product_id'
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}



