<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    public $timestamps = false;
    protected $fillable=['id','name','email','salary','expected_earning'];
}