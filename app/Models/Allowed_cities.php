<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Allowed_cities extends Model
{
    protected $fillable = [
        'id', 'name', 'description'
    ];
}
