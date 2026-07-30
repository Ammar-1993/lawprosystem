<x-modal id="clientPaymentreceivemodal" title="{{__('frontend.add_payment')}}">
    <form method="post" id="form_payment" name="form_payment">
        <input type="hidden" id="invoice_id" name="invoice_id" value="{{$invoice_id}}">
        {{ csrf_field() }}

        <div class="alert alert-danger change-cort-d hidden mb-md"></div>

        <div class="grid grid-cols-1 gap-md">
            <div>
                <label for="amount" class="block text-sm font-semibold text-gray-dark mb-xs">
                    {{__('frontend.amount')}} <span class="text-danger rest">*</span>
                </label>
                <input type="text" id="amount" name="amount" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="" autocomplete="off">
            </div>

            <div>
                <label for="receive_date" class="block text-sm font-semibold text-gray-dark mb-xs">
                    {{__('frontend.receiving_date')}} <span class="text-danger rest">*</span>
                </label>
                <input type="text" id="receive_date" name="receive_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent date1" value="" autocomplete="off" readonly="">
            </div>

            <div>
                <label for="method" class="block text-sm font-semibold text-gray-dark mb-xs">
                    {{__('frontend.payment_method')}} <span class="text-danger rest">*</span>
                </label>
                <!-- select2 kept intact -->
                <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent select2" id="method" name="method">
                    <option value="">{{__('frontend.select_payment_method')}}</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Net Banking">Net Banking</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label for="referance_number" class="block text-sm font-semibold text-gray-dark mb-xs">
                    {{__('frontend.reference_number')}} <span class="text-danger rest hide" id="show_star">*</span>
                </label>
                <input type="text" id="referance_number" name="referance_number" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="" autocomplete="off">
            </div>

            <div class="hide" id="show_cheque_date">
                <label for="cheque_date" class="block text-sm font-semibold text-gray-dark mb-xs">
                    Cheque Date <span class="text-danger rest">*</span>
                </label>
                <input type="text" id="cheque_date" name="cheque_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="" autocomplete="off">
            </div>

            <div>
                <label for="note" class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.note')}}</label>
                <textarea id="note" name="note" rows="3" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
            </div>
        </div>

        <div class="mt-lg pt-md border-t border-gray-light flex justify-end gap-sm">
            <button type="button" class="px-4 py-2 bg-gray-200 text-dark rounded-md hover:bg-gray-300 transition-colors" data-dismiss="modal">
                {{__('frontend.close')}}
            </button>
            <button type="submit" name="judge_type_btn" class="px-4 py-2 bg-success text-white rounded-md hover:bg-opacity-90 transition-opacity">
                <i class="fa fa-spinner fa-spin hide" id="btn_loader"></i> {{__('frontend.save')}}
            </button>
        </div>
    </form>
</x-modal>

<input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
<input type="hidden" name="method_" id="method_" value="{{ empty($judge->id)?'POST':'PATCH'}}">
<input type="hidden" name="url" id="url" value="{{ empty($judge->id)?route('invoice.store'):route('invoice.update',$judge->id)}}">

<script src="{{asset('assets/js/invoice/invoice-payment.js')}}"></script>
