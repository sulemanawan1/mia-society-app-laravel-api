<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{


    protected $fillable = [

        'societyname',
        'societyaddress',
        'userid'


    ];

    use HasFactory;
}
