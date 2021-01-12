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
}
