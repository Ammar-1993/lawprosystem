@extends('admin.layout.app')
@section('title','Expense View')

@section('content')
    <form id="add_invoice" name="add_invoice" role="form" method="POST" action="{{url('admin/add_invoice')}}" autocomplete="off">
        {{ csrf_field() }}

        <div class="flex items-center justify-between mb-lg">
            <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.expense') }}</h3>
            <x-action-button variant="primary" href="{{ url('admin/expense') }}">
                {{ __('frontend.back') }}
            </x-action-button>
        </div>

        <x-form-card title="{{ __('frontend.bill_no') }}: {{ $invoice_no ?? '' }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-xl mb-xl">
                <!-- Billed From -->
                <div>
                    @php
                        if($advocate_client->company_name !=''){
                            $name = $advocate_client->company_name;
                        }elseif($advocate_client->first_name !=''){
                            $name = $advocate_client->first_name.' '.$advocate_client->last_name;
                        }else{
                            $name = 'N/A';
                        }
                    @endphp
                    
                    <h4 class="text-lg font-bold text-dark mb-md border-b border-gray-light pb-xs">{{ __('frontend.billed_from') }}</h4>
                    <p class="mb-xs font-bold text-primary">{{ ucfirst($name) }}</p>
                    <p class="mb-xs text-gray-dark"><strong>{{ __('frontend.address') }}:</strong> {{ $advocate_client->address.' ,'.$city }}</p>
                    <p class="mb-xs text-gray-dark"><strong>{{ __('frontend.mobile') }}:</strong> {{ $advocate_client->mobile }}</p>
                </div>
                
                <!-- Bill Details -->
                <div class="md:text-end">
                    <div class="inline-block md:text-start bg-gray-50 p-md rounded-md border border-gray-light">
                        <p class="mb-xs text-gray-dark"><strong>{{ __('frontend.bill_date') }}:</strong> {{ $inv_date ?? '' }}</p>
                        <p class="mb-0 text-gray-dark"><strong>{{ __('frontend.bill_due_date') }}:</strong> {{ $due_date ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="overflow-x-auto mb-xl border border-gray-light rounded-md">
                <table class="w-full text-start text-sm text-dark">
                    <thead class="bg-gray-100 border-b border-gray-light text-gray-dark uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-center">{{ __('frontend.no') }}</th>
                            <th class="px-4 py-3">{{ __('frontend.items') }}</th>
                            <th class="px-4 py-3">{{ __('frontend.description') }}</th>
                            <th class="px-4 py-3 text-center" width="10%">{{ __('frontend.quantity') }}</th>
                            <th class="px-4 py-3 text-center" width="10%">{{ __('frontend.rate') }}</th>
                            @if($tax_type!="")
                                <th class="px-4 py-3 text-center" width="10%">{{ __('frontend.tax') }} (%)</th>
                                <th class="px-4 py-3 text-center" width="10%">{{ __('frontend.tax') }} (SAR)</th>
                            @endif
                            <th class="px-4 py-3 text-center" width="10%">{{ __('frontend.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @if(!empty($iteam) && count($iteam)>0)
                            @foreach($iteam as $key=>$value)
                                <tr class="border-b border-gray-100 last:border-0">
                                    <td class="px-4 py-3 text-center">{{ $i }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $value['category'] }}</td>
                                    <td class="px-4 py-3 text-gray-dark">{{ $value['custom_items_name'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $value['custom_items_qty'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $value['item_rate'] }}</td>
                                    @if($tax_type!="")
                                        <td class="px-4 py-3 text-center">{{ $value['tax_id_custom'].' %' }}</td>
                                        <td class="px-4 py-3 text-center">{{ $value['tax'] }}</td>
                                    @endif
                                    <td class="px-4 py-3 text-center font-bold">{{ $value['custom_items_amount'] }}</td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Notes and Totals -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
                <div>
                    @if($invoice->remarks!='')
                        <h4 class="text-sm font-bold text-gray-dark mb-xs">{{ __('frontend.note') }}</h4>
                        <p class="text-gray-dark bg-gray-50 p-md rounded-md border border-gray-light">{{ $invoice->remarks ?? '' }}</p>
                    @endif
                </div>
                
                <div class="bg-gray-50 p-lg rounded-md border border-gray-light">
                    <!-- Note: Preserving multiple #tab_logic_total for legacy JS constraints -->
                    <table class="w-full mb-xs" id="tab_logic_total">
                        <tr>
                            <td class="text-start py-2 text-dark font-bold">{{ __('frontend.subtotal') }}</td>
                            <td class="text-end font-bold text-lg">{{ $subTotal }}</td>
                        </tr>
                    </table>
                    
                    <table class="w-full mb-xs" id="tab_logic_total">
                        <tr>
                            <td class="text-start py-2 text-dark font-bold">{{ __('frontend.tax') }}</td>
                            <td class="text-end font-bold text-lg">{{ $tax_amount }}</td>
                        </tr>
                    </table>

                    <table class="w-full border-t border-gray-300 mt-sm pt-sm" id="tab_logic_total">
                        <tr>
                            <td class="text-start py-2 text-xl text-dark font-bold">{{ __('frontend.total') }}</td>
                            <td class="text-end font-bold text-2xl text-primary">{{ $total_amount }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </x-form-card>
    </form>
@endsection
