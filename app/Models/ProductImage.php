<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $product_images;
    protected $fillable = [
        'product_id',
        'product_images',
        'is_featured'
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




