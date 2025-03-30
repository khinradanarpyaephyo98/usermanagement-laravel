<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Features;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller\getFeatures;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class RolesController extends Controller


{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            $users = User::with('role.permissions')->get();
        
            // Get the currently logged-in user 
            $loginUser = Auth::user();
            $features = $this->getFeatures();
                
            $feature_permission_check = DB::table('permissions')
                                        ->join('features AS f', 'f.id', '=', 'permissions.feature_id')
                                        ->join('roles_permission AS rp', 'rp.permission_id', '=', 'permissions.id')
                                        ->join('roles AS r', 'r.id', '=', 'rp.role_id')
                                        ->groupBy('r.name', 'f.name')
                                        ->selectRaw('r.name AS rolename, GROUP_CONCAT(permissions.name) AS permissions, f.name AS feature')
                                        ->get();
            $itemsPerPage = 5;
            $roles = Roles::select('id','name as rolename')
                    ->paginate($itemsPerPage);

            $currentPage = $roles->currentPage();
            $totalPages  = $roles-> lastPage();
          
            // Pass the data to your Blade view
            return view('roles.index', [
                'loginUser' => $loginUser,
                'features' => $features,
                'roles' => $roles,
                'currentPage' =>$currentPage,
                'totalPages' =>$totalPages,
                'feature_permission_check'=> $feature_permission_check
            ]);
        } else {
            // If the user is not logged in, redirect them to the login page
            return redirect()->route('login'); // Assuming you have a route named 'login'
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
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        // 2. Create the new role
        $role = Roles::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $permissionsInput = $request->input('permissions');
            $permissionsToAttach = array_keys($permissionsInput);
            Log::info('Permissions To Attach (before attach):', $permissionsToAttach);
            $role->permissions()->attach($permissionsToAttach);
            Log::info('Permissions Attached successfully!');
        }
        else{
            dd("There has permission  error");
        }

        // 6. Render the index view with features data
        return redirect()->route('roles.index')->with('success','Roles permissions created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {
        $features = $this->getFeatures();

        $feature_permissions = Features::with('permission')
       ->orderBy('id')
       ->get();
   
        $featuresWithPermissions = [];
        
        foreach ($feature_permissions  as $feature) {
            $permissionsArray = [];
            foreach ($feature->permission as $permission) {
                $permissionsArray[] = [
                    'permission_id' => $permission->id,
                    'permission_name' => $permission->name,
                ];
            }
        
            $featuresWithPermissions[$feature->id] = [
                'feature_id' => $feature->id,
                'feature_name' => $feature->name,
                'permissions' => $permissionsArray,
            ];
        }
        return view('roles.create',[
            'features'=>$features,
            'featuresWithPermissions'=>$featuresWithPermissions
        ]);
    }

    public function edit(int $id)
    {   
        $role =  Roles::findOrFail($id)
                ->where('id','=',$id)
                ->select('id')
                ->first();

        $features =DB::table('users AS u')
                ->join('roles_permission AS rp', 'u.role_id', '=', 'rp.role_id')
                ->join('permissions AS p', 'rp.permission_id', '=', 'p.id')
                ->join('features AS f', 'f.id', '=', 'p.feature_id')
                ->join('roles AS r', 'u.role_id', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->select(DB::raw('DISTINCT f.name AS feature_name,u.role_id as role_id, r.name as rolename'))
                ->get();

        $checkedPermissions = Roles::findOrFail($id) 
                            ->permissions()
                            ->pluck('permissions.id')
                            ->toArray();

       // dd($checkedPermissions);
       $feature_permissions = Features::with('permission')
       ->orderBy('id')
       ->get();
   
        $featuresWithPermissions = [];
        
        foreach ($feature_permissions  as $feature) {
            $permissionsArray = [];
            foreach ($feature->permission as $permission) {
                $permissionsArray[] = [
                    'permission_id' => $permission->id,
                    'permission_name' => $permission->name,
                ];
            }
        
            $featuresWithPermissions[$feature->id] = [
                'feature_id' => $feature->id,
                'feature_name' => $feature->name,
                'permissions' => $permissionsArray,
            ];
        }
        
        return view('roles.edit',
                [
                    'features' => $features,
                    'featuresWithPermissions'=>$featuresWithPermissions,
                    'checkedPermissions'=>$checkedPermissions,
                    'role'=>$role
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(Request $request, Roles $roles, int $id)
    {
        if($request->isMethod('post')){
            if(auth()->check()){
                $role = $roles::findOrFail($id);

                $permissions = $request->input('permissions',[]);
                
                $role->permissions()->sync(array_keys($permissions));

                return redirect()->route('roles.index')->with('success','Roles permissions updated successfully!');
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $role) : RedirectResponse
    {
         // $role will contain the ID from the URL
        $roleToDelete = Roles::findOrFail($role); // Find the role by its ID

        // Perform the deletion logic
        $roleToDelete->delete();
        
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }

    
}
