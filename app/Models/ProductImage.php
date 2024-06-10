<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class ProductImage extends Model
{
    use HasFactory;
    protected $product_images;
    protected $fillable = [
        'product_id',
        'product_image',
        'is_featured'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'product_id'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute()
    {
        $productId = $this->product_id;
        $imageName = $this->product_image;
        return Storage::disk('public')->url("products/$productId/$imageName");
    }
}




