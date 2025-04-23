<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_product');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
