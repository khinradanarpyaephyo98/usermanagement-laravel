<?php

namespace App\Http\Controllers;

use App\Services\RolesService;
use App\Models\Roles;
use App\Models\Features;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller\getFeatures;
use App\Policies\RolesPolicy;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{

    public function __construct()
    {
       // $this->authorizeResource(Roles::class,'roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        /* 
        dd(Gate::allows('roles.view'));
        $this->authorize('view',new Roles);
        
        */
        
        if (Auth::user()) {    
             
            $this->authorize('view',new Roles);          
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
    
     /**
     * Display the create page.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loginUser = Auth::user();
        //dd($loginUser);
        $this->authorize('create',new Roles);
       
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
  

   public function edit(Roles $role)
   {   
        if (Gate::denies('update', $role)) {
          abort(403);
        }
        if (Auth::user()) {
           //dd(Auth::user());
           $this->authorize('update',$role);
           $features =DB::table('users AS u')
           ->join('roles_permission AS rp', 'u.role_id', '=', 'rp.role_id')
           ->join('permissions AS p', 'rp.permission_id', '=', 'p.id')
           ->join('features AS f', 'f.id', '=', 'p.feature_id')
           ->join('roles AS r', 'u.role_id', '=', 'r.id')
           ->where('u.id', Auth::user()->id)
           ->select(DB::raw('DISTINCT f.name AS feature_name,u.role_id as role_id, r.name as rolename'))
           ->get();
           //dd($features);
           $checkedPermissions = Roles::find($role->getAttributes()['id']) 
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
            
            $role = $roles::findOrFail($id);

            $permissions = $request->input('permissions',[]);
            
            $role->permissions()->sync(array_keys($permissions));

            return redirect()->route('roles.index')->with('success','Roles permissions updated successfully!');
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $role) : RedirectResponse
    {   if (Auth::user()){
        
        $this->authorize('delete',$role);
         // $role will contain the ID from the URL
        $roleToDelete = Roles::findOrFail($role); // Find the role by its ID

        // Perform the deletion logic
        $roleToDelete->delete();
        
        }
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }

    
}
