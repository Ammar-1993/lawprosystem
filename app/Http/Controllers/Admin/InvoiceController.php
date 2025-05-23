<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Model\AdvocateClient;
use App\Model\GeneralSettings;
use App\Model\Invoice;
use App\Model\InvoiceItem;
use App\Model\Service;
use App\Model\InvoiceSetting;
use App\Model\PaymentReceived;
use App\Model\AllTax;
use App\Model\ClientPartiesInvoive;
use App\Helpers\LogActivity;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ActivityNotification;
use Auth;
use PDF;
use Mail;
use App\Traits\DatatablTrait;
use App\Model\Mailsetup;

class InvoiceController extends Controller
{
    use DatatablTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getClientDetailByIdEdit($id)
    {
        // $advocate_id = $this->getLoginUserId();

        $records = DB::table('advocate_clients')
            ->where('id', $id)
            // ->where('advocate_id',$advocate_id)
            ->first();
        $detail = '';
        if (!empty($records)) {

            $detail = '<label class="discount_text">' . __('frontend.billed_to') . '</label><br>';
            if ($records->first_name != '')
                $detail .= '<p  style="color:#333;">' . $records->first_name . ' ' . $records->middle_name . ' ' . $records->last_name . '</p>';
            if ($records->address != '')
                $detail .= '<p style="color:#333;">' . $records->address . '</p>';
            if ($records->email != '')
                $detail .= '<p style="color:#333;">' . $records->email . '</p>';
            if ($records->mobile != '')
                $detail .= '<p style="color:#333;">' . $records->mobile . '</p>';
        }
        return $detail;
    }


    public function getClientDetailById(Request $request)
    {

        // $advocate_id = $this->getLoginUserId();

        $records = DB::table('advocate_clients')
            ->where('id', $request->id)
            // ->where('advocate_id',$advocate_id)
            ->first();
        $detail = '';
        if (!empty($records)) {

            $detail = '<label class="discount_text">' . __('frontend.billed_to') . '</label><br>';
            if ($records->first_name != '')
                $detail .= '<p style="color:#333;">' . $records->first_name . ' ' . $records->middle_name . ' ' . $records->last_name . '</p>';
            if ($records->address != '')
                $detail .= '<p style="color:#333;">' . $records->address . '</p>';
            if ($records->email != '')
                $detail .= '<p style="color:#333;">' . $records->email . '</p>';
            if ($records->mobile != '')
                $detail .= '<p style="color:#333;">' . $records->mobile . '</p>';
        }
        return $detail;
    }

    public function index()
    {
        return view('admin.invoice.invoice');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advocate_id = $this->getLoginUserId();
        $data['client_list'] = AdvocateClient::where('is_active', 'Yes')->where('advocate_id', $advocate_id)->orderBy('first_name', 'asc')->get();
        //generate invoice number
        $data['invoice_no'] = $this->generateInvoice();


        $data['tax_all'] = AllTax::where('is_active', 'Yes')
            ->where(function ($tax) use ($advocate_id) {
                $tax->where('advocate_id', 0)
                    ->orWhere('advocate_id', $advocate_id);
            })->get();


        $thml = '<select class="form-control taxListCustom" name="tax_id_custom[]"><option value="0" taxsepara="" taxrate="0.00">TAX@0(0.00)</option>';
        if (!empty($tax) && count($tax)) {
            foreach ($tax as $key => $value) {
                $thml .= '<option value="' . $value->id . '" taxsepara="' . $value->name . '" taxrate="' . $value->per . '">' . $value->name . '@ ' . $value->per . '</option>';
            }
        }
        $thml .= '</select>';
        $data['tax'] = "'" . $thml . "'";


        return view('admin.invoice.invoice_menu', $data);
    }

    public function CreateInvoiceView($id = "no")
    {


        $user = \Auth::guard('admin')->user();
        if (!$user->can('invoice_add')) {
            abort(403, 'Unauthorized action.');
        }


        // $advocate_id = $this->getLoginUserId();
        $data['client_list'] = AdvocateClient::where('is_active', 'Yes')->orderBy('first_name', 'asc')->get();

        $data['service_lists'] = Service::where('is_active', 'Yes')->orderBy('name', 'asc')->get();

        //generate invoice number
        $data['invoice_no'] = $this->generateInvoice();


        $data['tax'] = AllTax::where('is_active', 'Yes')->get();


        return view('admin.invoice.invoice_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getInvoice_Detail = Invoice::find($request->invoice_id);
        $receiptNo = $this->generateReceiptNo();

        $paymentReceived = new PaymentReceived();
        $paymentReceived->client_id = $getInvoice_Detail->client_id;
        $paymentReceived->invoice_id = $request->invoice_id;
        $paymentReceived->receipt_number = $receiptNo;
        $paymentReceived->amount = $request->amount;

        $paymentReceived->receiving_date = date('Y-m-d H:i:s', strtotime(LogActivity::commonDateFromat($request->receive_date)));
        $paymentReceived->cheque_date = (!empty($request->cheque_date)) ? date('Y-m-d H:i:s', strtotime(LogActivity::commonDateFromat($request->cheque_date))) : null;
        $paymentReceived->payment_type = $request->method;
        $paymentReceived->reference_number = $request->referance_number;
        $paymentReceived->note = $request->note;
        $paymentReceived->payment_received_by = Auth::guard('admin')->user()->id;
        $paymentReceived->save();

        //change status


        $t = DB::table('invoices AS i')
            ->leftJoin('payment_receiveds As p', 'p.invoice_id', '=', 'i.id')
            ->leftJoin('advocate_clients As c', 'c.id', '=', 'i.client_id')
            ->select('i.id', 'p.amount', 'i.inv_date', 'c.first_name')
            ->selectRaw('sum(p.amount) as paidAmount')
            ->selectRaw('i.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
            //->where('i.advocate_id', $advocate_id)
            ->where('i.id', $request->invoice_id)
            ->groupBy('p.invoice_id')
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
            $status = Invoice::find($request->invoice_id);
            $status->inv_status = "Partially Paid";
            $status->save();
        } elseif ($paidAmount >= $dueAmount) {
            $status = Invoice::find($request->invoice_id);
            $status->inv_status = "Paid";
            $status->save();
        }

        echo 'true';
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['invoice_id'] = $id;
        $html = view('admin.invoice.modal_invoice_paid', $data)->render();
        return response()->json(['html' => $html], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $user = \Auth::guard('admin')->user();
        if (!$user->can('invoice_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data['client_list'] = AdvocateClient::orderBy('first_name', 'asc')->get();

        $data['invoice'] = Invoice::with('invoice_iteam')->find($id);
        $data['iteams'] = InvoiceItem::where('invoice_id', $id)->get();
        // dd(   $data['iteams']);
        $data['tax'] = AllTax::all();
        $data['client_detail'] = $this->getClientDetailByIdEdit($data['invoice']->client_id);

        $data['service_lists'] = Service::orderBy('name', 'asc')->get();

        return view('admin.invoice.invoice_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

    public function CreateInvoiceViewDetail($id, $p)
    {

        $data['setting'] = GeneralSettings::where('id', "1")->first();

        $data['invoice'] = Invoice::with('invoice_iteam', 'invoice_client')->find($id);
        $term_condition = InvoiceSetting::where('id', 1)->first();
        $data['myTerm'] = [];
        if ($term_condition->term_condition != "") {
            $data['myTerm'] = explode('##', $term_condition->term_condition);
        }
        if (isset($data['invoice']->invoice_iteam) && count($data['invoice']->invoice_iteam) > 0) {
            foreach ($data['invoice']->invoice_iteam as $key => $value) {

                $data['iteam'][$key]['service_name'] = isset($value->servicesname->name) ? $value->servicesname->name : '';
                $data['iteam'][$key]['custom_items_name'] = $value['item_description'];
                $data['iteam'][$key]['hsn'] = $value['hsn'];
                $data['iteam'][$key]['custom_items_amount'] = $value['item_amount'];
                $data['iteam'][$key]['item_rate'] = $value['item_rate'];
                $data['iteam'][$key]['custom_items_qty'] = $value['iteam_qty'];
            }
        }

        $data['advocate_client'] = AdvocateClient::find($data['invoice']->client_id);
        $data['invoice_no'] = $data['invoice']->invoice_no;


        $data['due_date'] = date('d-m-Y', strtotime(LogActivity::commonDateFromat($data['invoice']->due_date)));
        $data['inv_date'] = date('d-m-Y', strtotime(LogActivity::commonDateFromat($data['invoice']->inv_date)));
        $data['city'] = $this->getCityName($data['advocate_client']->city_id);
        $data['subTotal'] = $data['invoice']->sub_total_amount;
        $data['tax_amount'] = $data['invoice']->tax_amount;
        $data['total_amount'] = $data['invoice']->total_amount;

        $data['json_to_array'] = array();

        $data['total_amount_world'] = $this->getIndianCurrency(round($data['invoice']->total_amount)) . " Only.";

        if ($p == "view") {
            return view('admin.invoice.invoice_view', $data);
        } else if ($p == "print") {
            $pdf = PDF::loadView('pdf.invoice', $data);
            return $pdf->stream();
        } else if ($p == "email") {
            $mailsetup = Mailsetup::findOrfail(1);
            if ($mailsetup->mail_email != '') {
                $pdf = PDF::loadView('pdf.invoice', $data);
                $input['from'] = $mailsetup->mail_email;
                $input['to'] = $data['advocate_client']->email;
                $input['subject'] = "INVOICE" . $data['invoice_no'];
                $input['title'] = "INVOICE" . $data['invoice_no'];
                $input['pdfName'] = $data['invoice_no'] . ".pdf";

                Mail::send(
                    'pdf.invoice',
                    $data,
                    function ($message) use ($pdf, $input) {
                        $message
                            ->from($input['from'], $input['title'])
                            ->subject($input['subject']);
                        $message->to($input['to']);
                        $message->attachData($pdf->output(), $input['pdfName']);
                    }
                );

                Session::flash('success', __('backend.invoice_sent_successfully'));
                return back();
            } else {
                Session::flash('error', __('backend.smtp_not_set_error'));
                return back();
            }
        }
    }


    public function checkClientEmailExits($id)
    {

        $advoClient = AdvocateClient::find($id);
        if ($advoClient->email == "") {
            return false;
        } else {
            return true;
        }
    }

    public function InvoiceList(Request $request)
    {

        $user = \Auth::guard('admin')->user();
        $isEdit = $user->can('invoice_edit');
        $isDelete = $user->can('invoice_delete');


        /*
        |----------------
        | Listing colomns
        |----------------
       */
        $columns = array(
            0 => 'id',
            1 => 'invoice_no',
            2 => 'client_id',
            3 => 'total_amount',
            4 => 'dueAmount',
            5 => 'inv_status',
        );

        $totalData = DB::table('invoices AS i')
            ->where('i.is_active', 'Yes')
            ->count();


        $totalFiltered = $totalData;
        $totalRec = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $terms = DB::table('invoices AS i')
                ->leftJoin('payment_receiveds As p', 'p.invoice_id', '=', 'i.id')
                ->leftJoin('advocate_clients As c', 'c.id', '=', 'i.client_id')
                ->select('i.id AS id', 'p.amount', 'i.inv_date', 'i.due_date', 'c.first_name', 'c.last_name', 'c.middle_name', 'i.invoice_no', 'i.inv_status', 'i.total_amount As total_amount', 'c.id as client_id')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('i.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                ->where('i.is_active', 'Yes')
                ->groupBy('i.invoice_no')
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

            $terms = DB::table('invoices AS i')
                ->leftJoin('payment_receiveds As p', 'p.invoice_id', '=', 'i.id')
                ->leftJoin('advocate_clients As c', 'c.id', '=', 'i.client_id')
                ->select('i.id AS id', 'p.amount', 'i.inv_date', 'i.due_date', 'c.first_name', 'c.last_name', 'c.middle_name', 'i.invoice_no', 'i.inv_status', 'i.total_amount As total_amount', 'c.id as client_id')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('i.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                ->where('i.is_active', 'Yes')
                ->where(function ($quary) use ($search) {
                    $quary->where('i.invoice_no', 'LIKE', "%{$search}%")
                        ->orWhere('c.first_name', 'LIKE', "%{$search}%")
                        ->orWhere('c.last_name', 'LIKE', "%{$search}%")
                        ->orWhere('c.middle_name', 'LIKE', "%{$search}%")
                        ->orWhere('i.total_amount', 'LIKE', "%{$search}%")
                        ->orWhere('i.inv_status', 'LIKE', "%{$search}%");
                })
                ->groupBy('i.invoice_no')
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
                $clientLink = url('admin/client-account-list/' . $term->client_id);
                $action_delete = route('invoice.destroy', $term->id);
                $delete = "<form action='{$action_delete}' method='post' onsubmit ='return  confirmDelete()'>
                {$token}
                            <input name='_method' type='hidden' value='DELETE'>
                            <button class='dropdown-item text-center' type='submit'  style='background: transparent;
    border: none;'><i class='fa fa-trash fa-1x'></i> Delete</button>
                          </form>";

                $showReceipt = '"' . route('invoice.show', $term->id) . '"';
                $showPaymentHistory = '"' . url('admin/show_payment_history/' . $term->id) . '"';
                $msgPayment = '"Payment History"';
                $msg = '"Add Payment"';

                $edit = route('invoice.edit', $term->id);
                $editMsg = '"Edit Invoice"';


                $view = url('admin/create-Invoice-view-detail/' . $term->id . '/view');
                $print = url('admin/create-Invoice-view-detail/' . $term->id . '/print');
                $email = url('admin/create-Invoice-view-detail/' . $term->id . '/email');

                $chk = $this->checkClientEmailExits($term->client_id);

                /**
                 * -/End
                 */

                if ($chk) {
                    $email = "<li style='text-align:left'><a class='dropdown-item' href='{$email}' title='Send invoice in email to client'>&nbsp;&nbsp;<i class='fa fa-envelope'></i> 
                                                        Email</a></li>";
                } else {
                    $email = "<li style='text-align:left'><a class='dropdown-item' href='javascript:void(0);' style='cursor: no-drop;' title='Client don`t have email'>&nbsp;&nbsp;<i class='fa fa-envelope'></i> 
                                                        Email</a></li>";
                }

                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }
                $nestedData['name'] = '<div  style="font-size:15px;"  class="clinthead text-primary"><a  class="title text-primary" href="">' . $term->first_name . " " . $term->middle_name . " " . $term->last_name . '</b></a>&nbsp;</div><p class="currenttittle"><i class="fa fa-calendar-check-o text-success"></i>&nbsp;' . date(LogActivity::commonDateFromatType(), strtotime($term->inv_date)) . '</b></p>';

                $nestedData['total_amount'] = $term->total_amount;
                $nestedData['paid_amount'] = ($term->paidAmount != '') ? $term->paidAmount : '0';

                $nestedData['due_amount'] = '<p class="currenttittle">' . $term->dueAmount . '</p></b><p class="currenttittle text-danger"><i class="fa fa-calendar-times-o"></i> ' . date(LogActivity::commonDateFromatType(), strtotime($term->due_date)) . ' </p></b>';


                $nestedData['invoice_no'] = '<a href="' . $view . '" class="text-primary">' . $term->invoice_no . '</a>';
                $nestedData['status'] = $term->inv_status;


                if ($isEdit == "1" || $isDelete == "1") {

                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-Invoice-view-detail/' . $term->id . '/view'),
                        'edit' => route('invoice.edit', $term->id),
                        'delete' => collect([
                            'id' => $term->id,
                            'action' => route('invoice.destroy', $term->id),
                        ]),
                        'print' => url('admin/create-Invoice-view-detail/' . $term->id . '/print'),

                        'payment_recevie_modal' => collect([
                            'id' => $term->id,
                            'action' => route('invoice.show', $term->id),
                            'target' => '#clientPaymentreceivemodal'
                        ]),
                        'payment_histroy_modal' => collect([
                            'id' => $term->id,
                            'action' => url('admin/show_payment_history/' . $term->id),
                            'target' => '#clientPaymenthistroymodal'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
                } else {
                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-Invoice-view-detail/' . $term->id . '/view'),
                        'print' => url('admin/create-Invoice-view-detail/' . $term->id . '/print'),
                        'payment_histroy_modal' => collect([
                            'id' => $term->id,
                            'action' => url('admin/show_payment_history/' . $term->id),
                            'target' => '#clientPaymenthistroymodal'
                        ]),


                    ]);
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

    public function InvoiceClientList(Request $request)
    {


        $user = \Auth::guard('admin')->user();
        $isEdit = $user->can('invoice_edit');
        $isDelete = $user->can('invoice_delete');

        $client_id = $request->advocate_client_id;
        /*
        |----------------
        | Listing colomns
        |----------------
       */
        $columns = array(
            0 => 'id',
            1 => 'client_id',
            2 => 'total_amount',
            3 => 'due_amount',
            4 => 'inv_status',
        );

        //$advocate_id = $this->getLoginUserId();

        $totalData = DB::table('invoices AS i')
            // ->where('i.advocate_id', $advocate_id)
            ->where('i.client_id', $client_id)
            ->where('i.is_active', 'Yes')
            ->count();

        $totalFiltered = $totalData;
        $totalRec = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $terms = DB::table('invoices AS i')
                ->leftJoin('payment_receiveds As p', 'p.invoice_id', '=', 'i.id')
                ->leftJoin('advocate_clients As c', 'c.id', '=', 'i.client_id')
                ->select('i.id AS id', 'p.amount', 'i.inv_date', 'i.due_date', 'c.first_name', 'c.last_name', 'c.middle_name', 'i.invoice_no', 'i.inv_status', 'i.total_amount As total_amount', 'c.id as client_id')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('i.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                //->where('i.advocate_id', $advocate_id)
                ->where('i.client_id', $client_id)
                ->where('i.is_active', 'Yes')
                ->groupBy('i.invoice_no')
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

            $terms = DB::table('invoices AS i')
                ->leftJoin('payment_receiveds As p', 'p.invoice_id', '=', 'i.id')
                ->leftJoin('advocate_clients As c', 'c.id', '=', 'i.client_id')
                ->select('i.id AS id', 'p.amount', 'i.inv_date', 'i.due_date', 'c.first_name', 'c.last_name', 'c.middle_name', 'i.invoice_no', 'i.inv_status', 'i.total_amount As total_amount', 'c.id as client_id')
                ->selectRaw('sum(p.amount) as paidAmount')
                ->selectRaw('i.total_amount-SUM(ifnull(p.amount, 0)) AS dueAmount')
                // ->where('i.advocate_id', $advocate_id)
                ->where('i.client_id', $client_id)
                ->where('i.is_active', 'Yes')
                ->where(function ($quary) use ($search) {
                    $quary->where('i.invoice_no', 'LIKE', "%{$search}%")
                        ->orWhere('c.first_name', 'LIKE', "%{$search}%")
                        ->orWhere('c.last_name', 'LIKE', "%{$search}%")
                        ->orWhere('c.middle_name', 'LIKE', "%{$search}%")
                        ->orWhere('i.total_amount', 'LIKE', "%{$search}%")
                        ->orWhere('i.inv_status', 'LIKE', "%{$search}%");
                })
                ->groupBy('i.invoice_no')
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
                $clientLink = url('admin/client-account-list/' . $term->client_id);
                $action_delete = route('invoice.destroy', $term->id);
                $delete = "<form action='{$action_delete}' method='post' onsubmit ='return  confirmDelete()'>
                {$token}
                            <input name='_method' type='hidden' value='DELETE'>
                            <button class='dropdown-item text-center' type='submit'  style='background: transparent;
    border: none;'><i class='fa fa-trash fa-1x'></i> Delete</button>
                          </form>";

                $showReceipt = '"' . route('invoice.show', $term->id) . '"';
                $showPaymentHistory = '"' . url('admin/show_payment_history/' . $term->id) . '"';
                $msgPayment = '"Payment History"';
                $msg = '"Add Payment"';

                $edit = route('invoice.edit', $term->id);
                $editMsg = '"Edit Invoice"';


                $view = url('admin/create-Invoice-view-detail/' . $term->id . '/view');
                $print = url('admin/create-Invoice-view-detail/' . $term->id . '/print');
                $email = url('admin/create-Invoice-view-detail/' . $term->id . '/email');

                $chk = $this->checkClientEmailExits($term->client_id);

                /**
                 * -/End
                 */

                if ($chk) {
                    $email = "<li style='text-align:left'><a class='dropdown-item' href='{$email}' title='Send invoice in email to client'>&nbsp;&nbsp;<i class='fa fa-envelope'></i> 
                                                        Email</a></li>";
                } else {
                    $email = "<li style='text-align:left'><a class='dropdown-item' href='javascript:void(0);' style='cursor: no-drop;' title='Client don`t have email'>&nbsp;&nbsp;<i class='fa fa-envelope'></i> 
                                                        Email</a></li>";
                }

                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }
                $nestedData['name'] = '<div  class="clinthead text-primary"><a  class="title text-primary"  style="font-size:15px;"  href="">' . $term->first_name . " " . $term->middle_name . " " . $term->last_name . '</b></a>&nbsp;</div><p class="currenttittle"><i class="fa fa-calendar-check-o text-success"></i>&nbsp;' . date(LogActivity::commonDateFromatType(), strtotime($term->inv_date)) . '</b></p>';

                $nestedData['total_amount'] = $term->total_amount;
                $nestedData['paid_amount'] = ($term->paidAmount != '') ? $term->paidAmount : '0';

                $nestedData['due_amount'] = '<p class="currenttittle"> ' . $term->dueAmount . '</p></b><p class="currenttittle text-danger"><i class="fa fa-calendar-times-o"></i> ' . date(LogActivity::commonDateFromatType(), strtotime($term->due_date)) . ' </p></b>';


                $nestedData['invoice_no'] = '<a href="' . $view . '" class="text-primary">' . $term->invoice_no . '</a>';
                $nestedData['status'] = $term->inv_status;


                if ($isEdit == "1" || $isDelete == "1") {
                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-Invoice-view-detail/' . $term->id . '/view'),
                        'edit' => route('invoice.edit', $term->id),
                        'delete' => collect([
                            'id' => $term->id,
                            'action' => route('invoice.destroy', $term->id),
                        ]),
                        'print' => url('admin/create-Invoice-view-detail/' . $term->id . '/print'),
                        // 'email' =>url('admin/create-Invoice-view-detail/'.$term->id.'/email'),
                        'payment_recevie_modal' => collect([
                            'id' => $term->id,
                            'action' => route('invoice.show', $term->id),
                            'target' => '#clientPaymentreceivemodal'
                        ]),
                        'payment_histroy_modal' => collect([
                            'id' => $term->id,
                            'action' => url('admin/show_payment_history/' . $term->id),
                            'target' => '#clientPaymenthistroymodal'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
                } else {

                    $nestedData['options'] = $this->action([
                        'view' => url('admin/create-Invoice-view-detail/' . $term->id . '/view'),
                        'payment_histroy_modal' => collect([
                            'id' => $term->id,
                            'action' => url('admin/show_payment_history/' . $term->id),
                            'target' => '#clientPaymenthistroymodal'
                        ]),
                        'delete_permission' => $isDelete,
                        'edit_permission' => $isEdit,


                    ]);
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

    public function checkClientEmail(Request $request)
    {
        $client_id = $request->client_id;
        $advoClient = AdvocateClient::find($client_id);
        if ($advoClient->email == "") {
            $json_data = array("success" => false);
        } else {
            $json_data = array("success" => true);
        }
        return response()->json($json_data, 200);
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

    public function getCityName($id)
    {
        $records = DB::table('cities')->where('id', $id)->first();
        if (isset($records) && !empty($records)) {
            return $records->name;
        }
        return "";
    }


    public function invoiceView($id, $tax = "")
    {
        $advocate_id = $this->getLoginUserId();
        $records = AdvocateClient::findOrfail($id);

        $data['email'] = $records->email;


        $detail = '';
        if (!empty($records)) {

            $detail = '<label  class="discount_text">' . __('frontend.billed_to') . '</label><br>';
            if ($records->first_name != '')
                $detail .= '<p style="color:#333;">' . $records->first_name . ' ' . $records->middle_name . ' ' . $records->last_name . '</p>';
            if ($records->address != '')
                $detail .= '<p style="color:black;">' . $records->address . '</p>';
            if ($records->email != '')
                $detail .= '<p style="color:black;">' . $records->email . '</p>';
            if ($records->mobile != '')
                $detail .= '<p style="color:black;">' . $records->mobile . '</p>';
        }
        $data['client_detail'] = $detail;


        //generate invoice number
        $data['invoice_no'] = $this->generateInvoice();

        $taxs = AllTax::where('is_active', 'Yes')->where('name', $tax)
            ->where(function ($tax) use ($advocate_id) {
                $tax->where('advocate_id', 0)
                    ->orWhere('advocate_id', $advocate_id);
            })->get();


        $thml = '<option value="0" taxsepara="" taxrate="0.00">' . $tax . ' 0 %</option>';
        if (!empty($taxs) && count($taxs)) {
            foreach ($taxs as $key => $value) {
                $thml .= '<option value="' . $value->id . '" taxsepara="' . $value->name . '" taxrate="' . $value->per . '">' . $value->name . ' ' . $value->per . ' %</option>';
            }
        }

        $data['tax'] = "'" . $thml . "'";


        return view('admin.invoice.add_invoice', $data);
    }

    public function storeInvoice(Request $request)
    {
        // dd($request->all());

        if (empty($request->invoice_items)) {
            Session::flash('error', "Something want wrong.");
            return back();
        }

        $this->validate($request, [
            'client_id' => 'required',
            'inc_Date' => 'required',
            'due_Date' => 'required',
            // 'group.*.custom_items_name' => 'required',
            // 'group.*.custom_items_qty' => 'required|numeric',
            // 'group.*.custom_items_rate' => 'required|numeric',
            // 'group.*.custom_items_amount' => 'required|numeric',
        ]);

        // $advocate_id = $this->getLoginUserId();

        $check = $this->check_invoice_exits("", $request->invoice_id);
        if ($check == "false") {
            Session::flash('error', "Faild to data");
            return redirect()->route('invoice.index');
        }


        $invoice = new Invoice;
        $invoice->advocate_id = "1";
        $invoice->client_id = $request->client_id;
        $invoice->sub_total_amount = $request->subTotal;
        $invoice->tax_amount = $request->taxVal;
        $invoice->total_amount = $request->total;
        $invoice->due_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->due_Date)));
        $invoice->inv_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->inc_Date)));


        $invoice->remarks = $request->note;
        $invoice->invoice_no = $request->invoice_id;
        // $invoice->invoice_created_by = "1";
        $invoice->invoice_created_by = Auth::guard('admin')->user()->id;
        $invoice->tax_type = $request->tex_type;
        // $invoice->json_content = $request->jsonContent;
        $invoice->tax_id = $request->tax;
        $invoice->save();

        //increment count of invoice setting
        $setting = InvoiceSetting::where('id', "1")->first();
        $setting->invoice_no = $setting->invoice_no + 1;
        $setting->save();


        $resp = array();

        if (!empty($request->invoice_items) && count($request->invoice_items) > 0) {
            foreach ($request->invoice_items as $key => $value) {
                $iteams = new InvoiceItem();
                $iteams->client_id = $request->client_id;
                $iteams->advocate_id = "1";
                $iteams->invoice_id = $invoice->id;
                $iteams->item_description = $value['description'];
                // $iteams->hsn = $value['hsn'];
                $iteams->service_id = $value['services'];
                $iteams->item_rate = $value['rate'];
                $iteams->iteam_qty = $value['qty'];
                $iteams->item_amount = $value['amount'];
                $iteams->save();
            }
        }

        Session::flash('success', __('backend.invoice_generated_successfully'));

        return redirect()->route('invoice.index');
    }


    public function sendMail($id)
    {

        $data['invoice'] = Invoice::with('invoice_iteam', 'invoice_client')->find($id);

        if (isset($data['invoice']->invoice_iteam) && count($data['invoice']->invoice_iteam) > 0) {
            foreach ($data['invoice']->invoice_iteam as $key => $value) {
                $data['iteam'][$key]['custom_items_name'] = $value['item_description'];
                $data['iteam'][$key]['hsn'] = $value['hsn'];
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


        $data['advocate_client'] = AdvocateClient::find($data['invoice']->client_id);
        $data['invoice_no'] = $data['invoice']->invoice_no;
        $data['due_date'] = date('d-m-Y', strtotime($data['invoice']->due_date));
        $data['inv_date'] = date('d-m-Y', strtotime($data['invoice']->inv_date));
        $data['city'] = $this->getCityName($data['advocate_client']->city_id);
        $data['subTotal'] = $data['invoice']->sub_total_amount;
        $data['tax_amount'] = $data['invoice']->tax_amount;
        $data['total_amount'] = $data['invoice']->total_amount;

        $term_condition = InvoiceSetting::where('advocate_id', $data['advocate_client']->advocate_id)->first();

        $data['myTerm'] = [];
        if ($term_condition->term_condition != "") {
            $data['myTerm'] = explode('##', $term_condition->term_condition);
        }
        $data['json_to_array'] = array();

        // for gst
        if ($data['invoice']->tax_type == "GST" || $data['invoice']->tax_type == "IGST") {
            $data['json_to_array'] = json_decode($data['invoice']->json_content, true);
        }
        $data['tax_type'] = $data['invoice']->tax_type;


        $data['total_amount_world'] = $this->getIndianCurrency($data['invoice']->total_amount) . " Only.";


        $pdf = PDF::loadView('pdf.invoice', $data);

        $input['from'] = "care@advocatesdiary.in";
        $input['to'] = $data['advocate_client']->email;
        $input['subject'] = "INVOICE " . $data['invoice_no'];
        $input['title'] = "INVOICE " . $data['invoice_no'];
        $input['pdfName'] = $data['invoice_no'] . ".pdf";
        Mail::send(
            'pdf.invoice',
            $data,
            function ($message) use ($pdf, $input) {
                $message
                    ->from($input['from'], $input['title'])
                    ->subject($input['subject']);
                $message->to($input['to']);
                $message->attachData($pdf->output(), $input['pdfName']);
                // $message->attach($pdf->output());

            }
        );
    }


    public function editInvoice(Request $request)
    {
        // dd($request->all());


        $this->validate($request, [
            'client_id' => 'required',
            'inc_Date' => 'required',
            'due_Date' => 'required',
            // 'group.*.custom_items_name' => 'required',
            // 'group.*.custom_items_qty' => 'required|numeric',
            // 'group.*.custom_items_rate' => 'required|numeric',
            // 'group.*.custom_items_amount' => 'required|numeric',
        ]);

        $check = $this->check_invoice_exits($request->invoice_id, $request->invoice_id);
        if ($check == "false") {
            Session::flash('error', "Faild to data");
            return redirect()->route('invoice.index');
        }


        $invoice = Invoice::find($request->invoice_id);
        $invoice->sub_total_amount = $request->subTotal;
        $invoice->client_id = $request->client_id;
        $invoice->tax_amount = $request->taxTotal;
        $invoice->total_amount = $request->total;
        // $invoice->due_date = date('Y-m-d',strtotime($request->due_Date));
        // $invoice->inv_date =  date('Y-m-d',strtotime($request->inc_Date));

        $invoice->due_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->due_Date)));
        $invoice->inv_date = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->inc_Date)));
        $invoice->remarks = $request->note;
        // $invoice->invoice_created_by = Auth::guard('admin')->user()->id;
        // $invoice->invoice_created_by = "";
        $invoice->tax_amount = $request->taxVal;
        $invoice->tax_id = $request->tax;
        $invoice->save();


        if (!empty($request->invoice_items) && count($request->invoice_items) > 0) {
            $idsarray = collect($request->invoice_items)->pluck('id')->toArray();
            $ids = array_filter($idsarray);

            if (!empty($ids) && count($ids) > 0) {
                $getIdes = InvoiceItem::where('invoice_id', $request->invoice_id)->whereNotIn('id', $ids)->delete();
            }
        }
        // dd($request->invoice_items);
        // dd($request->invoice_items);


        if (!empty($request->invoice_items) && count($request->invoice_items) > 0) {
            foreach ($request->invoice_items as $key => $value) {

                if (isset($value['id']) && !empty($value['id'])) {

                    $iteams = InvoiceItem::find($value['id']);
                } else {
                    $iteams = new InvoiceItem();
                }

                $iteams->client_id = $request->client_id;
                $iteams->advocate_id = "1";
                $iteams->invoice_id = $invoice->id;
                $iteams->item_description = $value['description'];
                // $iteams->hsn = $value['hsn'];
                $iteams->service_id = $value['services'];
                $iteams->item_rate = $value['rate'];
                $iteams->iteam_qty = $value['qty'];
                $iteams->item_amount = $value['amount'];
                $iteams->save();
            }
        }


        Session::flash('success', __('backend.invoice_updated_successfully'));
        return redirect()->route('invoice.index');
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

    public function calculateDiscountPrice($p, $d)
    {
        if ($d == "") {
            $d = 0;
        }
        $discount = ($d * $p) / 100;
        $result = $p - $discount;
        return round($result);
    }

    public function generateInvoice()
    {


        // $advocate_id = $this->getLoginUserId();
        $data['setting'] = InvoiceSetting::where('advocate_id', 1)->first();

        if (empty($data['setting'])) {
            $inv = new InvoiceSetting();
            $inv->advocate_id = '1';
            $inv->prefix = "INV-";
            $inv->save();
        }

        return $this->addPrefix();
    }

    public function generateReceiptNo()
    {

        // $advocate_id = $this->getLoginUserId();
        // $setting=InvoiceSetting::where('advocate_id',$advocate_id)->first();
        $setting = InvoiceSetting::find(1);


        $receipt = $setting->receipt_no + 1;
        return $receipt;
    }


    public function addPrefix()
    {
        // $advocate_id = $this->getLoginUserId();
        $setting = InvoiceSetting::where('advocate_id', "1")->first();

        $inv = $setting->invoice_no + 1;

        $inv = $my_val = str_pad($inv, 6, '0', STR_PAD_LEFT);


        $prefix = "";
        $prefix = $setting->prefix;

        $for = "";
        if ($setting->invoice_formet == 1) {
            $for = $prefix . $inv;
        } else if ($setting->invoice_formet == 2) {
            $for = $prefix . date('Y') . '/' . $inv;
        } else if ($setting->invoice_formet == 3) {
            $for = $prefix . $inv . '-' . date('y');
        } else if ($setting->invoice_formet == 4) {
            $for = $prefix . $inv . '/' . date('m') . '/' . date('y');
        }
        return $for;
    }

    public function paymentHistory($inv_id = null)
    {

        $data['getPaymentHistory'] = DB::table('payment_receiveds AS pr')
            ->leftJoin('invoices AS inv', 'pr.invoice_id', '=', 'inv.id')
            ->where('pr.invoice_id', $inv_id)
            ->orderby('pr.id', 'DESC')
            ->get();
        // return view('admin.invoice.payment-history',$data);

        $html = view('admin.invoice.payment-history', $data)->render();
        return response()->json(['html' => $html], 200);
    }

    public function billHistory($pr_id = null)
    {
        $advocate_id = $this->getLoginUserId();
        $data['getPaymentHistory'] = DB::table('payment_receiveds AS pr')
            ->leftJoin('invoices AS inv', 'pr.invoice_id', '=', 'inv.id')
            ->where('pr.advocate_id', $advocate_id)
            ->where('pr.id', $pr_id)
            ->orderby('pr.id', 'DESC')
            ->get();
        return view('admin.invoice.payment-history', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->is_active = 'No';
        $invoice->save();
        return response()->json([
            'success' => true,
            'message' => __('backend.invoice_deleted_successfully')
        ], 200);
        // Session::flash('success',"Invoice deleted successfully.");
        // return redirect()->route('invoice.index');

    }


    public function check_invoice_exits($id, $data)
    {
        // $advocate_id   = $this->getLoginUserId();
        if ($id == "") {
            $count = Invoice::where('invoice_no', $data)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = Invoice::where('invoice_no', '=', $data)
                ->where('id', '<>', $id)
                // ->where('advocate_id',$advocate_id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }


    function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
}
