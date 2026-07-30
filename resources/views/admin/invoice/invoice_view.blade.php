@extends('admin.layout.app')
@section('title','Invoice View')

@section('content')
    <div class="flex items-center justify-between mb-lg">
        <h3 class="text-2xl font-bold text-dark m-0">{{__('frontend.invoice')}}</h3>
        <div class="flex gap-sm">
            <x-action-button variant="primary" href="{{ url('admin/invoice') }}">
                {{__('frontend.back')}}
            </x-action-button>
            <x-action-button variant="secondary" href="{{url('admin/create-Invoice-view-detail/'.$invoice->id.'/print')}}" target="_blank">
                <i class="fa fa-print me-1" aria-hidden="true"></i> Print
            </x-action-button>
        </div>
    </div>

    <form id="add_invoice" name="add_invoice" role="form" method="POST" action="{{url('admin/add_invoice')}}" autocomplete="off">
        {{ csrf_field() }}

        <x-form-card title="{{__('frontend.invoice_no')}}: {{ $invoice_no ?? '' }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg pb-lg border-b border-gray-light">
                <!-- Billed To -->
                <div>
                    <h4 class="text-sm font-bold text-gray-dark uppercase tracking-wider mb-sm">{{__('frontend.billed_to')}}</h4>
                    <p class="font-bold text-dark text-lg mb-xs">
                        {{ ucfirst($advocate_client->first_name)." ".$advocate_client->middle_name." ".$advocate_client->last_name }}
                    </p>
                    <p class="text-gray-dark mb-xs">
                        <i class="fa fa-map-marker w-5 text-center text-gray-400"></i> {{ $advocate_client->address.' ,'.$city }}
                    </p>
                    <p class="text-gray-dark">
                        <i class="fa fa-phone w-5 text-center text-gray-400"></i> {{$advocate_client->mobile}}
                    </p>
                </div>

                <!-- Invoice Details -->
                <div class="md:text-end">
                    <div class="inline-block md:text-start bg-gray-50 p-md rounded-md border border-gray-light">
                        <div class="flex justify-between gap-xl mb-xs">
                            <span class="text-sm font-semibold text-gray-dark">{{__('frontend.invoice_date')}}</span>
                            <span class="font-bold text-dark">{{ $inv_date ?? ''}}</span>
                        </div>
                        <div class="flex justify-between gap-xl">
                            <span class="text-sm font-semibold text-gray-dark">{{__('frontend.invoice_due_date')}}</span>
                            <span class="font-bold text-dark">{{ $due_date ?? ''}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="overflow-x-auto mb-lg border border-gray-light rounded-md">
                <table class="w-full text-start text-sm">
                    <thead class="bg-gray-50 text-gray-dark uppercase text-xs border-b border-gray-light">
                        <tr>
                            <th class="px-4 py-3 text-center w-16"><strong>{{__('frontend.no')}}</strong></th>
                            <th class="px-4 py-3 text-start"><strong>{{__('frontend.service')}}</strong></th>
                            <th class="px-4 py-3 text-start"><strong>{{__('frontend.description')}}</strong></th>
                            <th class="px-4 py-3 text-center w-24"><strong>{{__('frontend.quantity')}}</strong></th>
                            <th class="px-4 py-3 text-center w-32"><strong>{{__('frontend.rate')}}</strong></th>
                            <th class="px-4 py-3 text-end w-32"><strong>{{__('frontend.amount')}}</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @if(!empty($iteam) && count($iteam)>0)
                            @foreach($iteam as $key=>$value)
                                <tr class="border-b border-gray-light last:border-b-0 hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-center text-gray-dark">{{$i}}</td>
                                    <td class="px-4 py-3 font-semibold text-dark">{{$value['service_name']}}</td>
                                    <td class="px-4 py-3 text-gray-dark">{{ $value['custom_items_name'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $value['custom_items_qty'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $value['item_rate'] }}</td>
                                    <td class="px-4 py-3 text-end font-medium">{{$value['custom_items_amount']}}</td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Notes and Totals -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                <!-- Notes -->
                <div>
                    @if($invoice->remarks != '')
                        <div class="bg-gray-50 p-md rounded-md border border-gray-light">
                            <h4 class="text-sm font-bold text-gray-dark uppercase tracking-wider mb-xs">{{__('frontend.note')}}</h4>
                            <p class="text-dark">{{$invoice->remarks ?? ''}}</p>
                        </div>
                    @endif
                </div>

                <!-- Totals -->
                <div class="bg-gray-50 p-md rounded-md border border-gray-light">
                    <!-- id="tab_logic_total" kept for legacy JS just in case, though it's view mode -->
                    <table class="w-full mb-sm" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2 font-semibold text-gray-dark">{{__('frontend.subtotal')}}</th>
                            <td class="text-end py-2 font-bold text-dark">{{$subTotal}}</td>
                        </tr>
                        <tr>
                            <th class="text-start py-2 font-semibold text-gray-dark">{{__('frontend.tax')}}</th>
                            <td class="text-end py-2 font-bold text-dark">{{$tax_amount}}</td>
                        </tr>
                    </table>
                    
                    <table class="w-full border-t border-gray-light pt-sm" id="tab_logic_total">
                        <tr>
                            <th class="text-start py-2 text-lg font-bold text-dark">{{__('frontend.total')}}</th>
                            <td class="text-end py-2 text-xl font-bold text-primary">{{ $total_amount }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </x-form-card>
    </form>
@endsection

@push('scripts')
@endpush
