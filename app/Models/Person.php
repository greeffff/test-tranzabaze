<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    protected $primaryKey = 'uid';
    protected $fillable = [
        'uid', 'name', 'sdn_type_id', 'data',
    ];
}
