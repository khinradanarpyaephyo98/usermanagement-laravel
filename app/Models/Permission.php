<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; */

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function feature()
    {
        return $this->belongsTo(Features::class, 'feature_id');
    }

    public function role()
    {
        return $this->belongsToMany(Roles::class, 'roles_permission', 'permission_id', 'role_id');
    }
   
}