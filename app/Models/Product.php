<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'user_id',
        'category_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function productimages(){
        return $this->hasMany(ProductImage::class);
    }

    private function uploadImage($image)
    {
        
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image_uploaded_path = $image->storeAs('products', $filename, 'public');
        if(env('ENABLE_LOCAL_TUNNAL'))
        {
            $imageUrl = env('LOCAL_TUNNAL_URL').url($image_uploaded_path);
        }
        else
        {
            $imageUrl = Storage::disk('public')->url($image_uploaded_path);
        }
        return $imageUrl;
    }
} 
