<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Features;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Check if the user is logged 
        if (Auth::user()) {
            // Get the currently logged-in user 
            $loginUser = Auth::user();

            $features =DB::table('users AS u')
            ->join('roles_permission AS rp', 'u.role_id', '=', 'rp.role_id')
            ->join('permissions AS p', 'rp.permission_id', '=', 'p.id')
            ->join('features AS f', 'f.id', '=', 'p.feature_id')
            ->join('roles AS r', 'u.role_id', '=', 'r.id')
            ->where('u.id', $loginUser->id)
            ->select(DB::raw('DISTINCT f.name AS feature_name, u.role_id as role_id, r.name as rolename'))
            ->get();

            // Pass the data to your Blade view
            return view('dashboard', [
                'loginUser' => $loginUser,
                'features' => $features,
            ]);
        } else {
            // If the user is not logged in, redirect them to the login page
            return redirect()->route('login'); // Assuming you have a route named 'login'
        }
    }
}
