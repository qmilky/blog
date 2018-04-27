<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public $table = 'role';
    public $primaryKey = 'rid';
    public $guarded = [];
    public $timestamps = false;
}
