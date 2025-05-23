<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\State;
// use Session;
use App\Model\Mailsetup;
use App\Model\sqlBackup;
use App\Admin;
use App\Model\GeneralSettings;
// use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Storage;
use Camroncade\Timezone\Facades\Timezone;
use Illuminate\Support\Facades\DB;
class GeneralSettingController extends Controller
{
    //
    protected $data = [];
    public function index()
    {


       $user = Auth::guard('admin')->user();  
        if(! $user->can('general_setting_edit')){
            abort(403, 'Unauthorized action.');
        }

        //'Asia/Kolkata'
        $this->data['timezone'] = DB::table('zone')->get();
        $GeneralSettings  = GeneralSettings::findOrfail(1); 
        $this->data['title'] = 'Mail Setup';
        $this->data['GeneralSettings'] = $GeneralSettings;   
        $this->data['countrys'] = DB::table('countries')->get();
        $this->data['states']   = DB::table('states')->where('country_id',$GeneralSettings->country)->get();   
        $this->data['citys']   = DB::table('cities')->where('state_id',$GeneralSettings->state)->get();  
    	return view('admin.settings.general_setting', $this->data);
    }

    public function databaseBackup()
    {  
        $backup = Artisan::call('db:backup');
        Session::flash('success',__('backend.database_backup_saved_successfully'));
        return redirect()->back();

    }
    public function update(Request $request,$id)
    {
        $admin=Admin::where('id','1')->first();
        $admin->associated_name =  $request->cmp_name;
        $admin->save();


        $GeneralSettings  = GeneralSettings::findOrfail($id);
        $GeneralSettings->company_name     = $request->cmp_name;
        $GeneralSettings->address      = $request->address;
        $GeneralSettings->country      = $request->country;
        $GeneralSettings->state  = $request->state;
        $GeneralSettings->city  = $request->city_id;
        $GeneralSettings->pincode  = $request->pincode;
        //----------LOGO image--------
        if ($request->hasFile('logo')) {


            if ($GeneralSettings->logo_img != '') {

                $imageUnlink = public_path() . config('constants.LOGO_FOLDER_PATH') . '/' . $GeneralSettings->logo_img;
                if (file_exists($imageUnlink)) {
                    unlink($imageUnlink);
                }
                $GeneralSettings->logo_img = '';
            }

            $image = $request->file('logo');

            $name = time().'_'.rand(1,4).$image->getClientOriginalName();

            $destinationPath = public_path() . config('constants.LOGO_FOLDER_PATH');
            $image->move($destinationPath, $name);
            $GeneralSettings->logo_img=$name;
        }
        //---------------------favicon  Image --------------

        if ($request->hasFile('favicon')) {


            if ($GeneralSettings->favicon_img != '') {

                $imageUnlink = public_path() . config('constants.FAVICON_FOLDER_PATH') . '/' . $GeneralSettings->favicon_img;
                if (file_exists($imageUnlink)) {
                    unlink($imageUnlink);
                }
                $GeneralSettings->favicon_img = '';
            }

            $image = $request->file('favicon');


            $name = time().'_'.rand(1,4).$image->getClientOriginalName();

            $destinationPath = public_path() . config('constants.FAVICON_FOLDER_PATH');
            $image->move($destinationPath, $name);
            $GeneralSettings->favicon_img=$name;
        }

        $GeneralSettings->save();


        Session::flash('success',__('backend.saved_successfully'));
        return redirect()->back();

    }
}
