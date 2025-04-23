<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getFeatures(){
        $features =DB::table('users AS u')
            ->join('roles_permission AS rp', 'u.role_id', '=', 'rp.role_id')
            ->join('permissions AS p', 'rp.permission_id', '=', 'p.id')
            ->join('features AS f', 'f.id', '=', 'p.feature_id')
            ->join('roles AS r', 'u.role_id', '=', 'r.id')
            ->where('u.id', Auth::user()->id)
            ->select(DB::raw('DISTINCT f.name AS feature_name,u.role_id as role_id, r.name as rolename'))
            ->get();   
            session()->flash('features', $features);     
        return $features;
    }

    
}
