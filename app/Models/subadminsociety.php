<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subadminsociety extends Model
{
    protected $fillable = [

        'superadminid',
        'societyid',
        'subadminid',
        'firstname',
        'lastname',
        'cnic',
        'password',
        'roleid',
        'rolename',

    ];
    use HasFactory;
}
