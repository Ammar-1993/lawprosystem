<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CaseType;
use App\Model\CaseStatus;
use App\Model\CourtCase;
// use Validator;
use App\Traits\DatatablTrait;
use Session;
use DB;
// use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CaseStatusController extends Controller
{
    use DatatablTrait;
    public function __construct() {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::guard('admin')->user();
        if (! $user->can('case_status_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.settings.case-status.case_status');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'html' =>  view('admin.settings.case-status.case_status_create')->render()
        ]);
    }

    public function caseStatusList(Request $request)
    {

        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('case_status_edit');
        $isDelete = $user->can('case_status_delete');



        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'case_status_name',
            2 => 'is_active',
        );


        $totalData = CaseStatus::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = CaseStatus::when($search, function ($query, $search) {
            return $query->where('case_status_name', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            // $row['id'] = $item->id;

            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $row['case_status_name'] =  $item->case_status_name;

            if ($isEdit == "1") {

                $row['is_active'] = $this->status($item->is_active, $item->id, route('case.status'));
            } else {
                $row['is_active'] = [];
            }



            if ($isEdit == "1" || $isDelete == "1") {
                $row['action'] = $this->action([
                    'edit_modal' => collect([
                        'id' => $item->id,
                        'action' => route('case-status.edit', $item->id),
                        'target' => '#addtag'
                    ]),
                    'edit_permission' => $isEdit,
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('case-status.destroy', $item->id),
                    ]),
                    'delete_permission' => $isDelete,
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
            "data" => $data,
        );

        return response()->json($json_data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'case_status'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = new CaseStatus();
        $casetype->advocate_id     = "1";
        $casetype->case_status_name  = $request->case_status;
        $casetype->save();

        return response()->json([
            'success' => true,
            'message' => __('backend.case_status_added_successfully'),

        ], 200);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $data['CaseStatus'] = CaseStatus::findorfail($id);

        return response()->json([
            'html' =>  view('admin.settings.case-status.case_status_edit', $data)->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'case_status'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = CaseStatus::findorfail($id);
        $casetype->advocate_id     = "1";
        $casetype->case_status_name  = $request->case_status;
        $casetype->save();


        return response()->json([
            'success' => true,
            'message' => __('backend.case_status_updated_successfully'),

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $request)
    {
        // dd($request->all());

        $statuscode = 400;
        $data = CaseStatus::findOrFail($request->id);
        $data->is_active  = $request->status == 'true' ? 'Yes' : 'No';

        if ($data->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'Yes' ? 'Yes' : 'No';
        $message = __('backend.case_status_changed_successfully');

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function destroy($id)
    {


        $count = 0;
        $count += CourtCase::where('case_status', $id)->count();

        if ($count == 0) {
            $row = CaseStatus::destroy($id);

            return response()->json([
                'success' => true,
                'message' => __('backend.case_status_deleted_successfully')
            ], 200);
        } else {

            return response()->json([
                'error' => true,
                'errormessage' => __('backend.cannot_delete_case_status_used')
            ], 400);
        }
    }
}
