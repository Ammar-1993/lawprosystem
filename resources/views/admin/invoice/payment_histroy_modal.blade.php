<x-modal id="clientPaymenthistroymodal" title="{{__('frontend.payment_history')}}">
    <div class="overflow-x-auto border border-gray-light rounded-md">
        <table class="w-full text-start text-sm">
            <thead class="bg-gray-50 text-gray-dark uppercase text-xs border-b border-gray-light">
                <tr>
                    <th class="px-4 py-3 font-semibold">{{__('frontend.invoice_no')}}</th>
                    <th class="px-4 py-3 font-semibold">{{__('frontend.amount')}}</th>
                    <th class="px-4 py-3 font-semibold">{{__('frontend.receiving_date')}}</th>
                    <th class="px-4 py-3 font-semibold">{{__('frontend.payment_method')}}</th>
                    <th class="px-4 py-3 font-semibold">{{__('frontend.reference_number')}}</th>
                    <th class="px-4 py-3 font-semibold text-center">{{__('frontend.note')}}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-light text-dark">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">INV-000015</td>
                    <td class="px-4 py-3 font-medium">0</td>
                    <td class="px-4 py-3">01-01-2019</td>
                    <td class="px-4 py-3">Cash</td>
                    <td class="px-4 py-3 text-gray-dark">N/A</td>
                    <td class="px-4 py-3 text-center">
                        <a href="javascript:void(0);" tabindex="0" class="text-accent hover:text-primary transition-colors" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="" data-content="N/A" data-original-title="Remarks">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">INV-000015</td>
                    <td class="px-4 py-3 font-medium">88</td>
                    <td class="px-4 py-3">01-01-2019</td>
                    <td class="px-4 py-3">Cash</td>
                    <td class="px-4 py-3 text-gray-dark">N/A</td>
                    <td class="px-4 py-3 text-center">
                        <a href="javascript:void(0);" tabindex="0" class="text-accent hover:text-primary transition-colors" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="" data-content="N/A" data-original-title="Remarks">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-modal>
