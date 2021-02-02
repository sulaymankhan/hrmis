<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OthersController extends Controller
{
    public function getVillages(){
        return 
        [
            'provinces'=>\App\Village::selectRaw('distinct(province)')->distinct('province')->orderBy('province')->groupBy('province')->get(),
            'districts'=>\App\Village::select('province','district')->orderBy('province')->get()
        ];
    }

    public function getDashboardData(Request $r){
        if( in_array($r->user()->role,['admin','manager'] ) ){
            $data=[
                'total_employees'=>\App\Employee::count(),
                'total_centers'=>\App\Center::count(),
                'total_posts'=>\App\Post::count(),
                'total_users'=>\App\User::count(),
                'total_occupied_posts'=>\App\Post::where('has_employee',1)->count(),
                'total_available_posts'=>\App\Post::where('has_employee',0)->count(),
                'employee_count_by_center'=>\DB::table('employees')->leftJoin('centers','employees.center_id','centers.id')->selectRaw('centers.name,count(employees.id) as total_employees')->groupBy('centers.name')->orderBy('centers.name')->get()
            ];
            return $data; 
        }
        abort(403);
    }
}
