<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {


       
       

        $supportedLocales = ['en', 'ar'];
        $sessionLocale = Session::get('locale', config('app.locale'));

        if (in_array($sessionLocale, $supportedLocales)) {
            App::setLocale($sessionLocale);
        }

        $direction = ($sessionLocale == 'ar') ? 'rtl' : 'ltr';

        View::share('current_locale', $sessionLocale);
        View::share('dir', $direction);

      
 

        return $next($request);
    }
}



