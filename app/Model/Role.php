<?php

namespace App\Model;
use App\Model\Permission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public  function permissions() {
    	return $this->belongsToMany(Permission::class,'permission_role');
    }

}
