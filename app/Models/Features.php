<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;

    public function permission()
    {
        return $this->hasMany(Permission::class, 'feature_id');
    }
}
