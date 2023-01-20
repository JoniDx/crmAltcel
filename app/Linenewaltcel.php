<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\Factory;

class Linenewaltcel extends Model
{
     // use Factory;

     protected $connection = 'mysql2';
     protected $table      = 'alt_solicitudeslineasnuevas';
     protected $fillable = ['nombre','curp','numero','status','iccid','price_plan_id','tarifa_nuevo_id','ine','direccion','solito'];
}