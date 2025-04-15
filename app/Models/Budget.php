<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budget';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'content',
        'price',
        'payment_method',
        'status',
        'data'
    ];
}
