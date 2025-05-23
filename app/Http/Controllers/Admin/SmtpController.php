<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\State;
use App\Model\Mailsetup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SmtpController extends Controller
{
    // Define the $data property
    protected $data = [];
    public function index()
    {


        //  $user = Auth::guard('admin')->user();  
        // if(! $user->can('mail_setup_edit')){
        //     abort(403, 'Unauthorized action.');
        // }

        
       $user = Auth::guard('admin')->user();  
        if(! $user->can('general_setting_edit')){
            abort(403, 'Unauthorized action.');
        }

        $mailsetup  = Mailsetup::findOrfail(1); 
        $this->data['title'] = 'Mail Setup';
        $this->data['mailsetup'] = $mailsetup;     
    	return view('admin.settings.mail_setup', $this->data);
    }


    public function update(Request $request,$id)
    {
       
        $mailsetup  = Mailsetup::findOrfail($id);
        $mailsetup->mail_email     = $request->email;
        $mailsetup->mail_port      = $request->smtp_port;
        $mailsetup->mail_host      = $request->mail_host;
        $mailsetup->mail_username  = $request->smtp_username;
        $mailsetup->mail_password  = $request->smtp_password;
        $mailsetup->mail_driver  = $request->mail_driver;
        $mailsetup->mail_encryption  = $request->mail_encryption;
        $mailsetup->save();

        Session::flash('success',__('backend.saved_successfully'));
       return redirect()->back();

    }
}
