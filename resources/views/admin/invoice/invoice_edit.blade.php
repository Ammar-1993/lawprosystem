@extends('admin.layout.app')
@section('title', 'Invoice Edit')
@section('content')
    <link href="{{ asset('assets/css/invoice_css.css') }}" rel="stylesheet">

    <form class="repeater" id="add_invoice" name="add_invoice" role="form" method="POST"
        action="{{ url('admin/edit_invoice') }}" autocomplete="off">

        {{ csrf_field() }}
        <div class="page-title">
            <div class="title_left">
                <h3>{{__('frontend.edit_invoice')}}</h3>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">


                    <a href="{{ url('admin/invoice') }}" class="btn btn-primary">{{__('frontend.back')}}</a>


                </div>
            </div>
        </div>
        <div class="x_panel">

            <div class="x_content">

                <section class="content invoice">

                    <div class="row"><br>
                        <div class="col-xs-12 invoice-header" align="center">
                            <h1>{{__('frontend.invoice')}}</h1>
                        </div>


                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>{{__('frontend.whoops')}}</strong>{{__('frontend.there_were_some_problems')}}<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="row invoice-info">
                        <div class="col-sm-4">


                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="vendor">{{__('frontend.clientf')}}<span class="text-danger">*</span></label>
                                    <select class="form-control client_id" name="client_id" id="client_id"
                                        onchange="getClientDetail(this.value);">
                                        <option value="">{{__('frontend.select_client')}}</option>
                                        @foreach ($client_list as $list)
                                            <option value="{{ $list->id }}"
                                                {{ $list->id == $invoice->client_id ? 'selected' : '' }}>{{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="show_vendor_detail"> {!! $client_detail !!}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                        </div>

                        <div class="col-sm-4 form-horizontal form-label-left">
                            <input type="hidden" class="form-control" id="invoice_id" name="invoice_id"
                                value="{{ $invoice->id }}">


                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12">{{__('frontend.invoice_no')}} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7 col-sm-9 col-xs-12">
                                    <div class="invoice-margin-top"><b>{{ $invoice->invoice_no ?? '' }}</b></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12">{{__('frontend.invoice_date')}} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control inc_Date" id="inc_Date" name="inc_Date"
                                        readonly=""
                                        value="{{ date($date_format_laravel, strtotime($invoice->inv_date)) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12">{{__('frontend.invoice_due_date')}} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control due_Date" id="due_Date" name="due_Date"
                                        readonly=""
                                        value="{{ date($date_format_laravel, strtotime($invoice->due_date)) }}">
                                </div>
                            </div>


                        </div>

                    </div>
                    <br><br>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table tableInv" id="purchaseInvoice" data-repeater-list="invoice_items">
                                    <thead class="thead-inverse">
                                        <tr class="tbl_header_color dynamicRows">

                                            <th width="" class="text-center">
                                                {{__('frontend.service')}}
                                                <span class="text-danger">*</span>
                                            </th>
                                            <th width="" class="text-center">
                                                {{__('frontend.description')}}{{__('frontend.description')}}

                                            </th>

                                            <th width="10%" class="text-center">
                                                {{__('frontend.qty')}}
                                                <span class="text-danger">*</span>
                                            </th>
                                            <th width="10%" class="text-center">
                                                {{__('frontend.rate')}}
                                                <span class="text-danger">*</span>
                                            </th>
                                            <th class="hide with_tax" width="15%" class="text-center">{{__('frontend.tax')}} (%)</th>
                                            <th class="hide with_tax" width="10%" class="text-center">{{__('frontend.tax')}} </th>
                                            <th width="10%" class="text-center">{{__('frontend.amount')}}</th>
                                            <th width="5%" class="text-center">{{__('frontend.action')}}</th>
                                        </tr>
                                    </thead>


                                    <tbody>


                                        @foreach ($iteams as $i)
                                            <tr data-repeater-item>


                                                <th width="30%" class="text-center">
                                                    <select class="form-control sel services" name="services"
                                                        id="services" data-rule-required="true">
                                                        <option MyServiceAmount="0.00" value="">Select Services
                                                        </option>
                                                        @foreach ($service_lists as $service)
                                                            <option MyServiceAmount="{{ $service->amount }}"
                                                                @if (isset($i) && $i->service_id == $service->id) selected @endif
                                                                value="{{ $service->id }}">{{ $service->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th width="" class="text-center">

                                                    <input type="hidden" class="form-control" id="id"
                                                        name="id" value="{{ $i->id ?? '' }}">

                                                    <input type="text" class="form-control" id="description"
                                                        name="description" value="{{ $i->item_description ?? '' }}">
                                                </th>

                                                <th width="10%" class="text-center">
                                                    <input type="text" class="form-control qty" id="qty"
                                                        name="qty" value="{{ $i->iteam_qty ?? '' }}"
                                                        data-rule-required="true" maxlength="8"
                                                        onkeypress='return isNumber(event)'>
                                                </th>
                                                <th width="10%" class="text-center">
                                                    <input readonly="" type="text" class="form-control rate"
                                                        onkeypress='return isFloatsNumberKey(event)' id="rate"
                                                        name="rate" data-rule-required="true" maxlength="10"
                                                        value="{{ $i->item_rate ?? '' }}">
                                                </th>

                                                <th width="10%" class="text-center">
                                                    <input type="text" class="form-control amount" id="amount"
                                                        name="amount" data-rule-required="true" readonly=""
                                                        value="{{ $i->item_amount ?? '' }}">
                                                </th>
                                                <th width="5%" class="text-center">

                                                    <button type="button" data-repeater-delete type="button"
                                                        class="btn btn-danger waves-effect waves-light btn_remove"><i
                                                            class="fa fa-trash-o" aria-hidden="true"></i></button>

                                                </th>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                    <br>


                                </table>


                            </div>
                            <br>
                            <button data-repeater-create type="button" value="Add New"
                                class="btn btn-success waves-effect waves-light btn btn-success-edit" type="button">
                                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{{__('frontend.add_more')}}
                            </button>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div>
                                        <p class="text-danger">* {{__('frontend.mandatory_fields')}}</p>
                                        <ul />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 col-md-7">
                                    <div class="contct-info">
                                        <div class="form-group">
                                            <label class="discount_text">{{__('frontend.note')}}
                                            </label>
                                            <textarea class="form-control" id="note" name="note" rows="4">{{ $invoice->remarks ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right col-md-5">
                                    <table class="table row-border dataTable no-footer" id="tab_logic_total">
                                        <tr>
                                            <th class="text-left expence-p-top-18 ">{{__('frontend.subtotal')}}</th>
                                            <td class="text-center total-width-expence">
                                                <input value="{{ $invoice->sub_total_amount ?? '' }}" type="text"
                                                    name="subTotal" class="form-control expence-sub-total "
                                                    id="subTotal" readonly="">
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table row-border dataTable no-footer" id="tab_logic_total">
                                        <tr>
                                            <th class="text-center">
                                                <select id="tax" class="tax" name="tax"
                                                    class="form-control">
                                                    <option MyTax="" value="">Select Tax</option>
                                                    @foreach ($tax as $t)
                                                        <option MyTax="{{ $t->per }}" value="{{ $t->id }}"
                                                            {{ $invoice->tax_id == $t->id ? 'selected' : '' }}>
                                                            {{ $t->name . ' ' . $t->per . '%' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <td class="text-center total-width-expence">
                                                <input type="text" name="taxVal"
                                                    class="form-control expence-sub-total" id="taxVal"
                                                    value="{{ $invoice->tax_amount ?? '' }}" readonly="">
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table row-border dataTable no-footer" id="tab_logic_total">

                                        <tr>
                                            <th class="text-left expence-p-top-18">{{__('frontend.total')}}</th>
                                            <td class="text-center total-width-expence">
                                                <input type="text" name="total"
                                                    class="form-control total-width-expence-border " id="grandTotal"
                                                    readonly="" value="{{ $invoice->total_amount ?? '' }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3 text-center">
                                    <a href="{{ url('admin/invoice') }}" class="btn btn-danger">{{__('frontend.cancel')}}</a>
                                    <button type="submit" name="btn_add_offer" class="btn_add_offer btn btn-success"><i
                                            class="fa fa-save" id="show_loader"></i>&nbsp;{{__('frontend.save')}}
                                    </button>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 pull-right">
                                    <div id="msgemail" class="msgemail-expence"></div>
                                </div>
                            </div>
                            <br>
                            <br>

                        </div>
                    </div>

                </section>
            </div>
        </div>


    </form>

@endsection

@push('js')
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">

    <input type="hidden" name="create_invoice_view" id="create_invoice_view"
        value="{{ url('admin/create-Invoice-view') }}">

    <input type="hidden" name="getClientDetailBy_id" id="getClientDetailBy_id"
        value="{{ url('admin/getClientDetailById') }}">

    <script src="{{ asset('assets/js/invoice/invoice-validation.js') }}"></script>

    <script src="{{ asset('assets/admin/js/repeter/repeatercustome.js') }}"></script>
    <script src="{{ asset('assets/admin/js/repeter/invoice.js') }}"></script>
@endpush
