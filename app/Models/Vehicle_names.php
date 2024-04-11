<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Vehicle_names extends Model
{
    protected $fillable = [
        'id', 'vname','vtype','vmodel', 'description'
    ];
}
