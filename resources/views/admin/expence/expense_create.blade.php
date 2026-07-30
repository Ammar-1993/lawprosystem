@extends('admin.layout.app')
@section('title', 'Add Expense')
@section('content')
    <form class="repeater" id="add_expense" name="add_expense" role="form" method="POST" action="{{ route('expense.store') }}" autocomplete="off">
        @csrf

        <div class="flex items-center justify-between mb-lg">
            <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.add_expense') }}</h3>
            <x-action-button variant="primary" href="{{ url('admin/expense') }}">
                {{ __('frontend.back') }}
            </x-action-button>
        </div>

        @if (count($errors) > 0)
            <div class="bg-danger text-white p-md rounded-md mb-lg">
                <strong>{{ __('frontend.whoops') }}</strong>{{ __('frontend.there_were_some_problems') }}<br><br>
                <ul class="ms-md mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-form-card title="{{ __('frontend.expense') }}">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl mb-xl pb-lg border-b border-gray-light">
                <!-- Left: Vendor Info -->
                <div>
                    <label for="vendor_id" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.vendor1') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent select2 mb-md" name="vendor_id" id="vendor_id" onchange="getVendorBillingAddress(this.value);" data-rule-required="true">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{$vendor->id}}">
                                @if($vendor->company_name!=''){{$vendor->company_name}}@elseif($vendor->first_name!=''){{$vendor->first_name.' '.$vendor->last_name}}@else 'N/A' @endif
                            </option>
                        @endforeach
                    </select>

                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.billed_from') }}</label>
                    <div class="show_vendor_detail p-md bg-gray-50 rounded-md border border-gray-light min-h-[100px]">
                        <!-- Injected via AJAX -->
                    </div>
                </div>

                <!-- Right: Bill Info -->
                <div class="space-y-md">
                    <div>
                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.bill_no') }}: <span class="text-danger">*</span></label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="inv_no" name="inv_no">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.bill_date') }}: <span class="text-danger">*</span></label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent inc_Date" id="inv_date" name="inv_date">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.bill_due_date') }}: <span class="text-danger">*</span></label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent due_Date" id="due_Date" name="due_Date">
                    </div>
                </div>
            </div>

            <!-- Dynamic Items Table -->
            <div class="overflow-x-auto mb-lg">
                <table class="w-full text-start text-sm text-dark tableInv" id="purchaseInvoice" data-repeater-list="group">
                    <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs dynamicRows">
                        <tr>
                            <th width="30%" class="px-4 py-3">{{ __('frontend.items') }} <span class="text-danger">*</span></th>
                            <th class="px-4 py-3">{{ __('frontend.description') }}</th>
                            <th width="10%" class="px-4 py-3 text-center">{{ __('frontend.qty') }} <span class="text-danger">*</span></th>
                            <th width="10%" class="px-4 py-3 text-center">{{ __('frontend.rate') }} <span class="text-danger">*</span></th>
                            <th width="15%" class="px-4 py-3 text-center hide with_tax">{{ __('frontend.tax') }} (%)</th>
                            <th width="10%" class="px-4 py-3 text-center hide with_tax">{{ __('frontend.tax') }} (SAR)</th>
                            <th width="10%" class="px-4 py-3 text-end">{{ __('frontend.amount') }}</th>
                            <th width="5%" class="px-4 py-3 text-center">{{ __('frontend.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-repeater-item class="border-b border-gray-light">
                            <td class="p-2">
                                <select class="w-full px-3 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent sel categories_ids" name="categories_ids" id="categories_ids" data-rule-required="true">
                                    <option value="">Select Category</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-3 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="description" name="description">
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-3 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent text-center qty" id="qty" name="qty" data-rule-required="true" maxlength="10" onkeypress='return isNumber(event)'>
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-3 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent text-center rate" onkeypress='return isFloatsNumberKey(event)' id="rate" name="rate" data-rule-required="true" maxlength="10">
                            </td>
                            <td class="p-2">
                                <input type="text" class="w-full px-3 py-2 border-transparent bg-transparent text-end font-bold amount" id="amount" name="amount" data-rule-required="true" readonly="">
                            </td>
                            <td class="p-2 text-center">
                                <button type="button" data-repeater-delete class="text-danger hover:text-red-700 bg-transparent border-none cursor-pointer p-2">
                                    <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mb-xl">
                <button data-repeater-create type="button" value="Add New" class="bg-gray-100 hover:bg-gray-200 text-dark font-semibold py-2 px-4 rounded-md transition-colors btn btn-success-edit">
                    <i class="fa fa-plus me-1" aria-hidden="true"></i> {{ __('frontend.add_more') }}
                </button>
            </div>

            <p class="text-sm text-danger mb-lg">* {{ __('frontend.mandatory_fields') }}</p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl">
                <!-- Notes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.note') }}</label>
                    <textarea class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="note" name="note" rows="4"></textarea>
                </div>
                
                <!-- Totals -->
                <div class="bg-gray-50 p-lg rounded-md border border-gray-light">
                    <!-- Note: Multiple table tags with same id "tab_logic_total" is preserved for legacy JS constraints -->
                    <table class="w-full mb-xs" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2 text-dark">{{ __('frontend.subtotal') }}</th>
                            <td class="w-1/2">
                                <input type="text" name="subTotal" class="w-full bg-transparent border-none text-end font-bold text-lg subTotalinv" id="subTotal" readonly="">
                            </td>
                        </tr>
                    </table>

                    <table class="w-full mb-xs" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2">
                                <select id="tax" class="w-full px-3 py-1.5 border border-gray-light rounded-md text-sm tax" name="tax">
                                    <option MyTax="" value="">Select Tax</option>
                                    @foreach($tax as $t)
                                        <option MyTax="{{ $t->per }}" value="{{ $t->id }}">{{ $t->name.' '.$t->per.'%' }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <td class="w-1/2">
                                <input type="text" name="taxVal" class="w-full bg-transparent border-none text-end font-bold text-lg subTotalinv" id="taxVal" readonly="">
                            </td>
                        </tr>
                    </table>

                    <table class="w-full border-t border-gray-300 mt-sm pt-sm" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2 text-xl text-dark">{{ __('frontend.total') }}</th>
                            <td class="w-1/2">
                                <input type="text" name="total" class="w-full bg-transparent border-none text-end font-bold text-2xl text-primary" id="grandTotal" readonly="">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div id="msgemail" class="msgemail-expence mt-4"></div>

            <x-slot name="footer">
                <x-action-button variant="danger" href="{{ url('admin/expense') }}">
                    {{ __('frontend.cancel') }}
                </x-action-button>
                <x-action-button variant="success" type="submit" name="btn_add_offer" class="btn_add_offer">
                    <i class="fa fa-save me-1" id="show_loader"></i> {{ __('frontend.save') }}
                </x-action-button>
            </x-slot>
        </x-form-card>
    </form>

    <input type="hidden" name="expense_create" id="expense_create" value="{{ url('admin/expense-create') }}">
    <input type="hidden" name="getVendorDetailById" id="getVendorDetailById" value="{{ url('admin/getVendorDetailById')}}">
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{$date_format_datepiker}}">

@endsection

@push('js')
    <script src="{{ asset('assets/js/expense/expense-validation.js') }}"></script>
    <script src="{{ asset('assets/admin/js/repeter/repeatercustome.js') }}"></script>
@endpush
