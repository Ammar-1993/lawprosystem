<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\CourtCase;
use App\Model\CaseType;
use App\Model\CaseStatus;
use App\Model\Judge;
use App\Model\Court;
use App\Model\CaseLog;
use App\Model\Appointment;
use App\Model\GeneralSettings;
use App\Model\CourtType;
use Validator;
use DB;
use PDF;
use App\Admin;
use App\Helpers\LogActivity;
use Carbon\Carbon;

class DashBordController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function getcases($court, $judge_type, $startDate, $endDate)
  {

    // $advocate_id = $this->getLoginUserId();
    $totalData = DB::table('court_cases AS case')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
      ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
      ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
      ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
      ->leftJoin('court_types AS t', 't.id', '=', 'case.court_type')
      ->leftJoin('courts AS c', 'c.id', '=', 'case.court')
      ->leftJoin('judges AS j', 'j.id', '=', 'case.judge_type')
      ->select(
        'case.id AS case_id',
        'case.next_date',
        'case.client_position',
        'case.party_name',
        'case.party_lawyer',
        'case.case_number',
        'case.act',
        'case.priority',
        'case.court_no',
        'case.judge_name',
        'ct.case_type_name AS caseType',
        'cst.case_type_name AS caseSubType',
        's.case_status_name',
        't.court_type_name',
        'c.court_name',
        'j.judge_name',
        'ac.first_name',
        'ac.middle_name',
        'ac.last_name'
      )
      // ->where('case.advocate_id',$advocate_id)
      ->where('case.is_active', 'Yes')
      ->where('case.is_nb', 'No')
      ->where('case.court', $court)
      ->where('case.judge_type', $judge_type)
      //->whereDate('case.next_date', '>=',$startDate)
      // ->whereDate('case.next_date', '<=', $endDate)
      ->orderBy('case.id', 'desc')
      ->get()->groupBy('court')->toArray();
    return array_shift($totalData);
  }
  public function getcasesByIds($court, $judge_type, $date)
  {

    // $advocate_id = $this->getLoginUserId();

    $checkTask = LogActivity::CheckuserType();

    $totalData = DB::table('court_cases AS case')
      ->leftJoin('case_logs AS cl', 'cl.court_case_id', '=', 'case.id')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
      ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
      ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
      ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
      ->select(
        'case.id AS case_id',
        'cl.bussiness_on_date',
        'cl.hearing_date',
        'case.client_position',
        'case.party_name',
        'case.party_lawyer',
        'case.registration_number',
        'case.act',
        'case.priority',
        'case.court_no',
        'case.judge_name',
        'ct.case_type_name AS caseType',
        'cst.case_type_name AS caseSubType',
        's.case_status_name',
        'ac.first_name',
        'ac.middle_name',
        'ac.last_name'
      )
      // ->where('case.advocate_id',$advocate_id)
      ->where('case.is_active', 'Yes')
      ->where('case.is_nb', 'No')
      ->where('cl.bussiness_on_date', $date)
      ->where('cl.judge_type', $judge_type)
      ->when($checkTask['type'] == "User", function ($query) use ($checkTask) {
        $query->leftJoin('case_members AS cm', 'cm.case_id', '=', 'case.id');
        $query->where('cm.employee_id', $checkTask['id']);
        return $query;
      })
      ->distinct()
      ->get()->toArray();
    return $totalData;
  }
  public function index(Request $request)
  {

    $checkTask = LogActivity::CheckuserType();
    //filter by date
    $date = date('Y-m-d');
    $data['date'] = $date;


    if (isset($request->client_case) && !empty($request->client_case)) {

      $date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->client_case)));
      $data['date'] = $date;
    }



    //get login user id

    // dd(  $advocate_id);
    $casesCount = DB::table('court_cases AS case')
      ->leftJoin('case_logs AS cl', 'cl.court_case_id', '=', 'case.id')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
      ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
      ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
      ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
      ->select(
        'case.id AS case_id',
        'cl.bussiness_on_date',
        'cl.hearing_date',
        'case.client_position',
        'case.party_name',
        'case.party_lawyer',
        'case.registration_number',
        'case.act',
        'case.priority',
        'case.court_no',
        'case.judge_name',
        'ct.case_type_name AS caseType',
        'cst.case_type_name AS caseSubType',
        's.case_status_name',
        'ac.first_name',
        'ac.middle_name',
        'ac.last_name'
      )
      // ->where('case.advocate_id',$advocate_id)
      ->where('case.is_active', 'Yes')
      ->where('case.is_nb', 'No')
      ->where('cl.bussiness_on_date', $date)
      ->when($checkTask['type'] == "User", function ($query) use ($checkTask) {
        $query->leftJoin('case_members AS cm', 'cm.case_id', '=', 'case.id');
        $query->where('cm.employee_id', $checkTask['id']);
        return $query;
      })
      ->distinct()
      ->get()->toArray();


    $data['totalCaseCount'] = count($casesCount);


    $totalData = DB::table('case_logs AS cl')
      ->Join('judges AS j', 'j.id', '=', 'cl.judge_type')
      ->Join('court_cases AS case', 'case.id', '=', 'cl.court_case_id')
      ->where('case.is_nb', 'No')

      ->select('cl.judge_type', 'j.judge_name')

      ->whereDate('cl.bussiness_on_date', '>=', $date)
      ->whereDate('cl.bussiness_on_date', '<=', $date)
      ->when($checkTask['type'] == "User", function ($query) use ($checkTask) {
        $query->leftJoin('case_members AS cm', 'cm.case_id', '=', 'case.id');
        $query->where('cm.employee_id', $checkTask['id']);
        return $query;
      })
      ->distinct()
      ->get();

    $res = array();
    if (count($totalData) > 0 && !empty($totalData)) {
      $arrCourt = $totalData;


      foreach ($arrCourt as $key => $case_detail) {

        //$date = '2018-10-20';
        $court_case_ids = DB::table('case_logs AS cl')
          ->where('judge_type', $case_detail->judge_type)
          ->where('bussiness_on_date', $date)

          ->pluck('court_case_id')
          ->toArray();


        if (!empty($this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date))) {
          $res[$key]['judge_name'] = $case_detail->judge_name;
          $res[$key]['cases']     = $this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date);
        }
      }
    }


    $data['case_dashbord'] = $res;

    //user and its case counts
    $data['client'] = AdvocateClient::count();
    $data['appointmentCount'] = Appointment::count();
    $data['important_case'] = CourtCase::where('priority', 'High')->where('is_active', 'Yes')->count();


    $data['case_total'] = DB::table('court_cases AS case')
      ->where('is_active', 'Yes')
      ->when($checkTask['type'] == "User", function ($query) use ($checkTask) {
        $query->leftJoin('case_members AS cm', 'cm.case_id', '=', 'case.id');
        $query->where('cm.employee_id', $checkTask['id']);
        return $query;
      })
      ->count();
    $data['archived_total'] = CourtCase::where('is_active', 'No')->count();




    $getAppointment = DB::table('appointments AS a')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'a.client_id')
      ->select('a.id AS id', 'a.is_active AS status', 'a.date AS date', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type')

      ->where('a.is_active', 'OPEN')
      ->where('a.date', date('Y-m-d'))
      ->get();
    $data['appoint_calander'] = $getAppointment;


    $data['caseTypes'] = CaseType::where('parent_id', 0)->where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();
    $data['caseStatuses'] = CaseStatus::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();
    $data['courtTypes'] = CourtType::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();
    $data['judges'] = Judge::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();






    return view('admin.index', $data);
  }

  public function ajaxCalander(Request $request)
  {

    $checkTask = LogActivity::CheckuserType();


    $CourtCase = DB::table('case_logs AS cl')
      ->join('court_cases AS case', 'cl.court_case_id', '=', 'case.id')
      ->select('case.id as id', 'case.filing_number as title', 'cl.bussiness_on_date as start')
      ->when($checkTask['type'] == "User", function ($query) use ($checkTask) {
        $query->Join('case_members AS cm', 'cm.case_id', '=', 'case.id');
        $query->where('cm.employee_id', $checkTask['id']);
        return $query;
      })
      ->whereMonth('cl.bussiness_on_date', $request->start)
      ->whereYear('cl.bussiness_on_date', $request->end)
      ->orWhereYear('cl.bussiness_on_date', $request->start)
      ->orWhereYear('cl.bussiness_on_date', $request->end)
      ->get();

    if (!empty($CourtCase)) {
      foreach ($CourtCase as &$value1) {
        $value1->color = '#27c24c';
        $value1->refer = "case";
        $value1->start = date('Y-m-d', strtotime($value1->start));
      }
    }
    // dd($CourtCase);





    //calander
    $appointment = Appointment::select('client_id', 'type', 'id', 'name AS title', 'created_at as color', DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as start'))
      ->where('is_active', 'OPEN')
      ->whereMonth('date', $request->start)
      ->whereYear('date', $request->end)
      ->orWhereYear('date', $request->start)
      ->orWhereYear('date', $request->end)
      ->get();

    if (!empty($appointment)) {

      foreach ($appointment as &$value) {
        if ($value->type == "exists") {
          $client = AdvocateClient::where('id', $value->client_id)->first();

          $value->title = $client->first_name . ' ' . $client->last_name;
        }
        $value->refer = "appointment";
        $value->color = '#f05050';

        unset($value->client_id);
        unset($value->type);
      }
    }








    $CourtCase = collect($CourtCase)->toArray();
    $appointment = collect($appointment)->toArray();
    // dd($CourtCase,$appointment);
    $merg = array_merge($CourtCase, $appointment);



    return collect($merg)->ToJson();
  }


  public function downloadCaseBoard($date)
  {
    $data['setting']    = GeneralSettings::where('id', "1")->first();

    //filter by date
    $date = $date;
    $data['date'] = $date;
    if (isset($date) && !empty($date)) {
      $date = date('Y-m-d', strtotime($date));
      $data['date'] = $date;
    }
    //get login user id
    $data['associatedName']    = Admin::select('associated_name')->first();
    $casesCount = DB::table('court_cases AS case')
      ->leftJoin('case_logs AS cl', 'cl.court_case_id', '=', 'case.id')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
      ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
      ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
      ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
      ->select(
        'case.id AS case_id',
        'cl.bussiness_on_date',
        'cl.hearing_date',
        'case.client_position',
        'case.party_name',
        'case.party_lawyer',
        'case.registration_number',
        'case.act',
        'case.priority',
        'case.court_no',
        'case.judge_name',
        'ct.case_type_name AS caseType',
        'cst.case_type_name AS caseSubType',
        's.case_status_name',
        'ac.first_name',
        'ac.middle_name',
        'ac.last_name'
      )
      ->where('case.is_active', 'Yes')
      ->where('case.is_nb', 'No')
      ->where('cl.bussiness_on_date', $date)
      ->distinct()
      ->get()->toArray();
    $data['totalCaseCount'] = count($casesCount);
    $totalData = DB::table('case_logs AS cl')
      ->Join('judges AS j', 'j.id', '=', 'cl.judge_type')
      ->Join('court_cases AS case', 'case.id', '=', 'cl.court_case_id')
      ->where('case.is_nb', 'No')
      ->select('cl.judge_type', 'j.judge_name')
      ->whereDate('cl.bussiness_on_date', '>=', $date)
      ->whereDate('cl.bussiness_on_date', '<=', $date)
      ->distinct()
      ->get();

    $res = array();
    if (count($totalData) > 0 && !empty($totalData)) {
      $arrCourt = $totalData;
      foreach ($arrCourt as $key => $case_detail) {
        $court_case_ids = CaseLog::where('judge_type', $case_detail->judge_type)->where('bussiness_on_date', $date)->pluck('court_case_id')->toArray();
        if (!empty($this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date))) {
          $res[$key]['judge_name'] = $case_detail->judge_name;
          $res[$key]['caseCourt']  = count($this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date));
          $res[$key]['cases'] = $this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date);
        }
      }
    }
    $data['case_dashbord'] = $res;
    //dd($data['case_dashbord']);
    //pdf download
    $pdf = PDF::loadView('pdf.case-board', $data);
    $filename = 'Case Board Of-' . $date . ".pdf";
    return $pdf->download($filename);
  }


  public function printCaseBoard($date)
  {

    //filter by date
    $date = $date;
    $data['date'] = $date;
    if (isset($date) && !empty($date)) {
      $date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($date)));


      $data['date'] = $date;
    }
    //get login user id

    $data['setting']    = GeneralSettings::where('id', "1")->first();

    $data['associatedName']    = Admin::select('associated_name')->where('id', "1")->first();

    $casesCount = DB::table('court_cases AS case')
      ->leftJoin('case_logs AS cl', 'cl.court_case_id', '=', 'case.id')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
      ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
      ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
      ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
      ->select(
        'case.id AS case_id',
        'cl.bussiness_on_date',
        'cl.hearing_date',
        'case.client_position',
        'case.party_name',
        'case.party_lawyer',
        'case.registration_number',
        'case.act',
        'case.priority',
        'case.court_no',
        'case.judge_name',
        'ct.case_type_name AS caseType',
        'cst.case_type_name AS caseSubType',
        's.case_status_name',
        'ac.first_name',
        'ac.middle_name',
        'ac.last_name'
      )

      ->where('case.is_active', 'Yes')
      ->where('case.is_nb', 'No')
      ->where('cl.bussiness_on_date', $date)
      ->distinct()
      ->get()->toArray();
    $data['totalCaseCount'] = count($casesCount);

    $totalData = DB::table('case_logs AS cl')
      ->Join('judges AS j', 'j.id', '=', 'cl.judge_type')
      ->Join('court_cases AS case', 'case.id', '=', 'cl.court_case_id')
      ->where('case.is_nb', 'No')

      ->select('cl.judge_type', 'j.judge_name')
      ->whereDate('cl.bussiness_on_date', '>=', $date)
      ->whereDate('cl.bussiness_on_date', '<=', $date)
      ->distinct()
      ->get();

    $res = array();
    if (count($totalData) > 0 && !empty($totalData)) {
      $arrCourt = $totalData;
      foreach ($arrCourt as $key => $case_detail) {
        $court_case_ids = CaseLog::where('judge_type', $case_detail->judge_type)->where('bussiness_on_date', $date)->pluck('court_case_id')->toArray();
        if (!empty($this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date))) {
          $res[$key]['judge_name'] = $case_detail->judge_name;
          $res[$key]['caseCourt']  = count($this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date));
          $res[$key]['cases'] = $this->getcasesByIds($court_case_ids, $case_detail->judge_type, $date);
        }
      }
    }
    $data['case_dashbord'] = $res;

    //pdf download
    $pdf = PDF::loadView('pdf.case-board', $data);
    return $pdf->stream();
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
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
  }

  public function appointmentList(Request $request)
  {

    $date = date('Y-m-d');
    if (isset($request->appoint_date) && !empty($request->appoint_date)) {
      $date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->appoint_date)));
    }


    $columns = array(
      0 => 'id',
      1 => 'name',
      2 => 'date',
      2 => 'time',
    );


    $totalData = DB::table('appointments AS a')
      ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'a.client_id')
      ->select('a.id AS id', 'a.is_active AS status', 'a.mobile AS mobile', 'a.date AS date', 'a.time AS app_time', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type')
      ->whereDate('date', '>=', $date)
      ->whereDate('date', '<=', $date)
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
      ->select('a.id AS id', 'a.is_active AS status', 'a.mobile AS mobile', 'a.date AS date', 'a.time AS app_time', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type')
      ->whereDate('date', '>=', $date)
      ->whereDate('date', '<=', $date)
      ->where(function ($query) use ($search) {
        return  $query->where('a.mobile', 'LIKE', "%{$search}%")
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

        $nestedData['id'] = $term->id;
        $nestedData['date'] = date(LogActivity::commonDateFromatType(), strtotime($term->date));
        $nestedData['time'] = date('g:i a', strtotime($term->app_time));
        $nestedData['mobile'] = $term->mobile;
        if ($term->type == "new") {
          $nestedData['name'] = $term->appointment_name;
        } else {
          $nestedData['name'] = $term->first_name . ' ' . $term->last_name;
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
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
