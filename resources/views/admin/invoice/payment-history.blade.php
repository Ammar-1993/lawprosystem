<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="clientPaymenthistroymodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{__('frontend.payment_history')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('frontend.invoice_no')}}</th>
                                <th>{{__('frontend.amount')}}</th>
                                <th>{{__('frontend.receiving_date')}}</th>
                                <th>{{__('frontend.payment_method')}}</th>
                                <th>{{__('frontend.reference_number')}}</th>
                                <th>{{__('frontend.note')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($getPaymentHistory as $history)
                                <tr>
                                    <td>{{$history->invoice_no}}</td>
                                    <td>
                                        {{round($history->amount)}}
                                    </td>
                                    <td>{{date($date_format_laravel,strtotime($history->receiving_date))}}</td>
                                    <td>{{$history->payment_type}} @if($history->payment_type=='Cheque')
                                            ({{date($date_format_laravel,strtotime($history->cheque_date))}}
                                            ) @endif</td>
                                    <td>{{$history->reference_number ?? 'N/A'}}</td>
                                    <td><a href="javascript:void(0);" tabindex="0" class="text-right"
                                           data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="Remarks" data-content="{{$history->note ?? 'N/A'}}"><i
                                                class="fa fa-eye"</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No record found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        "use strict";
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    });
</script>
