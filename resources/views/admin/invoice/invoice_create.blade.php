@extends('admin.layout.app')
@section('title','Invoice Add')
@section('content')

    <!-- We keep the repeater class on the form as expected by the JS -->
    <form class="repeater" id="add_invoice" name="add_invoice" role="form" method="POST" action="{{url('admin/add_invoice')}}" autocomplete="off">
        {{ csrf_field() }}

        <div class="flex items-center justify-between mb-lg">
            <h3 class="text-2xl font-bold text-dark m-0">{{__('frontend.add_invoice')}}</h3>
            <x-action-button variant="primary" href="{{ url('admin/invoice') }}">
                {{__('frontend.back')}}
            </x-action-button>
        </div>

        @if (count($errors) > 0)
            <div class="bg-danger text-white p-md rounded-md mb-lg">
                <strong>{{__('frontend.whoops')}}</strong> {{__('frontend.there_were_some_problems')}}<br><br>
                <ul class="ms-md mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-form-card title="{{__('frontend.invoice')}}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg">
                <!-- Client Info -->
                <div>
                    <label for="client_id" class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.clientf')}} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent client_id" name="client_id" id="client_id" onchange="getClientDetail(this.value);">
                        <option value="">{{__('frontend.select_client')}}</option>
                        @foreach($client_list as $list)
                            <option value="{{ $list->id}}">{{  $list->name}}</option>
                        @endforeach
                    </select>
                    <div class="show_vendor_detail mt-md text-sm text-gray-dark"></div>
                </div>

                <!-- Invoice Details -->
                <div class="bg-gray-50 p-md rounded-md border border-gray-light">
                    <input type="hidden" name="invoice_id" value="{{$invoice_no}}">
                    
                    <div class="flex items-center justify-between mb-sm pb-sm border-b border-gray-light">
                        <span class="text-sm font-semibold text-gray-dark">{{__('frontend.invoice_no')}}</span>
                        <span class="font-bold text-dark">{{ $invoice_no }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-sm pb-sm border-b border-gray-light">
                        <span class="text-sm font-semibold text-gray-dark">{{__('frontend.invoice_date')}} <span class="text-danger">*</span></span>
                        <input type="text" class="w-1/2 px-3 py-1 text-sm border border-gray-light rounded-md bg-white inc_Date text-end" id="inc_Date" name="inc_Date" readonly="">
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-dark">{{__('frontend.invoice_due_date')}} <span class="text-danger">*</span></span>
                        <input type="text" class="w-1/2 px-3 py-1 text-sm border border-gray-light rounded-md bg-white due_Date text-end" id="due_Date" name="due_Date" readonly="">
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="overflow-x-auto mb-lg border border-gray-light rounded-md">
                <table class="w-full text-start text-sm tableInv" id="purchaseInvoice" data-repeater-list="invoice_items">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-3 py-2 text-center">{{__('frontend.service')}} <span class="text-danger">*</span></th>
                            <th class="px-3 py-2 text-center">{{__('frontend.description')}}</th>
                            <th class="px-3 py-2 text-center w-24">{{__('frontend.qty')}} <span class="text-danger">*</span></th>
                            <th class="px-3 py-2 text-center w-32">{{__('frontend.rate')}} <span class="text-danger">*</span></th>
                            <th class="px-3 py-2 text-center w-24 hide with_tax">{{__('frontend.tax')}} (%)</th>
                            <th class="px-3 py-2 text-center w-24 hide with_tax">{{__('frontend.tax')}} (SAR)</th>
                            <th class="px-3 py-2 text-center w-32">{{__('frontend.amount')}}</th>
                            <th class="px-3 py-2 text-center w-16">{{__('frontend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-repeater-item class="border-b border-gray-light last:border-b-0">
                            <td class="p-2">
                                <select class="w-full px-2 py-1 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent sel services" name="services" id="services" data-rule-required="true">
                                    <option MyServiceAmount="0.00" value="">Select Services</option>
                                    @foreach($service_lists as $service)
                                        <option MyServiceAmount="{{ $service->amount }}" value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-2 py-1 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="description" name="description">
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-2 py-1 text-sm text-center border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent qty" id="qty" name="qty" data-rule-required="true" maxlength="8" onkeypress='return isNumber(event)'>
                            </td>
                            <td class="p-2">
                                <input readonly="" type="text" class="w-full px-2 py-1 text-sm text-end border border-gray-light rounded-md bg-gray-50 rate" onkeypress='return isFloatsNumberKey(event)' id="rate" name="rate" data-rule-required="true" maxlength="10">
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-2 py-1 text-sm text-end border border-gray-light rounded-md bg-gray-50 amount" id="amount" name="amount" data-rule-required="true" readonly="">
                            </td>
                            <td class="p-2 text-center">
                                <x-action-button variant="danger" data-repeater-delete type="button" class="py-1 px-2 btn_remove">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </x-action-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mb-lg">
                <x-action-button variant="success" data-repeater-create type="button" class="btn_add_offer">
                    <i class="fa fa-plus me-1" aria-hidden="true"></i> {{__('frontend.add_more')}}
                </x-action-button>
            </div>

            <!-- Notes and Totals -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                <div>
                    <label for="note" class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.note')}}</label>
                    <textarea class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="note" name="note" rows="4"></textarea>
                    <p class="text-danger text-sm mt-sm">* {{__('frontend.mandatory_fields')}}</p>
                </div>

                <!-- Totals Section -->
                <div class="bg-gray-50 p-md rounded-md border border-gray-light">
                    <!-- Note: Original used tab_logic_total ID multiple times, we must preserve it for JS -->
                    <table class="w-full mb-sm" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2 font-semibold text-gray-dark">{{__('frontend.subtotal')}}</th>
                            <td class="text-end py-2 w-1/2">
                                <input type="text" name="subTotal" class="w-full px-3 py-1 text-end border border-gray-light rounded-md bg-white expence-sub-total" id="subTotal" readonly="">
                            </td>
                        </tr>
                    </table>

                    <table class="w-full mb-sm" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2">
                                <select id="tax" class="w-full px-2 py-1 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent tax" name="tax">
                                    <option MyTax="" value="">Select Tax</option>
                                    @foreach($tax as $t)
                                        <option MyTax="{{ $t->per }}" value="{{ $t->id }}">{{ $t->name.' '.$t->per.'%'  }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <td class="text-end py-2 w-1/2 ps-2">
                                <input type="text" value="" name="taxVal" class="w-full px-3 py-1 text-end border border-gray-light rounded-md bg-white expence-sub-total" id="taxVal" readonly="">
                            </td>
                        </tr>
                    </table>

                    <table class="w-full border-t border-gray-light pt-sm" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2 text-lg font-bold text-dark">{{__('frontend.total')}}</th>
                            <td class="text-end py-2 w-1/2">
                                <input type="text" name="total" class="w-full px-3 py-1 text-end text-lg font-bold border-0 bg-transparent text-primary" id="grandTotal" readonly="">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div id="msgemail" class="msgemail-expence mt-sm"></div>

            <x-slot name="footer">
                <x-action-button variant="danger" href="{{ url('admin/invoice') }}">
                    {{__('frontend.cancel')}}
                </x-action-button>
                <x-action-button variant="success" type="submit" name="btn_add_offer" class="btn_add_offer">
                    <i class="fa fa-save me-1" id="show_loader"></i> {{__('frontend.save')}}
                </x-action-button>
            </x-slot>
        </x-form-card>
    </form>

@endsection

@push('js')
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
    <input type="hidden" name="create_invoice_view" id="create_invoice_view" value="{{ url('admin/create-Invoice-view') }}">
    <input type="hidden" name="getClientDetailBy_id" id="getClientDetailBy_id" value="{{ url('admin/getClientDetailById')}}">

    <script src="{{asset('assets/js/invoice/invoice-validation.js')}}"></script>
    <script src="{{asset('assets/admin/js/repeter/repeatercustome.js') }}"></script>
    <script src="{{asset('assets/admin/js/repeter/invoice.js') }}"></script>
@endpush
