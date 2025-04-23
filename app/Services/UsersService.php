<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller\getFeatures;
use App\Contracts\FeatureInterface;

class UsersService extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
           // $users = User::with('role.permissions')->get();
            $features = $this->getFeatures();

            $itemsPerPage = 5;
            $usersWithRoles = User::select('users.id', 'users.name as username', 'roles.name as role_name')
                            ->join('roles', 'users.role_id', '=', 'roles.id')
                             ->paginate(5);

            $currentPage = $usersWithRoles->currentPage();
            $totalPages  = $usersWithRoles-> lastPage();

             return [
                'features'=>$features,
                'users' =>$usersWithRoles,
                'currentPage' =>$currentPage,
                'totalPages' =>$totalPages
             ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:', // 'confirmed' requires a password_confirmation field
            'role_id' => 'nullable|exists:roles,id', // 
        ]);

        // 2. Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id'=>$request->role_id
        ]);

        $features =$this->getFeatures();
    
        $request->session()->flash('features', $features);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
}