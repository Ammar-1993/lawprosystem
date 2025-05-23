<?php
namespace App\Traits;

use App\Model\Permission;
use App\Model\Role;

trait HasPermissionsTrait {

	
	public function hasPermissionTo($permission) {
		// return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
		return $this->hasPermissionThroughRole($permission) ;
	}

	public function hasPermissionThroughRole($permission) {
		foreach ($permission->roles as $role){
			if($this->roles->contains($role)) {
				return true;
			}
		}
		return false;
	}

	public function hasRole( ... $roles ) {
		foreach ($roles as $role) {
			if ($this->roles->contains('slug', $role)) {
				return true;
			}
		}
		return false;
	}

	public function roles() {
		return $this->belongsToMany(Role::class,'admin_role');
	}

	protected function hasPermission($permission) {
		return (bool) $this->permissions->where('slug', $permission->slug)->count();
	}

	protected function getAllPermissions(array $permissions) {
		return Permission::whereIn('slug',$permissions)->get();
	}
}