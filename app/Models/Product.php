<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'brand',
        'price',
        'color',
        'size',
        'category',
        'picture',
        'in_stock'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carts ()
    {
        return $this->hasMany(Cart::class);
    }

    public function users() {
        return $this->belongsToMany(User ::class, 'product_user', 'product_id', 'user_id')
                    ->withTimestamps();
	}
}
