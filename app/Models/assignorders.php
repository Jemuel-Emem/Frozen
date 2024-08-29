<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignorders extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phonenumber',
        'productlist',
        'quantity',
        'totalorder',
        'status',
        'assignrider',

    ];
}
