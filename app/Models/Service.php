<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'user_id',
        'budget',
        'employer',
        'name',
        'method_payment',
        'price',
        'status',
        'contract',
        'data',
        'obs',
        'start',
        'end',
        'created_at',
        'updated_at'
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer');
    }

    public function genealogies()
    {
        return $this->belongsTo(Genealogy::class, 'id');
    }
}
