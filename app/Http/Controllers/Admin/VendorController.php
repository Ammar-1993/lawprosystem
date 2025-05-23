<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVendor;
use App\Model\Vendor;
use App\Traits\DatatablTrait;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\Expense;
use App\Model\AdvocateClient;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    use DatatablTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (! $user->can('vendor_list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.vendor.vendor');
    }
    public function VendorList(Request $request)
    {
        /*
          |----------------
          | Listing colomns
          |----------------
         */

        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('vendor_edit');
        $isDelete = $user->can('vendor_delete');

        $columns = array(
            0 => 'id',
            1 => 'first_name',
            2 => 'mobile',
            3 => 'is_active',
            4 => 'action',
        );

        // $advocate_id = $this->getLoginUserId();
        $totalData = Vendor::count();


        $totalFiltered = $totalData;
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        /*
              |--------------------------------------------
              | For table search filterfrom frontend site.
              |--------------------------------------------
             */
        $search = $request->input('search.value');


        $customcollections = Vendor::when($search, function ($query, $search) {
            return $query->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%");
        });



        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            $show = route('vendor.show', $item->id);

            // $row['id'] = $item->id;
            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $nm = $item->company_name ?? $item->full_name;
            $row['first_name'] = '<a class="title text-primary" href="' . $show . '">' . $nm . '</a>';
            $row['mobile'] = $item->mobile;


            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('vendor.status'));
            } else {
                $row['is_active'] = [];
            }



            if ($isEdit == "1" || $isDelete == "1") {
                $row['action'] = $this->action([
                    'view' => route('vendor.show', $item->id),
                    'edit' => route('vendor.edit', $item->id),
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('vendor.destroy', $item->id),
                    ]),
                    'delete_permission' => $isDelete,
                    'edit_permission' => $isEdit,

                ]);
            } else {
                $row['action'] = [];
            }

            $data[] = $row;
        }


        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        if (! $user->can('vendor_add')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.vendor.vendor_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVendor $request)
    {

        //
        //dd($request->all());
        $AdvocateClient = new Vendor;
        $AdvocateClient->first_name = $request->f_name;
        //$AdvocateClient->middle_name = $request->m_name;
        $AdvocateClient->last_name = $request->l_name;
        $AdvocateClient->company_name = $request->company_name;
        $AdvocateClient->email = $request->email;
        $AdvocateClient->mobile = $request->mobile;
        $AdvocateClient->alternate_no = $request->alternate_no;
        $AdvocateClient->address = $request->address;
        $AdvocateClient->country_id = $request->country;
        $AdvocateClient->state_id = $request->state;
        $AdvocateClient->city_id = $request->city_id;
        //$AdvocateClient->advocate_id = $advocate_id;
        $AdvocateClient->gst = $request->gst;
        $AdvocateClient->pan = $request->pan;
        $AdvocateClient->save();
        return redirect()->route('vendor.index')->with('success',__('backend.vendor_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data['client'] = Vendor::findOrfail($id);

        // $data['country'] =$this->getCountryName($data['client']->country_id);
        //  $data['state'] =$this->getStateName($data['client']->state_id);
        //  $data['city'] =$this->getCityName($data['client']->city_id);

        $clientName = Vendor::findorfail($id);
        $data['name'] = $data['client']->first_name . ' ' . $data['client']->middle_name . ' ' . $data['client']->last_name;

        return view('admin.vendor.vendor_view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        if (! $user->can('vendor_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $data['client'] = Vendor::with('country', 'state', 'city')->find($id);
        return view('admin.vendor.vendor_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVendor $request, $id)
    {
        //

        $AdvocateClient = Vendor::find($id);
        $AdvocateClient->first_name = $request->f_name;
        $AdvocateClient->last_name = $request->l_name;
        $AdvocateClient->company_name = $request->company_name;
        $AdvocateClient->email = $request->email;
        $AdvocateClient->mobile = $request->mobile;
        $AdvocateClient->alternate_no = $request->alternate_no;
        $AdvocateClient->address = $request->address;
        $AdvocateClient->country_id = $request->country;
        $AdvocateClient->state_id = $request->state;
        $AdvocateClient->city_id = $request->city_id;
        $AdvocateClient->gst = $request->gst;
        $AdvocateClient->pan = $request->pan;
        $AdvocateClient->save();
        return redirect()->route('vendor.index')->with('success', __('backend.vendor_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $expenseCount = Expense::where('vendor_id', $id)->count();
        if ($expenseCount == 0) {

            $AdvocateClient = Vendor::find($id);



            $AdvocateClient->delete();

            //Session::flash('success',"Vendor deleted successfully.");
            return response()->json([
                'success' => true,
                'message' => __('backend.vendor_deleted_successfully')
            ], 200);
        } else {
            // dd('yes');
            //Session::flash('error',"You can't delete vendor beacause it is use in other module.");
            $statuscode = 400;
            return response()->json([
                'error' => true,
                'errormessage' => __('backend.cannot_delete_vendor_used')
            ], $statuscode);
        }
        //return redirect()->route('vendor.index');

    }
    public function changeStatus(Request $request)
    {

        $statuscode = 400;
        $client = Vendor::findOrFail($request->id);
        $client->is_active  = $request->status == 'true' ? 'Yes' : 'No';

        if ($client->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Financial status ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function check_client_email_exits(Request $request)
    {
        if ($request->id == "") {
            $count = Vendor::where('email', $request->email)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = Vendor::where('email', '=', $request->email)
                ->where('id', '<>', $request->id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }
}
