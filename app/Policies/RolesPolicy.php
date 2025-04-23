<?php

namespace App\Policies;

use App\Models\Roles;
use App\Models\RolesPermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Roles $role): bool
    {
        return $user->role && $user->role->permissions->contains(function ($permission) {
            return $permission->name === 'view' && $permission->feature_id === 2;
        });
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role && $user->role->permissions->contains(function ($permission) {
            return $permission->name === 'create' && $permission->feature_id === 2;
        });
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Roles $role): bool
    {
     
        $results= RolesPermission::
              join('permissions AS p', 'p.id', '=', 'roles_permission.permission_id')
            ->join('roles AS r','r.id','=','roles_permission.role_id')
            ->join('features AS f', 'f.id','=','p.feature_id')
            ->select('p.name as permission_name', 'f.name as feature_name' )
            ->where('f.id',2)
            ->where('r.id',$user->role->id)
            ->where('p.id',17)
            ->get();
        //dd($results);

        if($results->isEmpty()){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Roles $roles): bool
    {
        $results= RolesPermission::
              join('permissions AS p', 'p.id', '=', 'roles_permission.permission_id')
            ->join('roles AS r','r.id','=','roles_permission.role_id')
            ->join('features AS f', 'f.id','=','p.feature_id')
            ->select('p.name as permission_name', 'f.name as feature_name' )
            ->where('f.id',2)
            ->where('r.id',$user->role->id)
            ->where('p.id',18)
            ->get();
        dd($results);
        if($results->isEmpty()){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Roles $roles): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Roles $roles): bool
    {
        return false;
    }
}
