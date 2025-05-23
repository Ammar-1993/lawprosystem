<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAppointment;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\Appointment;
use Session;
use DB;
use App\Helpers\LogActivity;
use App\Notifications\ActivityNotification;
use Illuminate\Support\Facades\Notification;
use App\Admin;
use App\Traits\DatatablTrait;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
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
        if (!$user->can('appointment_list')) {
            abort(403, 'Unauthorized action.');
        }


        return view('admin.appointment.appointment');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('appointment_add')) {
            abort(403, 'Unauthorized action.');
        }


        $data['client_list'] = AdvocateClient::where('is_active', 'Yes')->get();


        return view('admin.appointment.appointment_create', $data);
    }


    public function getMobileno(Request $request)
    {

        $data = AdvocateClient::findorfail($request->id);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointment $request)
    {
        // dd($request->all());


        $appoint = new Appointment();
        if ($request->type == "new") {
            $appoint->name = $request->new_client;
        } else {
            $appoint->client_id = $request->exists_client;
        }
        // $advocate_id = $this->getLoginUserId();
        $appoint->mobile = $request->mobile;
        $appoint->date = date('Y-m-d H:i:s', strtotime(LogActivity::commonDateFromat($request->date)));

        $appoint->time = date('H:i:s', strtotime($request->time));
        $appoint->note = $request->note;
        $appoint->type = $request->type;
        $appoint->advocate_id = 1;

        $appoint->save();


        return redirect()->route('appointment.index')->with('success', __('backend.appointment_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function appointmentList(Request $request)
    {


        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('appointment_edit');

        /*
          |----------------
          | Listing colomns
          |----------------
         */
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'date',
            3 => 'time',
            4 => 'mobile',
            5 => 'is_active',
            6 => 'action',
        );


        $totalData = DB::table('appointments AS a')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'a.client_id')
            ->select('a.id AS id', 'a.is_active AS status', 'a.mobile AS mobile', 'a.date AS date', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type')
            ->count();
        $totalRec = $totalData;
        // $totalData = DB::table('appointments')->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $terms = DB::table('appointments AS a')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'a.client_id')
            ->select('a.id AS id', 'a.is_active AS status', 'a.mobile AS mobile', 'a.date AS date', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type', 'a.time AS time')
            ->when($request->input('appoint_date_from'), function ($query, $iterm) {
                $iterm = LogActivity::commonDateFromat($iterm);
                return $query->whereDate('a.date', '>=', date('Y-m-d', strtotime($iterm)));
            })
            ->when($request->input('appoint_date_to'), function ($query, $iterm) {
                $iterm = LogActivity::commonDateFromat($iterm);
                return $query->whereDate('a.date', '<=', date('Y-m-d', strtotime($iterm)));
            })
            ->where(function ($query) use ($search) {
                return $query->where('a.mobile', 'LIKE', "%{$search}%")
                    ->orWhere('a.name', 'LIKE', "%{$search}%")
                    ->orWhere('ac.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('ac.last_name', 'LIKE', "%{$search}%")
                    ->orWhere('a.is_active', 'LIKE', "%{$search}%")
                    ->orWhereRaw("concat(ac.first_name, ' ', ac.last_name) like '%{$search}%' ");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();


        /*
          |--------------------------------------------
          | For table search filter from frontend site inside two table namely courses and courseterms.
          |--------------------------------------------
         */

        /*
          |----------------------------------------------------------------------------------------------------------------------------------
          | Creating json array with all records based on input from front end site like all,searcheded,pagination record (i.e 10,20,50,100).
          |----------------------------------------------------------------------------------------------------------------------------------
         */

        $totalFiltered = $terms->count();

        $data = array();
        if (!empty($terms)) {

            foreach ($terms as $term) {

                /**
                 * For HTMl action option like edit and delete
                 */
                $edit = route('appointment.edit', $term->id);
                $token = csrf_field();

                // $action_delete = '"'.route('sale-Admin.destroy', $cat->id).'"';
                $action_delete = route('appointment.destroy', $term->id);

                $delete = "<form action='{$action_delete}' method='post' onsubmit ='return  confirmDelete()'>
                {$token}
                            <input name='_method' type='hidden' value='DELETE'>
                            <button class='dropdown-item text-center' type='submit'  style='background: transparent;
    border: none;'>DELETE</button>
                          </form>";

                /**
                 * -/End
                 */


                $con = '<select name="status" class="appointment-select2" id="status" onchange="change_status(' . "'" . $term->id . "'" . ',' . 'getval(this)' . ',' . "'" . 'appointments' . "'" . ')">';


                //for open status
                $con .= "<option value='OPEN'";
                if ($term->status == 'OPEN') {
                    $con .= "selected";
                }
                $con .= ">OPEN</option>";

                //for CANCEL BY CLIENT status

                $con .= "<option value='CANCEL BY CLIENT'";
                if ($term->status == 'CANCEL BY CLIENT') {
                    $con .= "selected";
                }
                $con .= ">CANCEL BY CLIENT</option>";


                //for CANCEL BY ADVOCATE status
                $con .= "<option value='CANCEL BY ADVOCATE'";
                if ($term->status == 'CANCEL BY ADVOCATE') {
                    $con .= "selected";
                }
                $con .= ">CANCEL BY ADVOCATE</option>";


                $con .= "</select>";


                if ($isEdit == "1") {
                    $nestedData['is_active'] = $con;
                } else {
                    $nestedData['is_active'] = "";
                }

                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }
                $nestedData['date'] = date(LogActivity::commonDateFromatType(), strtotime($term->date));
                $nestedData['time'] = date('g:i a', strtotime($term->time));


                $nestedData['mobile'] = $term->mobile;
                if ($term->type == "new") {
                    $nestedData['name'] = $term->appointment_name;
                } else {
                    $nestedData['name'] = $term->first_name . ' ' . $term->last_name;
                }


                if ($isEdit == "1") {
                    $nestedData['action'] = $this->action([
                        'edit' => route('appointment.edit', $term->id),
                        'edit_permission' => $isEdit,

                    ]);
                } else {
                    $nestedData['action'] = [];
                }

                $data[] = $nestedData;
            }
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = Auth::guard('admin')->user();
        if (!$user->can('appointment_edit')) {
            abort(403, 'Unauthorized action.');
        }
        // $advocate_id = $this->getLoginUserId();
        $data['client_list'] = AdvocateClient::where('is_active', 'Yes')->get();
        $data['appointment'] = Appointment::find($id);
        // dd($data);
        return view('admin.appointment.appointment_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAppointment $request, $id)
    {
        //dd($id);


        $appoint = Appointment::find($id);

        if ($request->type == "new") {
            $appoint->name = $request->new_client;
        } else {
            $appoint->client_id = $request->exists_client;
        }
        $appoint->mobile = $request->mobile;
        $appoint->date = date('Y-m-d H:i', strtotime(LogActivity::commonDateFromat($request->date)));
        $appoint->time = date('H:i:s', strtotime($request->time));
        $appoint->note = $request->note;
        $appoint->type = $request->type;

        $appoint->save();


        return redirect()->route('appointment.index')->with('success', __('backend.appointment_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
