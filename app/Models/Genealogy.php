<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genealogy extends Model
{
    protected $table = 'genealogy_tree';

    protected $fillable = [
        'service',
        'type',
        'name',
        'origin',
        'smaller',
        'nato',
        'il',
        'matrimonio'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
