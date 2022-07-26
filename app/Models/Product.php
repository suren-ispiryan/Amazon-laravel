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
        'subcategory',
        'picture',
        'in_stock',
        'published'
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

    public function orders ()
    {
        return $this->hasMany(Order::class);
    }

    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
