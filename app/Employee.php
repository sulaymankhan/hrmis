<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function setId(){
        if($this->id_number){
            return $this->id_number;
        }
        $lastId = Employee::orderBy('id','desc')->first();
        
        if(!$lastId){
            $lastId = 1;
        }else{
            $lastId=$lastId->id;
        }
        $this->id_number=sprintf('%04d', $lastId);
        return $this->id_number;
    }
}
