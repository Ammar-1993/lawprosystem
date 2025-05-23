<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CaseType;
use App\Model\CaseStatus;
use App\Model\CourtCase;
use App\Model\Judge;

use App\Traits\DatatablTrait;
use Session;
use DB;
// use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JudgeController extends Controller
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
        if (! $user->can('judge_list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.settings.judge.judge');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'html' =>  view('admin.settings.judge.judge_create')->render()
        ]);
    }

    public function caseStatusList(Request $request)
    {

        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('judge_edit');
        $isDelete = $user->can('judge_delete');




        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'judge_name',
            2 => 'is_active',
        );


        $totalData = Judge::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $customcollections = Judge::when($search, function ($query, $search) {
            return $query->where('judge_name', 'LIKE', "%{$search}%");
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


            $row['judge_name'] =  $item->judge_name;

            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('judge.status'));
            } else {
                $row['is_active'] = [];
            }

            if ($isEdit == "1" || $isDelete == "1") {

                $row['action'] = $this->action([
                    'edit_modal' => collect([
                        'id' => $item->id,
                        'action' => route('judge.edit', $item->id),
                        'target' => '#addtag'
                    ]),
                    'edit_permission' => $isEdit,
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('judge.destroy', $item->id),
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
            'judge_name'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = new Judge();
        $casetype->advocate_id     = "1";
        $casetype->judge_name  = $request->judge_name;
        $casetype->save();

        return response()->json([
            'success' => true,
            'message' => __('backend.judge_added_successfully'),

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


        $data['judge'] = Judge::findorfail($id);

        return response()->json([
            'html' =>  view('admin.settings.judge.judge_edit', $data)->render()
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
            'judge_name'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = Judge::findorfail($id);
        $casetype->advocate_id     = "1";
        $casetype->judge_name  = $request->judge_name;
        $casetype->save();


        return response()->json([
            'success' => true,
            'message' => __('backend.judge_updated_successfully'),

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
        $data = Judge::findOrFail($request->id);
        $data->is_active  = $request->status == 'true' ? 'Yes' : 'No';

        if ($data->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'Yes' ? 'Yes' : 'No';
        $message = __('backend.judge_status_changed_successfully');

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function destroy($id)
    {

        $count = 0;
        $count += CourtCase::where('judge_type', $id)->count();

        if ($count == 0) {
            $row = Judge::destroy($id);

            return response()->json([
                'success' => true,
                'message' => __('backend.judge_deleted_successfully')
            ], 200);
        } else {

            return response()->json([
                'error' => true,
                'errormessage' => __('backend.cannot_delete_tax_used')
            ], 400);
        }
    }
}
