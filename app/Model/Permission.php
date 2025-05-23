<?php

namespace App\Model;
use App\Model\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public  function roles() {
		return $this->belongsToMany(Role::class,'permission_role');
    }
}
