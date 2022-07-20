<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'number',
        'country',
        'city',
        'street',
        'zip',
        'default'
    ];

    public function users ()
    {
        return $this->belongsTo(User::class);
    }
}
