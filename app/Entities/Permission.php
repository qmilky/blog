<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $table = 'permission';
    public $primaryKey = 'pid';
    public $guarded = [];
    public $timestamps = false;
}
