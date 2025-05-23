<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ExpensesItem;
use App\Model\ExpenseCats;
use App\Model\Expense;
use App\Model\PaymentMade;
use App\Model\Vendor;
use App\Model\AllTax;
use Illuminate\Support\Facades\Validator;
// use Session;
use Illuminate\Support\Facades\DB;
use App\Traits\DatatablTrait;
use App\Helpers\LogActivity;
// use DB;
// use Auth;
use Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    use DatatablTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function accountDetail($id)
    {


        $user = Auth::guard('admin')->user();
        if (!$user->can('expense_list')) {
            abort(403, 'Unauthorized action.');
        }

        $clientName = Vendor::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = Vendor::find($id);
        return view('admin.vendor.vendor_account', ['advo_client_id' => $id, 'name' => $name, 'client' => $client]);
    }

    public function expenseFilterClientList(Request $request)
    {

        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('expense_edit');
        $isDelete = $user->can('expense_delete');


        $vendor_id = $request->advocate_client_id;

        /*
            |----------------
            | Listing colomns
            |----------------
           */
        $columns = array(
            0 => 'expense_id',
            1 => 'invoice_no',
            2 => 'vendor_id',
            3 => 'total_amount',
            4 => 'dueAmount',
            5 => 'inv_date',
            6 => 'inv_status',
        );

        //$advocate_id = $this->getLoginUserId();

        $totalData = DB::table('expenses AS e')
            //->where('e.advocate_id',$advocate_id)
            ->where('e.vendor_id', $vendor_id)
            ->where('e.is_active', 'Yes')
            ->count();

        $totalFiltered = $totalData;
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $terms = DB::table('expenses AS e')
                ->leftJoin('payment_mades As p', 'p.invoice_id', '=', 'e.id')
                ->leftJoin('vendors AS v', 'v.id', '=', 'e.vendor_id')
                ->select('e.id AS expense_id', 'e.invoice_no', 'e.vendor_id', 'v.first_name', 'v.last_name', 'v.middle_name', 'v.company_name', 'e.total_amount AS amount', 'e.inv_date', 'e.inv_status', 'e.due_date')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('e.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                ->where('e.is_active', 'Yes')
                ->where('e.vendor_id', $vendor_id)
                ->groupBy('e.invoice_no')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {

            /*
              |--------------------------------------------
              | For table search filter from frontend site inside two table namely courses and courseterms.
              |--------------------------------------------
             */
            $search = $request->input('search.value');

            $terms = DB::table('expenses AS e')
                ->leftJoin('payment_mades As p', 'p.invoice_id', '=', 'e.id')
                ->leftJoin('vendors AS v', 'v.id', '=', 'e.vendor_id')
                ->select('e.id AS expense_id', 'e.invoice_no', 'e.vendor_id', 'v.first_name', 'v.last_name', 'v.middle_name', 'v.company_name', 'e.total_amount AS amount', 'e.inv_date', 'e.inv_status', 'e.due_date')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('e.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                ->where('e.is_active', 'Yes')
                ->where('e.vendor_id', $vendor_id)
                ->when($search, function ($query, $search) {
                    return $query->where('v.first_name', 'LIKE', "%{$search}%")
                        ->orWhere('e.invoice_no', 'LIKE', "%{$search}%")
                        ->orWhere('e.total_amount', 'LIKE', "%{$search}%")
                        ->orWhere('e.inv_date', 'LIKE', "%{$search}%")
                        ->orWhere('e.inv_status', 'LIKE', "%{$search}%");
                })
                ->groupBy('e.invoice_no')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();


            $totalFiltered = collect($terms)->count();
        }

        $data = array();
        if (!empty($terms)) {
            foreach ($terms as $Key => $term) {

                /**
                 * For HTMl action option like edit and delete
                 */
                $token = csrf_field();
                $action_delete = route('expense.destroy', $term->expense_id);
                $clientLink = '';
                $delete = "<form action='{$action_delete}' method='post' onsubmit ='return  confirmDelete()'>
                {$token}
                            <input name='_method' type='hidden' value='DELETE'>
                            <button class='dropdown-item text-center' type='submit'  style='background: transparent;
    border: none;'><i class='fa fa-trash fa-1x'></i> Delete</button>
                          </form>";


                $edit = route('expense.edit', $term->expense_id);
                $msg = '"Edit Expense"';

                $showReceipt = '"' . route('expense.show', $term->expense_id) . '"';
                $msg = '"Add Payment"';

                $showPaymentHistory = '"' . url('admin/show_payment_made_history/' . $term->expense_id) . '"';
                $msgPayment = '"Payment Made History"';

                $view = url('admin/create-expence-view-detail/' . $term->expense_id . '/view');

                /**
                 * -/End
                 */


                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }

                if ($term->company_name != '') {
                    $name = $term->company_name;
                } elseif ($term->first_name != '') {
                    $name = $term->first_name . ' ' . $term->last_name;
                } else {
                    $name = 'N/A';
                }

                $nestedData['invoice_no'] = '<a href="' . $view . '" class="text-primary">' . $term->invoice_no . '</a>';
                $nestedData['amount'] = $term->amount;
                $nestedData['paidAmount'] = ($term->paidAmount != '') ? $term->paidAmount : '0';
                $nestedData['dueAmount'] = '<p class="currenttittle">' . $term->dueAmount . '</p></b><p class="currenttittle text-danger"><i class="fa fa-calendar-times-o"></i> ' . date(LogActivity::commonDateFromatType(), strtotime($term->due_date)) . ' </p></b>';
                $nestedData['status'] = $term->inv_status;

                if ($isEdit == "1" || $isDelete == "1") {
                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-expence-view-detail/' . $term->expense_id . '/view'),
                        'edit' => route('expense.edit', $term->expense_id),
                        'delete' => collect([
                            'id' => $term->expense_id,
                            'action' => route('expense.destroy', $term->expense_id),
                        ]),
                        'payment_made' => collect([
                            'id' => $term->expense_id,
                            'action' => route('expense.show', $term->expense_id),
                            'target' => '#Paymentmade'
                        ]),
                        'payment_made_history' => collect([
                            'id' => $term->expense_id,
                            'action' => url('admin/show_payment_made_history/' . $term->expense_id),
                            'target' => '#Paymentmadehistory'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
                } else {

                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-expence-view-detail/' . $term->expense_id . '/view'),

                        'payment_made_history' => collect([
                            'id' => $term->expense_id,
                            'action' => url('admin/show_payment_made_history/' . $term->expense_id),
                            'target' => '#Paymentmadehistory'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
                }

                $nestedData['vandor'] = '<h4 class="clinthead text-primary"><a href="' . $clientLink . '">' . $name . '</b></a>&nbsp;</h4><p class="currenttittle"><i class="fa fa-calendar-check-o text-success"></i>&nbsp;' . date('d-m-Y', strtotime($term->inv_date)) . '</b></p>';


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


    public function index()
    {

        //$advocate_id = $this->getLoginUserId();
        $data['category'] = ExpenseCats::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();
        $data['vendors'] = Vendor::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();
        return view('admin.expence.expense', ['title' => config('constants.ADMIN_EXPENSE'), 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}


    public function expenseCreate($id = "no")
    {

        $user = Auth::guard('admin')->user();
        if (!$user->can('expense_add')) {
            abort(403, 'Unauthorized action.');
        }


        $data['category'] = ExpenseCats::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();

        $data['tax'] = AllTax::where('is_active', 'Yes')->get();

        //dd($data['dropCategory']);
        $data['vendors'] = Vendor::where('is_active', 'Yes')->orderBy('created_at', 'desc')->get();
        return view('admin.expence.expense_create', $data);
    }

    public function addExpensePayment(Request $request)
    {


        $getInvoice_Detail = Expense::find($request->expence_id);


        $paymentReceived = new PaymentMade();
        $paymentReceived->vendor_id = $getInvoice_Detail->vendor_id;
        $paymentReceived->invoice_id = $request->expence_id;
        $paymentReceived->amount = $request->amount;
        $paymentReceived->receiving_date = date('Y-m-d H:i:s', strtotime(LogActivity::commonDateFromat($request->receive_date)));
        $paymentReceived->cheque_date = (!empty($request->cheque_date)) ? date('Y-m-d H:i:s', strtotime(LogActivity::commonDateFromat($request->cheque_date))) : null;
        $paymentReceived->payment_type = $request->method;
        $paymentReceived->reference_number = $request->referance_number;
        $paymentReceived->note = $request->note;
        $paymentReceived->payment_received_by = Auth::guard('admin')->user()->id;
        $paymentReceived->save();

        //change status


        $t = DB::table('expenses AS e')
            ->leftJoin('payment_mades As p', 'p.invoice_id', '=', 'e.id')
            ->leftJoin('vendors AS v', 'v.id', '=', 'e.vendor_id')
            ->select('e.id AS expense_id', 'e.invoice_no', 'e.vendor_id', 'e.total_amount AS amount', 'e.inv_date', 'e.inv_status')
            ->selectRaw('sum(p.amount) as paidAmount')
            ->selectRaw('e.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
            ->groupBy('e.invoice_no')
            ->where('e.id', $request->expence_id)
            ->get();
        $paidAmount = 0;
        $dueAmount = 0;
        if (isset($t[0]) && !empty($t[0])) {
            $dueAmount = $t[0]->dueAmount;
            if ($t[0]->paidAmount == null)
                $paidAmount = 0;
        } else {
            $paidAmount = $t[0]->paidAmount;
        }

        if ($paidAmount < $dueAmount) {
            $status = Expense::find($request->expence_id);
            $status->inv_status = "Partially Paid";
            $status->save();
        } elseif ($paidAmount >= $dueAmount) {

            $status = Expense::find($request->expence_id);
            $status->inv_status = "Paid";
            $status->save();
        }


        echo 'true';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (empty($request->group)) {
            Session::flash('error', "Something want wrong.");
            return back();
        }
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'inv_date' => 'required',
            'due_Date' => 'required',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $expense = new Expense();
        $expense->vendor_id = $request->vendor_id;
        $expense->invoice_no = $request->inv_no;
        $expense->sub_total_amount = $request->subTotal;
        $expense->tax_amount = $request->taxVal;
        $expense->total_amount = $request->total;
        $expense->tax_id = $request->tax;
        $expense->due_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->due_Date)));
        $expense->inv_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->inv_date)));


        // $expense->invoice_created_by  = 1;
        $expense->invoice_created_by = Auth::guard('admin')->user()->id;


        $expense->remarks = $request->note;
        $expense->save();
        //Create array from invoice items


        if (!empty($request->group) && count($request->group) > 0) {
            foreach ($request->group as $key => $value) {
                $iteams = new ExpensesItem();
                $iteams->advocate_id = 1;
                $iteams->vendor_id = $request->vendor_id;
                $iteams->invoice_id = $expense->id;
                $iteams->category_id = $value['categories_ids'];
                $iteams->description = $value['description'];
                $iteams->item_amount = $value['amount'];
                $iteams->item_rate = $value['rate'];
                $iteams->iteam_qty = $value['qty'];


                $iteams->save();
            }
        }


        return redirect()->route('expense.index')->with('success', __('backend.expense_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['expence_id'] = $id;
        // return view('admin.expence.modal_expense_paid',$data);
        $html = view('admin.expence.modal_expense_paid', $data)->render();
        return response()->json(['html' => $html], 200);
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
        if (!$user->can('expense_edit')) {
            abort(403, 'Unauthorized action.');
        }
        // $advocate_id = $this->getLoginUserId();
        $data['category'] = ExpenseCats::orderBy('created_at', 'desc')->get();


        // Tax list

        $data['expense'] = Expense::with('expense_iteam')->find($id);


        $data['tax'] = AllTax::where('is_active', 'Yes')->get();

        //$data['tax']=AllTax::where('name',$data['expense']->tax_type)->where('is_active','Yes')->orderBy('created_at','desc')->get();

        $data['vendors'] = Vendor::orderBy('created_at', 'desc')->get();


        $data['vendor_detail'] = $this->getVendorDetailByIdEdit($data['expense']->vendor_id);


        return view('admin.expence.expense_edit', $data);
    }

    public function getVendorDetailByIdEdit($id)
    {
        //$advocate_id = $this->getLoginUserId();

        $records = DB::table('vendors')
            ->where('id', $id)
            //->where('advocate_id',$advocate_id)
            ->first();
        $detail = '';
        if (!empty($records)) {
            if ($records->first_name != '' || $records->company_name != '') {
                if ($records->company_name != '') {
                    $detail .= '<p  style="color:#333">' . $records->company_name . '</p>';
                } elseif ($records->first_name != '') {
                    $detail .= '<p  style="color:#333">' . $records->first_name . ' ' . $records->last_name . '</p>';
                } else {
                    $detail .= 'N/A';
                }
            }
            if ($records->address != '')
                $detail .= '<p style="color:#333">' . $records->address . '</p>';
            if ($records->mobile != '')
                $detail .= '<p style="color:#333">' . $records->mobile . '</p>';
        }
        return $detail;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'vendor' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = Expense::findorfail($id);
        $casetype->cat_id = $request->category;
        $casetype->vendor_id = $request->vendor;
        $casetype->date = date('Y-m-d', strtotime($request->date));
        $casetype->amount = $request->amount;
        $casetype->note = $request->note;
        $casetype->save();
        //activity log
        $redirect_url = $request->fullUrl();
        $activity = "";

        LogActivity::addToLog('update a expense ', $activity, $redirect_url);
        echo 'true';
    }

    public function editExpense(Request $request)
    {


        // dd($request->all());
        if (empty($request->group)) {
            Session::flash('error', "Something want wrong.");
            return back();
        }
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'inv_date' => 'required',
            'due_Date' => 'required',

        ]);


        //$advocate_id = $this->getLoginUserId();

        $expense = Expense::find($request->expense_id);
        $expense->sub_total_amount = $request->subTotal;
        $expense->tax_amount = $request->taxVal;
        $expense->total_amount = $request->total;
        $expense->tax_id = $request->tax;

        $expense->due_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->due_Date)));
        $expense->inv_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->inv_date)));
        $expense->remarks = $request->note;


        $expense->save();


        if (!empty($request->group) && count($request->group) > 0) {
            $idsarray = collect($request->group)->pluck('edit_id')->toArray();
            $ids = array_filter($idsarray);
            if (!empty($ids) && count($ids) > 0) {
                $getIdes = ExpensesItem::where('invoice_id', $request->expense_id)->whereNotIn('id', $ids)->delete();
            }
        }


        if (!empty($request->group) && count($request->group) > 0) {
            foreach ($request->group as $key => $value) {
                if (isset($value['edit_id']) && !empty($value['edit_id'])) {
                    $iteams = ExpensesItem::find($value['edit_id']);
                } else {

                    $iteams = new ExpensesItem();
                }
                //$iteams->advocate_id = $advocate_id;
                $iteams->invoice_id = $expense->id;
                $iteams->vendor_id = $request->vendor_id;
                $iteams->category_id = $value['categories_ids'];
                $iteams->description = $value['description'];
                $iteams->item_amount = $value['amount'];
                $iteams->item_rate = $value['rate'];
                $iteams->iteam_qty = $value['qty'];


                $iteams->save();
            }
        }
        Session::flash('success', __('backend.expense_updated_successfully'));
        return redirect()->route('expense.index');
    }

    public function expenseList(Request $request)
    {

        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('expense_edit');
        $isDelete = $user->can('expense_delete');
        /*
       |----------------
       | Listing colomns
       |----------------
      */
        $columns = array(
            0 => 'expense_id',
            1 => 'invoice_no',
            2 => 'vendor_id',
            3 => 'total_amount',
            4 => 'dueAmount',
            5 => 'inv_date',
            6 => 'inv_status',
        );


        $totalData = DB::table('expenses AS e')
            ->where('e.is_active', 'Yes')
            ->count();

        $totalFiltered = $totalData;
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $terms = DB::table('expenses AS e')
                ->leftJoin('payment_mades As p', 'p.invoice_id', '=', 'e.id')
                ->leftJoin('vendors AS v', 'v.id', '=', 'e.vendor_id')
                ->select('e.id AS expense_id', 'e.invoice_no', 'e.vendor_id', 'v.first_name', 'v.last_name', 'v.middle_name', 'v.company_name', 'e.total_amount AS amount', 'e.inv_date', 'e.inv_status', 'e.due_date')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('e.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                ->where('e.is_active', 'Yes')
                ->groupBy('e.invoice_no')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {

            /*
              |--------------------------------------------
              | For table search filter from frontend site inside two table namely courses and courseterms.
              |--------------------------------------------
             */
            $search = $request->input('search.value');

            $terms = DB::table('expenses AS e')
                ->leftJoin('payment_mades As p', 'p.invoice_id', '=', 'e.id')
                ->leftJoin('vendors AS v', 'v.id', '=', 'e.vendor_id')
                ->select('e.id AS expense_id', 'e.invoice_no', 'e.vendor_id', 'v.first_name', 'v.last_name', 'v.middle_name', 'v.company_name', 'e.total_amount AS amount', 'e.inv_date', 'e.inv_status', 'e.due_date')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('e.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                ->where('e.is_active', 'Yes')
                // ->where('e.advocate_id', $advocate_id)

                ->when($search, function ($query, $search) {
                    return $query->where('v.first_name', 'LIKE', "%{$search}%")
                        ->orWhere('e.invoice_no', 'LIKE', "%{$search}%")
                        ->orWhere('e.total_amount', 'LIKE', "%{$search}%")
                        ->orWhere('e.inv_date', 'LIKE', "%{$search}%")
                        ->orWhere('e.inv_status', 'LIKE', "%{$search}%");
                })
                ->groupBy('e.invoice_no')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();


            $totalFiltered = collect($terms)->count();
        }

        $data = array();
        if (!empty($terms)) {
            foreach ($terms as $Key => $term) {

                /**
                 * For HTMl action option like edit and delete
                 */
                $token = csrf_field();
                $action_delete = route('expense.destroy', $term->expense_id);
                $clientLink = '';
                $delete = "<form action='{$action_delete}' method='post' onsubmit ='return  confirmDelete()'>
                {$token}
                            <input name='_method' type='hidden' value='DELETE'>
                            <button class='dropdown-item text-center' type='submit'  style='background: transparent;
    border: none;'><i class='fa fa-trash fa-1x'></i> Delete</button>
                          </form>";


                $edit = route('expense.edit', $term->expense_id);
                $msg = '"Edit Expense"';

                $showReceipt = '"' . route('expense.show', $term->expense_id) . '"';
                $msg = '"Add Payment"';

                $showPaymentHistory = '"' . url('admin/show_payment_made_history/' . $term->expense_id) . '"';
                $msgPayment = '"Payment Made History"';

                $view = url('admin/create-expence-view-detail/' . $term->expense_id . '/view');
                $vendor_view = url('admin/expense-account-list/' . $term->vendor_id);


                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }

                if ($term->company_name != '') {
                    $name = $term->company_name;
                } elseif ($term->first_name != '') {
                    $name = $term->first_name . ' ' . $term->last_name;
                } else {
                    $name = 'N/A';
                }
                $nestedData['invoice_no'] = '<a href="' . $view . '" class="text-primary">' . $term->invoice_no . '</a>';
                $nestedData['amount'] = $term->amount;
                $nestedData['paidAmount'] = ($term->paidAmount != '') ?  $term->paidAmount : '0';
                $nestedData['dueAmount'] = '<p class="currenttittle"> ' . $term->dueAmount . '</p></b><p class="currenttittle text-danger"><i class="fa fa-calendar-times-o"></i> ' . date(LogActivity::commonDateFromatType(), strtotime($term->due_date)) . ' </p></b>';
                $nestedData['status'] = $term->inv_status;

                if ($isEdit == "1" || $isDelete == "1") {

                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-expence-view-detail/' . $term->expense_id . '/view'),
                        'edit' => route('expense.edit', $term->expense_id),
                        'delete' => collect([
                            'id' => $term->expense_id,
                            'action' => route('expense.destroy', $term->expense_id),
                        ]),
                        'payment_made' => collect([
                            'id' => $term->expense_id,
                            'action' => route('expense.show', $term->expense_id),
                            'target' => '#Paymentmade'
                        ]),
                        'payment_made_history' => collect([
                            'id' => $term->expense_id,
                            'action' => url('admin/show_payment_made_history/' . $term->expense_id),
                            'target' => '#Paymentmadehistory'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
                } else {


                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-expence-view-detail/' . $term->expense_id . '/view'),
                        'edit' => route('expense.edit', $term->expense_id),
                        'delete' => collect([
                            'id' => $term->expense_id,
                            'action' => route('expense.destroy', $term->expense_id),
                        ]),
                        'payment_made_history' => collect([
                            'id' => $term->expense_id,
                            'action' => url('admin/show_payment_made_history/' . $term->expense_id),
                            'target' => '#Paymentmadehistory'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
                }


                $nestedData['vandor'] = '<div class="clinthead text-primary"><a  style="font-size:15px;"  class="title text-primary"  href="' . $vendor_view . '">' . $name . '</b></a>&nbsp;</div><p class="currenttittle"><i class="fa fa-calendar-check-o text-success"></i>&nbsp;' . date(LogActivity::commonDateFromatType(), strtotime($term->inv_date)) . '</b></p>';


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

    public function CreateExpenseViewDetail($id, $p)
    {

        $data['invoice'] = Expense::with('expense_iteam')->find($id);

        if (isset($data['invoice']->expense_iteam) && count($data['invoice']->expense_iteam) > 0) {
            foreach ($data['invoice']->expense_iteam as $key => $value) {
                $data['iteam'][$key]['custom_items_name'] = $value['description'];
                $data['iteam'][$key]['category'] = $this->getCategoryName($value['category_id']);
                $data['iteam'][$key]['custom_items_amount'] = $value['item_amount'];
                $data['iteam'][$key]['item_rate'] = $value['item_rate'];
                $data['iteam'][$key]['tax_id_custom'] = $this->getTax($value['tax_id']);
                $data['iteam'][$key]['custom_items_qty'] = $value['iteam_qty'];

                $taxRate = $this->getTax($value['tax_id']);
                $price = $value['item_rate'] * $value['iteam_qty'];
                $taxAmount = number_format((($price * $taxRate) / 100), 2);
                $data['iteam'][$key]['tax'] = $taxAmount;
            }
        }


        $data['advocate_client'] = Vendor::find($data['invoice']->vendor_id);
        $data['invoice_no'] = $data['invoice']->invoice_no;
        $data['due_date'] = date(LogActivity::commonDateFromatType(), strtotime($data['invoice']->due_date));
        $data['inv_date'] = date(LogActivity::commonDateFromatType(), strtotime($data['invoice']->inv_date));
        $data['city'] = $this->getCityName($data['advocate_client']->city_id);
        $data['subTotal'] = $data['invoice']->sub_total_amount;
        $data['tax_amount'] = $data['invoice']->tax_amount;
        $data['total_amount'] = $data['invoice']->total_amount;

        $data['json_to_array'] = array();

        // for gst
        if ($data['invoice']->tax_type == "GST" || $data['invoice']->tax_type == "IGST") {
            $data['json_to_array'] = json_decode($data['invoice']->json_content, true);
        }

        $data['tax_type'] = $data['invoice']->tax_type;

        if ($p == "view") {
            return view('admin.expence.expense_view', $data);
        }
    }

    public function getCategoryName($id)
    {
        $records = DB::table('expense_cats')->where('id', $id)->first();
        if (isset($records) && !empty($records)) {
            return $records->name;
        }
        return "";
    }

    public function getTax($id)
    {
        $tax = AllTax::where('id', $id)->first();
        $name = "0";
        if (!empty($tax)) {
            $name = $tax->per;
        }

        return $name;
    }

    public function getCityName($id)
    {
        $records = DB::table('cities')->where('id', $id)->first();
        if (isset($records) && !empty($records)) {
            return $records->name;
        }
        return "";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoiceIteam = ExpensesItem::where('invoice_id', $id)->delete();
        $invoice = Expense::find($id);
        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => __('backend.expense_deleted_successfully'),

        ], 200);
    }

    public function getVendorDetailById(Request $request)
    {

        $records = DB::table('vendors')
            ->where('id', $request->id)
            ->first();

        $detail = '';
        if (!empty($records)) {

            if ($records->first_name != '' || $records->company_name) {
                if ($records->company_name != '') {
                    $detail .= '<p  style="color:#333">' . $records->company_name . '</p>';
                } elseif ($records->first_name != '') {
                    $detail .= '<p  style="color:#333">' . $records->first_name . ' ' . $records->last_name . '</p>';
                } else {
                    $detail .= 'N/A';
                }
            }
            if ($records->address != '')
                $detail .= '<p style="color:#333">' . $records->address . '</p>';
            if ($records->mobile != '')
                $detail .= '<p style="color:#333">' . $records->mobile . '</p>';
        }

        return $detail;
    }

    public function paymentMadeHistory($inv_id = null)
    {
        //$advocate_id = $this->getLoginUserId();
        $data['getPaymentHistory'] = DB::table('payment_mades AS pm')
            ->leftJoin('expenses AS exp', 'pm.invoice_id', '=', 'exp.id')
            //->where('pm.advocate_id',$advocate_id)
            ->where('pm.invoice_id', $inv_id)
            ->orderby('pm.id', 'DESC')
            ->get();

        $html = view('admin.expence.payment-made-history', $data)->render();

        return response()->json(['html' => $html], 200);
    }

    public function check_expense_exits(Request $request)
    {
        $advocate_id = $this->getLoginUserId();
        $id = $request->id;
        $data = $request->inv_no;
        if ($id == "") {
            $count = Expense::where('invoice_no', $data)->where('advocate_id', $advocate_id)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = Expense::where('invoice_no', '=', $data)
                ->where('id', '<>', $id)
                ->where('advocate_id', $advocate_id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }
}
