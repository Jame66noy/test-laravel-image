<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pmage extends Model
{
    use HasFactory;
    //protected $table = ['pmages'];
    protected $fillable = [
        //'id',
        'image',
        'title',
        'about',
        'email',
        'phone',
        'name',
    ];
}
