<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Model\GeneralSettings;
// use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['users'] = Auth::guard('admin')->user();
        return view('admin.profile', $data);
    }

    public function login()
    {
        return view('admin.login');
    }

    public function changePassword()
    {
        return view('admin.change_password');
    }

    public function change_pass()
    {
        return view('admin.change_password');
    }

    public function changedPassword(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'new' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm' => 'required|same:new'
        ]);

        $advocate_id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($advocate_id);

        $current_password = $request->old;
        $password = $request->new;

        if (Hash::check($current_password, $admin->password)) {
            $admin->password = Hash::make($password);
            try {
                $admin->save();
                $flag = TRUE;
            } catch (Exception $e) {
                $flag = FALSE; 
            }
            if ($flag) {
                Session::flash('success', __('backend.password_changed_successfully'));

                return redirect('/admin/admin-profile');
            } else {
                Session::flash('error', __('backend.unable_to_process_request_this_time'));

                return redirect('/admin/admin-profile');

            }
        } else {
            Session::flash('error', __('backend.current_password_do_not_match'));

            return redirect('/admin/admin-profile');
        }

    }

    public function forgot()
    {
        return view('admin.forgot');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    public function editProfile(Request $request)
    {
        $this->validate($request, [
            'f_name' => 'required',
            'l_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city_id' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'zip_code' => 'required',
            'input_img' => 'sometimes|image',
        ]);


        $advocate_id = Auth::guard('admin')->user()->id;
        $client = Admin::find($advocate_id);

        //check folder exits if not exit then creat automatic
        $pathCheck = public_path() . config('constants.CLIENT_FOLDER_PATH');
        if (!file_exists($pathCheck)) {
            File::makeDirectory($pathCheck, $mode = 0777, true, true);
        }

        //remove image
        if ($request->is_remove_image == "Yes" && $request->file('image') == "") {

            if ($client->profile_img != '') {
                $imageUnlink = public_path() . config('constants.CLIENT_FOLDER_PATH') . '/' . $client->profile_img;
                if (file_exists($imageUnlink)) {
                    unlink($imageUnlink);
                }
                $client->profile_img = '';
            }
        }

        //profile image upload
        if ($request->hasFile('image')) {

            if ($client->profile_img != '') {

                $imageUnlink = public_path() . config('constants.CLIENT_FOLDER_PATH') . '/' . $client->profile_img;
                if (file_exists($imageUnlink)) {
                    unlink($imageUnlink);
                }
                $client->profile_img = '';
            }

            $data = $request->imagebase64;

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $image_name = time() . '.png';
            $path = public_path() . "/upload/profile/" . $image_name;
            file_put_contents($path, $data);
            $client->profile_img = $image_name;
        }
        //login user id

        // profile_img
        // $client->advocate_id = "2";
        // $client->is_user_type = "STAFF";
        // $client->is_activated = "1";
        $client->first_name = $request->f_name;
        $client->name = $request->username;
        $client->last_name = $request->l_name;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->registration_no = $request->registration_no;
        $client->associated_name = $request->associated_name;
        $client->zipcode = $request->zip_code;
        $client->address = $request->address;
        $client->country_id = $request->country;
        $client->state_id = $request->state;
        $client->city_id = $request->city_id;
        $client->save();

        $GeneralSettings = GeneralSettings::findOrfail(1);
        $GeneralSettings->company_name = $request->associated_name;
        $GeneralSettings->save();

        return back()->with('success', __('backend.profile_updated_successfully'));
    }

    public function imageCropPost(Request $request)
    {
        $id = $request->id;
        $data = $request->image;
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);

        $data = base64_decode($data);
        $image_name = time() . '.png';
        $path = public_path() . "/upload/profile/" . $image_name;
        file_put_contents($path, $data);
        $client = Admin::find($id);

        if ($client->profile_img != '') {
            $imageUnlink = public_path() . config('constants.CLIENT_FOLDER_PATH') . '/' . $client->profile_img;
            if (file_exists($imageUnlink)) {
                unlink($imageUnlink);
            }
            $client->profile_img = '';
        }
        $client->profile_img = $image_name;
        $client->update();

        return response()->json(['success' => 'done']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
