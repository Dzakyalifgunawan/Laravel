<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class minuman extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'nama',
        'harga',
    ];
}
