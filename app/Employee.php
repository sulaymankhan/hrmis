<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Morilog\Jalali\Jalalian;
class Employee extends Model
{
    protected $appends=['statusDescription'];
    protected $casts=['id_details'=>'array'];
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

    public function notes(){
        return $this->hasMany(\App\Employeenote::class,'employee_id','id');
    }

    public static function getStatusList(){
        return [
            ['status'=>1,'description'=>'اصلی'],
            ['status'=>2,'description'=>'خدمتی'],
            ['status'=>3,'description'=>'تبدیل'],
            ['status'=>4,'description'=>'استعفا'],
            ['status'=>5,'description'=>'انفکاک'],
        ];
    }

    public function getStatusDescriptionAttribute(){
        $list = Employee::getStatusList();
        foreach(Employee::getStatusList() as $s):
            if($s['status'] === $this->status){
                return $s['description'];
            }
        endforeach;
        return '';
    }

    public function getDobAttribute($val){
        if(is_null($val)){
            return '';
        }
        try{
            if(\strpos('/',$val)){
                $date= Jalalian::fromFormat('Y/m/d',$val);
            }else{
                $date= Jalalian::fromFormat('Y-m-d',$val);
            }
        }catch(\Exception $e){
            return ['year'=>'','month'=>'','day'=>''];
        }
        return [
            'year'=>(Integer)$date->format('Y'),
            'month'=>(Integer)$date->format('m'),
            'day'=>(Integer)$date->format('d')
        ];
    }
    public function getContractStartDateAttribute($val){
        if(is_null($val)){
            return '';
        }
        try{
            if(\strpos('/',$val)){
                $date= Jalalian::fromFormat('Y/m/d',$val);
            }else{
                $date= Jalalian::fromFormat('Y-m-d',$val);
            }
        }catch(\Exception $e){
            return ['year'=>'','month'=>'','day'=>''];
        }
     
       
        return [
            'year'=>(Integer)$date->format('Y'),
            'month'=>(Integer)$date->format('m'),
            'day'=>(Integer)$date->format('d')
        ];
    }

    public function getContractEndDateAttribute($val){
        if(is_null($val)){
            return '';
        }
        try{
            if(\strpos('/',$val)){
                $date= Jalalian::fromFormat('Y/m/d',$val);
            }else{
                $date= Jalalian::fromFormat('Y-m-d',$val);
            }
        }catch(\Exception $e){
            return ['year'=>'','month'=>'','day'=>''];
        }
        return [
            'year'=>(Integer)$date->format('Y'),
            'month'=>(Integer)$date->format('m'),
            'day'=>(Integer)$date->format('d')
        ];
    }

    public function getIdDetailsAttribute($val){
        if(is_null($val)){
            return [
                'volume'=>'',
                'year'=>'',
                'page'=>'',
                'registration'=>'',
                'nid_no'=>''
            ];
        }
        return json_decode($val);
    }
}
