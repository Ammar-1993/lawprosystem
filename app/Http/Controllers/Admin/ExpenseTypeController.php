<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CaseType;
use App\Model\CaseStatus;
use App\Model\ExpenseCats;
use App\Model\ExpensesItem;
use App\Model\Judge;
use Illuminate\Support\Facades\Validator;
use App\Traits\DatatablTrait;
use Session;
use DB;
// use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;

class ExpenseTypeController extends Controller
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
        if (! $user->can('expense_type_list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.expence.expense_type');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'html' =>  view('admin.expence.expense_type_create')->render()
        ]);
    }

    public function expenceList(Request $request)
    {


        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('expense_type_edit');
        $isDelete = $user->can('expense_type_delete');


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'is_active',
        );


        $totalData = ExpenseCats::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $customcollections = ExpenseCats::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
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

            $row['name'] =  $item->name;


            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('expense.status'));
            } else {
                $row['is_active'] = [];
            }
            if ($isEdit == "1" || $isDelete == "1") {

                $row['action'] = $this->action([
                    'edit_modal' => collect([
                        'id' => $item->id,
                        'action' => route('expense-type.edit', $item->id),
                        'target' => '#addtag'
                    ]),
                    'edit_permission' => $isEdit,
                    'delete_permission' => $isDelete,
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('expense-type.destroy', $item->id),
                    ])
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
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = new ExpenseCats();
        $casetype->advocate_id  = "1";
        $casetype->name  = $request->name;
        $casetype->description  = $request->description;
        $casetype->save();

        return response()->json([
            'success' => true,
            'message' => __('backend.expense_type_added_successfully'),

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


        $data['expense'] = ExpenseCats::findorfail($id);

        return response()->json([
            'html' =>  view('admin.expence.expense_type_edit', $data)->render()
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
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = ExpenseCats::findorfail($id);
        $casetype->name  = $request->name;
        $casetype->description  = $request->description;
        $casetype->save();



        return response()->json([
            'success' => true,
            'message' => __('backend.expense_type_updated_successfully'),

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
        $data = ExpenseCats::findOrFail($request->id);
        $data->is_active  = $request->status == 'true' ? 'Yes' : 'No';

        if ($data->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'Yes' ? 'Yes' : 'No';
        $message = __('backend.expense_type_status_changed_successfully');

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function destroy($id)
    {

        $count = ExpensesItem::where('category_id', $id)->count();
        if ($count == 0) {
            $row = ExpenseCats::destroy($id);

            return response()->json([
                'success' => true,
                'message' => __('backend.expense_type_deleted_successfully')
            ], 200);
        } else {

            return response()->json([
                'error' => true,
                'errormessage' => __('backend.cannot_delete_vendor_used')
            ], 400);
        }
    }
}
