<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{

    protected $primaryKey = 'ownerid';
    use HasFactory;

    protected $fillable = [
        "residentid",
        "ownername",
         "owneraddress",
           "ownermobileno"



    ];
}
