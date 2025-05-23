<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\State;
// use Session;
use App\Model\Mailsetup;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use App\Model\GeneralSettings;
use Illuminate\Support\Facades\DB;
use Camroncade\Timezone\Facades\Timezone;
use Illuminate\Support\Facades\Session;
class GeneralSettingDateController extends Controller
{
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
    	return view('admin.settings.general_setting_date', $this->data);
    }


    public function update(Request $request,$id)
    {


        $GeneralSettings  = GeneralSettings::findOrfail($id);
     
        $GeneralSettings->date_formet  = $request->forment;
        $GeneralSettings->timezone  = $request->timezone;
      
        $GeneralSettings->save();

        Session::flash('success',__('backend.saved_successfully'));
       return redirect()->back();

    }
}
