<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolesPermission extends Model
{
    use HasFactory;
    protected $table = 'roles_permission';
    protected $fillable = ['role_id', 'permission_id'];
    public $timestamps = false; 

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
