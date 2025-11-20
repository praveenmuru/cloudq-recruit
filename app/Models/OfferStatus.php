<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferStatus extends Model
{
    protected $fillable = [
        'name',
        // add other columns you want to allow mass assignment
    ];
}
