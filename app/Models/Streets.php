<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streets extends Model
{
    use HasFactory;

    protected $fillable = [

        'bid',
        'from',
        'to',
        'name'
    ];
}
