<?php

namespace App\Providers;

use App\Model\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use DB;


class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        try {
            DB::connection()->getPdo();
       if (\Schema::hasTable('permissions')) {
            Permission::get()->map(function($permission){
                Gate::define($permission->slug, function($user) use ($permission){            
                    return $user->hasPermissionTo($permission);
                });
            });
        }

       Blade::directive('role', function ($role){
            return "<?php if(auth()->guard('admin')->check() && auth()->guard('admin')->user()->hasRole({$role})) : ?>";
        });
        
        Blade::directive('endrole', function ($role){
            return "<?php endif; ?>";
        });
        } catch (\Exception $e) {

        }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
