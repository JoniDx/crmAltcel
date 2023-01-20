<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $connection = 'pos_new';
     protected $table      = 'pos_users';
}
