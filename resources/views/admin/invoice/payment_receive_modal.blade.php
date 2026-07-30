<x-modal id="clientPaymentreceivemodal" title="{{__('frontend.add_payment')}}">
    <div class="grid grid-cols-1 gap-md">
        <div>
            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.amount')}} <span class="text-danger">*</span></label>
            <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.receiving_date')}} <span class="text-danger">*</span></label>
            <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.payment_method')}} <span class="text-danger">*</span></label>
            <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                <option>Cash</option>
                <option>Cheque</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.reference_number')}}</label>
            <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.note')}}</label>
            <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
        </div>
    </div>
    
    <div class="mt-lg pt-md border-t border-gray-light flex justify-end gap-sm">
        <button type="button" class="px-4 py-2 bg-gray-200 text-dark rounded-md hover:bg-gray-300 transition-colors" data-dismiss="modal">{{__('frontend.close')}}</button>
        <button type="button" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-opacity">{{__('frontend.save')}}</button>
    </div>
</x-modal>
