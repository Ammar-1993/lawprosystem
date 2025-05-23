<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CaseType;
use App\Model\CourtType;
use App\Model\Court;
use App\Model\CourtCase;
// use Validator;
use App\Traits\DatatablTrait;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;

class CourtTypeController extends Controller
{
        use DatatablTrait;
	public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $user = Auth::guard('admin')->user();  
        if(! $user->can('court_type_list')){
            abort(403, 'Unauthorized action.');
        }
        return view('admin.settings.court-type.court_type');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

                return response()->json([
                    'html' =>  view('admin.settings.court-type.caset_type_create')->render()
                ]);
    }

    public function courtTypeList(Request $request) {

         $user = Auth::guard('admin')->user();  
         $isEdit=$user->can('court_type_edit');
         $isDelete=$user->can('court_type_delete');

      
              // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'court_type_name',
            2 => 'is_active',
        );


        $totalData = DB::table('court_types')->count();
        $totalRec = $totalData;


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = DB::table('court_types')
                            ->when($search, function ($query, $search) {
                            return $query->where('court_type_name', 'LIKE', "%{$search}%");
                        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            // $row['id'] = $item->id;

         if (empty($request->input('search.value'))) {
                    $final = $totalRec-$start;
                    $row['id'] = $final;
                    $totalRec--;
                }else{
                    $start++;
                    $row['id'] = $start;
                }


            $row['type'] = $item->court_type_name;

        if($isEdit=="1"){
            $row['is_active'] = $this->status($item->is_active,$item->id , route('court.type.courttype.status')) ;
        }else{
             $row['is_active'] =[];

        }


     if($isEdit=="1" || $isDelete=="1"){
            $row['action'] = $this->action([
                'edit_modal' => collect([
                    'id' => $item->id,
                    'action' => route('court-type.edit', $item->id),
                    'target' => '#addtag'
                ]),
                'edit_permission' => $isEdit,
                'delete' => collect([
                    'id' => $item->id,
                    'action' => route('court-type.destroy', $item->id),
                ]),
             'delete_permission' => $isDelete,
            ]);
        }else{
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
        $validator = Validator::make($request->all(),[
            'court_name'   => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $data = new CourtType();
        $data->advocate_id     = "1";
        $data->court_type_name  = $request->court_name;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => __('backend.court_type_added_successfully'),

        ],200);

        
     
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
         $data['court']= CourtType::findorfail($id);
         return response()->json([
                    'html' =>  view('admin.settings.court-type.court_type_edit',$data)->render()
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
            'court_name'   => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $data = CourtType::findorfail($id);
        $data->advocate_id     = "1";
        $data->court_type_name  = $request->court_name;
        $data->save();


          return response()->json([
            'success' => true,
            'message' => __('backend.court_type_updated_successfully'),

        ],200);

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

         public function changeStatus(Request $request) {
            // dd($request->all());
       
       $statuscode = 400;
       $data = CourtType::findOrFail($request->id);
       $data->is_active  = $request->status == 'true' ? 'Yes' : 'No' ;
        
        if($data->save()) {
            $statuscode = 200 ;
        }
        $status = $request->status == 'Yes' ? 'Yes' : 'No' ;
        $message = __('backend.court_type_status_changed_successfully') ;

        return response()->json([
            'success' => true ,
            'message' => $message
        ],$statuscode);

    }

    public function destroy($id)
    {
        $count = 0;
        $count+=CourtCase::where('court_type',$id)->count();
        $count+=Court::where('court_type_id',$id)->count();

        if($count==0){
        $row = CourtType::destroy($id);

          return response()->json([
                       'success' => true ,
                       'message' => __('backend.court_type_deleted_successfully')
                       ],200);

        }else{

                  return response()->json([
                       'error' => true ,
                       'errormessage' => __('backend.cannot_delete_court_type_used')
                       ],400);
        }
    }
}
