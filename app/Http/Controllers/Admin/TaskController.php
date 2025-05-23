<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\CourtCase;
use App\Model\TaskMember;
use App\Model\ClientPartiesInvoive;
use App\Traits\DatatablTrait;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\Task;
use Session;
use App\Admin;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
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
        if (! $user->can('task_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.task.task');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::guard('admin')->user();
        if (! $user->can('task_add')) {
            abort(403, 'Unauthorized action.');
        }


        $this->data['users'] = Admin::where('user_type', '=', "User")->where('is_active', 'Yes')->get();


        // $this->data['cases'] = DB::table('court_cases AS case')
        //                 ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
        //                 ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
        //                 ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
        //                 ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
        //                 ->leftJoin('court_types AS t', 't.id', '=', 'case.court_type')
        //                 ->leftJoin('courts AS c', 'c.id', '=', 'case.court')
        //                 ->leftJoin('judges AS j', 'j.id', '=', 'case.judge_type')
        //                 ->select('case.id AS id','case.registration_number AS case_number','case.act','case.priority',
        //                          'case.court_no',
        //                          's.case_status_name','ac.first_name','ac.middle_name','ac.last_name','case.updated_by','ac.id AS advo_client_id','case.is_nb','case.is_active'
        //                         )
        //                 ->where('case.is_active','Yes')
        //                 ->get();

        // dd( $this->data['cases']);



        return view('admin.task.task_create', $this->data);
    }


    public function getCaseDetail($id)
    {

        $t = DB::table('court_cases AS case')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
            ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
            ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
            ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
            ->leftJoin('court_types AS t', 't.id', '=', 'case.court_type')
            ->leftJoin('courts AS c', 'c.id', '=', 'case.court')
            ->leftJoin('judges AS j', 'j.id', '=', 'case.judge_type')
            ->select(
                'case.id AS id',
                'case.registration_number AS case_number',
                'case.act',
                'case.priority',
                'case.court_no',
                's.case_status_name',
                'ac.first_name',
                'ac.middle_name',
                'ac.last_name',
                'case.updated_by',
                'ac.id AS advo_client_id',
                'case.is_nb',
                'case.is_active'
            )
            // ->where('case.is_active','Yes')
            ->where('case.id', $id)
            ->first();

        return $t;
    }
    public function getMembers($id)
    {


        $getTaskMemberArr = TaskMember::where('task_id', $id)->pluck('employee_id');
        // dd( $getTaskMemberArr );
        $getmulti = Admin::whereIn('id', $getTaskMemberArr)->get();

        $con = "<div style='display: flex;''>";
        foreach ($getmulti as $key => $value) {
            $con .= '<div title="' . $value->first_name . ' ' . $value->last_name . '" data-letters="' . ucfirst(substr($value->first_name, 0, 1)) . '"> </div>';
        }
        $con .= "</div>";

        return $con;
    }


    public function TaskList(Request $request)
    {

        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('task_edit');
        $isDelete = $user->can('task_delete');



        $columns = array(
            0 => 'id',
            1 => 'task_subject',
            3 => 'start_date',
            4 => 'end_date',

        );

        $totalData =  DB::table('tasks AS task')->count();
        $totalRec = $totalData;



        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = DB::table('tasks AS task')
            ->when($search, function ($query, $search) {
                return $query->where('task_subject', 'LIKE', "%{$search}%");
            });



        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            $show = route('clients.show', $item->id);

            // $row['id'] = $item->id;
            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $row['task_subject'] = $item->task_subject;
            if ($item->rel_id != 0) {
                $val = $this->getCaseDetail($item->rel_id);

                $case = '<b> ' . $val->first_name . ' ' . $val->middle_name . ' ' . $val->last_name . '</b>
                      <p>Case Number :<b> ' . $val->case_number . '</b></p>';
                $row['case'] = $case;
            } else {

                $row['case'] = "Other";
            }


            $row['start_date'] = date(LogActivity::commonDateFromatType(), strtotime($item->start_date));
            $row['end_date'] = date(LogActivity::commonDateFromatType(), strtotime($item->end_date));

            $row['members'] = $this->getMembers($item->id);

            $taskStatus = $item->project_status;

            $lableColor = '';
            $status = "";

            if ($taskStatus == 'not_started') {
                $status = "Not Started";
                $lableColor = 'label label-primary';
            } elseif ($taskStatus == 'in_progress') {
                $status = "In Progress";
                $lableColor = 'label label-info';
            } elseif ($taskStatus == 'completed') {
                $status = "Completed";
                $lableColor = 'label label-success';
            } elseif ($taskStatus == 'deferred') {
                $status = "Deferred";
                $lableColor = 'label label-danger';
            }

            $row['status'] = "<span class='" . $lableColor . "'>" . $status . "</span>";




            $taskPriority = $item->priority;
            $lableColor = '';


            if ($taskPriority == 'Low') {

                $lableColor = 'label label-primary';
            } elseif ($taskPriority == 'medium') {

                $lableColor = 'label label-info';
            } elseif ($taskPriority == 'high') {

                $lableColor = 'label label-danger';
            } elseif ($taskPriority == 'urgent') {

                $lableColor = 'label label-danger';
            }




            $row['priority'] = "<span class='" . $lableColor . "'>" . $taskPriority . "</span>";

            // $row['status'] ="yiyui";

            if ($isEdit == "1" || $isDelete == "1") {
                $row['action'] = $this->action([

                    'edit' => route('tasks.edit', $item->id),
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('tasks.destroy', $item->id),
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        //
        // dd($request->all());


        $task = new Task();
        if ($request->related == '' || $request->related == 'other') {
            $task->rel_type = 'other';
            $task->rel_id = 0;
        } else {
            $task->rel_type = $request->related;
            $task->rel_id = $request->related_id;
        }

        // $task->project_type_task_id = $project_type_task_id;
        $task->task_subject = $request->task_subject;
        $task->project_status = $request->project_status_id;
        $task->priority = $request->priority;
        $task->start_date = date('Y-m-d', strtotime($request->start_date));
        $task->end_date = date('Y-m-d', strtotime($request->end_date));
        $task->description = $request->task_description;
        $task->save();


        foreach ($request->assigned_to as $key => $value) {
            # Arrary in assigne employee...
            $taskMember = new TaskMember();
            $taskMember->task_id = $task->id;
            $taskMember->employee_id = $value;
            $taskMember->save();
        }

        return redirect()->route('tasks.index')->with('success', __('backend.task_created_successfully'));
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
        $data['single'] = array();
        $data['multiple'] = array();
        $data['client'] = AdvocateClient::find($id);
        // $data['country'] =$this->getCountryName($data['client']->country_id);
        // $data['state'] =$this->getStateName($data['client']->state_id);
        // $data['city'] =$this->getCityName($data['client']->city_id);

        $data['single'] =  ClientPartiesInvoive::where('client_id', $id)->get();

        $clientName = AdvocateClient::findorfail($id);
        $data['name'] = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;


        return view('admin.client.view.client_detail', $data);
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
        if (! $user->can('task_edit')) {
            abort(403, 'Unauthorized action.');
        }


        $this->data['task'] = task::find($id);
        // dd(   $this->data['task']);
        $this->data['users'] = Admin::where('user_type', '=', "User")->get();

        $this->data['cases'] = DB::table('court_cases AS case')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
            ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
            ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
            ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
            ->leftJoin('court_types AS t', 't.id', '=', 'case.court_type')
            ->leftJoin('courts AS c', 'c.id', '=', 'case.court')
            ->leftJoin('judges AS j', 'j.id', '=', 'case.judge_type')
            ->select(
                'case.id AS id',
                'case.registration_number AS case_number',
                'case.act',
                'case.priority',
                'case.court_no',
                's.case_status_name',
                'ac.first_name',
                'ac.middle_name',
                'ac.last_name',
                'case.updated_by',
                'ac.id AS advo_client_id',
                'case.is_nb',
                'case.is_active'
            )
            ->where('case.is_active', 'Yes')
            ->where('case.id', $this->data['task']->rel_id)
            ->get();
        // dd($this->data['cases']);


        $this->data['user_ids'] = array();

        $this->data['user_ids'] = TaskMember::where('task_id', $id)->pluck('employee_id')->toArray();
        // dd( $this->data['user_ids']);

        return view('admin.task.task_edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {


        $task = Task::findorfail($id);
        if ($request->related == '' || $request->related == 'other') {
            $task->rel_type = 'other';
            $task->rel_id = 0;
            $getTaskMember = TaskMember::select('id')->where('task_id', $id)->delete();
        } else {
            $task->rel_type = $request->related;
            $task->rel_id = $request->related_id;
        }

        // $task->project_type_task_id = $project_type_task_id;
        $task->task_subject = $request->task_subject;
        $task->project_status = $request->project_status_id;
        $task->priority = $request->priority;
        $task->start_date = date('Y-m-d', strtotime($request->start_date));
        $task->end_date = date('Y-m-d', strtotime($request->end_date));
        $task->description = $request->task_description;
        $task->save();


        $getTaskMember = TaskMember::select('id')->where('task_id', $id)->delete();

        foreach ($request->assigned_to as $key => $value) {
            # Arrary in assigne employee...
            $taskMember = new TaskMember();
            $taskMember->task_id = $task->id;
            $taskMember->employee_id = $value;
            $taskMember->save();
        }





        return redirect()->route('tasks.index')->with('success', __('backend.task_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $task = Task::find($id);
        $task->delete();

        TaskMember::where('task_id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => __('backend.task_deleted_successfully'),
        ], 200);

        //return redirect()->route('tasks.index')->with('success',"Task deleted successfully.");

    }

    public function changeStatus(Request $request)
    {

        $statuscode = 400;
        $client = AdvocateClient::findOrFail($request->id);
        $client->is_active  = $request->status == 'true' ? 'Yes' : 'No';

        if ($client->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Client status ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function check_client_email_exits(Request $request)
    {
        if ($request->id == "") {
            $count = AdvocateClient::where('email', $request->email)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = AdvocateClient::where('email', '=', $request->email)
                ->where('id', '<>', $request->id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }

    public function caseDetail($id)
    {

        //$advocate_id = $this->getLoginUserId();
        $totalCourtCase  = CourtCase::where('advo_client_id', $id)->count();

        $clientName = AdvocateClient::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = AdvocateClient::find($id);
        return view('admin.client.view.cases_view', ['advo_client_id' => $id, 'name' => $name, 'totalCourtCase' => $totalCourtCase, 'client' => $client]);
    }


    public function accountDetail($id)
    {

        // $advocate_id = $this->getLoginUserId();
        $clientName = AdvocateClient::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = AdvocateClient::find($id);
        return view('admin.client.view.client_account', ['advo_client_id' => $id, 'name' => $name, 'client' => $client]);
    }
}
