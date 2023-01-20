<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    protected $connection = 'cdrs';
    protected $table      = 'datos';
}
