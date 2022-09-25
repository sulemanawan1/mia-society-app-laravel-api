<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{


    protected $primaryKey = 'residentid';
    use HasFactory;



    protected $fillable = [
        "residentid",
       "subadminid",
       "vechileno",
       "residenttype",
       "propertytype"




    ];

}
