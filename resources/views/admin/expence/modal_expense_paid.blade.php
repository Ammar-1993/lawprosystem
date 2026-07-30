<x-modal id="Paymentmade" title="{{ __('frontend.add_payment') }}">
    <form method="post" id="form_payment" name="form_payment">
        <input type="hidden" id="expence_id" name="expence_id" value="{{$expence_id ?? ''}}">
        {{ csrf_field() }}
        
        <div class="alert alert-danger change-cort-d hidden mb-md"></div>
        
        <div class="space-y-md">
            <div>
                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.amount') }} <span class="text-danger">*</span></label>
                <input type="text" id="amount" name="amount" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" autocomplete="off">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.receiving_date') }} <span class="text-danger">*</span></label>
                <input type="text" id="receive_date" name="receive_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent date1" autocomplete="off" readonly="">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.payment_method') }} <span class="text-danger">*</span></label>
                <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent select2" id="method" name="method">
                    <option value="">{{ __('frontend.select_payment_method') }}</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Net Banking">Net Banking</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-dark mb-xs">
                    {{ __('frontend.reference_number') }} <span class="text-danger hide" id="show_star">*</span>
                </label>
                <input type="text" id="referance_number" name="referance_number" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" autocomplete="off">
            </div>

            <div class="hide" id="show_cheque_date">
                <label class="block text-sm font-semibold text-gray-dark mb-xs">Cheque Date <span class="text-danger">*</span></label>
                <input type="text" id="cheque_date" name="cheque_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" autocomplete="off">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.note') }}</label>
                <textarea id="note" name="note" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent rows="3"></textarea>
            </div>
        </div>

        <div class="mt-xl flex justify-end gap-sm">
            <x-action-button variant="danger" data-dismiss="modal">
                {{ __('frontend.close') }}
            </x-action-button>
            <x-action-button variant="success" type="submit" name="judge_type_btn">
                <i class="fa fa-spinner fa-spin hide me-1" id="btn_loader"></i> {{ __('frontend.save') }}
            </x-action-button>
        </div>
    </form>
</x-modal>

<input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
<input type="hidden" name="add_expense_payment" id="add_expense_payment" value="{{ url('admin/add_expense_payment') }}">

<script src="{{ asset('assets/js/expense/expense-payment-mode.js') }}"></script>
