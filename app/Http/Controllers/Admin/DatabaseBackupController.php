<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CaseType;
use App\Model\CourtType;
use App\Model\AllTax;
use App\Model\Invoice;
use App\Model\Expense;
use App\Model\Dump;
use App\Model\sqlBackup;
use Validator;
use App\Traits\DatatablTrait;
use Session;
use DB;
use App\Helpers\LogActivity;
use Storage;

// use App\Helpers\LogActivity;

class DatabaseBackupController extends Controller
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
        return view('admin.settings.database-backup.database_backup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return response()->json([
            'html' => view('admin.settings.database-backup.database_backup')->render()
        ]);
    }

    public function List(Request $request)
    {


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'created_at',
        );
        
        $totalData = Dump::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = Dump::when($search, function ($query, $search) {
            return $query->whereDate('created_at', '=', date('Y-m-d', strtotime($search)));
        });


        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {


            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            // $row['id'] = $item->id;

            $d = LogActivity::commonDateFromatType() . ' ' . 'h:i';


            $row['date'] = date($d, strtotime($item->created_at));

            $row['action'] = $this->action([
                'download' => route('database-backup.show', $item->id),
                'restore' => route('database-backup.restore', $item->id),
            ]);

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $filename = Dump::findorfail($id)->file_name;
        return response()->download(storage_path("dumps/{$filename}"));
    }

    /**
     * Restore the specified database backup.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $filename = Dump::findorfail($id)->file_name;
        $path = Storage::disk('local')->path('dumps/' . $filename);
        $restore_file = storage_path() . '/dumps/' . $filename;
        $server_name = env("DB_HOST");
        $username = env("DB_DATABASE");
        $password = env("DB_USERNAME");
        $database_name = env("DB_PASSWORD");

        $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";

        exec($cmd);

        Session::flash('success', "Backup Restore Successfully");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
