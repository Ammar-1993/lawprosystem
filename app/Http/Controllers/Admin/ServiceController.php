<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatablTrait;
use App\Model\Service;
use Session;
use DB;
use App\Model\InvoiceItem;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use DatatablTrait;

    protected $data = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (! $user->can('service_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.service.service');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->json([

            'html' => view('admin.service.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $service = new Service();
        $service->name = $request->name;
        $service->amount = $request->amount;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => __('backend.service_created_successfully'),

        ], 200);
    }
    public function serviceList(Request $request)
    {


        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('service_edit');
        $isDelete = $user->can('service_delete');


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'amount',
            3 => 'is_active',
        );


        $totalData = Service::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $customcollections = Service::when($search, function ($query, $search) {
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
            $row['amount'] =  $item->amount;


            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('service.status'));
            } else {
                $row['is_active'] = [];
            }
            if ($isEdit == "1" || $isDelete == "1") {

                $row['action'] = $this->action([
                    'edit_modal' => collect([
                        'id' => $item->id,
                        'action' => route('service.edit', $item->id),
                        'target' => '#addtag'
                    ]),
                    'edit_permission' => $isEdit,
                    'delete_permission' => $isDelete,
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('service.destroy', $item->id),
                    ]),
                    'edit_permission' => $isEdit,
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
        //
        $this->data['service'] = Service::find($id);
        return response()->json([

            'html' => view('admin.service.edit', $this->data)->render()
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
        //
        $service = Service::find($id);
        $service->name = $request->name;
        $service->amount = $request->amount;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => __('backend.service_updated_successfully'),

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $count = InvoiceItem::where('service_id', $id)->count();
        if ($count == 0) {
            Service::destroy($id);

            return response()->json([
                'success' => true,
                'message' => __('backend.service_deleted_successfully')
            ], 200);
        } else {

            return response()->json([
                'error' => true,
                'errormessage' => __('backend.cannot_delete_service_used')
            ], 400);
        }
    }

    public function changeStatus(Request $request)
    {
        // dd($request->all());

        $statuscode = 400;
        $data = Service::findOrFail($request->id);
        $data->is_active  = $request->status == 'true' ? 'Yes' : 'No';

        if ($data->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'Yes' ? 'Yes' : 'No';
        $message = __('backend.service_status_changed_successfully');

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }
}
