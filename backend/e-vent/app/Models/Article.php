<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix', 'short_description','description','img_path','token','stripe_id','options'];
    
    protected $casts = [
        'options' => 'array',
    ];

    
}
