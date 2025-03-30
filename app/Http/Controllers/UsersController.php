<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller\getFeatures;

class UsersController extends Controller
{
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

             return view('users.index',[
                'features'=>$features,
                'users' =>$usersWithRoles,
                'currentPage' =>$currentPage,
                'totalPages' =>$totalPages
             ]);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $features =$this->getFeatures();

       // Get all roles with their name and ID
        $roles = Roles::all(['id', 'name']);
        // dd($roles);
        return view('users.create',[
            'features'=>$features,
            'roles'=> $roles
        ]);
    }

    /**
     * Edit user
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, int $id)
    {
        $features =$this->getFeatures();
        $role =  Roles::findOrFail($id)
                ->where('id','=',$id)
                ->select('id')
                ->first();
 
        $user = DB::table('users')
                ->find($id);
        
        $roles = Roles::all(['id', 'name']);
        // dd($roles);
        return view('users.edit',[
            'features'=>$features,
            'role'=> $role,
            'roles'=>$roles,
            'user'=>$user
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $users, int $id)
    {
        // Find the user to update
        $user = User::findOrFail($id);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ];

        if ($request->filled('new_password')) {
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           // dd($validator->errors()); 
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the old password is correct
        if ($request->filled('password') && !Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Incorrect old password'])->withInput();
        }

        // Update the user's basic information
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');

        // Update the password if a new password is provided and the old password was correct (if provided)
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        // Save the changes
        $user->save();

        // Redirect the user with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $user)
    {
        $userToDelete = User::findOrFail($user); // Find the role by its ID

        // Perform the deletion logic
        $userToDelete->delete();
        
        return redirect()->route('users.index')->with('success', 'Role deleted successfully!');
    }

    /**
     * Get the features 
     *
     * @return $features
     */
   /*  private function getFeatures(){
        $features =DB::table('users AS u')
            ->join('roles_permission AS rp', 'u.role_id', '=', 'rp.role_id')
            ->join('permissions AS p', 'rp.permission_id', '=', 'p.id')
            ->join('features AS f', 'f.id', '=', 'p.feature_id')
            ->join('roles AS r', 'u.role_id', '=', 'r.id')
            ->where('u.id', Auth::user()->id)
            ->select(DB::raw('DISTINCT f.name AS feature_name,u.role_id as role_id, r.name as rolename'))
            ->get();
        return $features;
    } */
}
