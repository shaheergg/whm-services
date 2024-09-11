<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edis extends Model
{
    use HasFactory;
    protected $table = "edis";
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
