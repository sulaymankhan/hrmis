<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeExport extends Model
{
    public $table = "employee_exports";
    protected $casts=['id_details'=>'array'];
}
