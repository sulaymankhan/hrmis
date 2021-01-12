<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeNote extends Model
{
    protected $fillable=['user_id','note'];
}
