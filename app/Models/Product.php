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
        'picture'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
