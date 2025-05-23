<ul class="nav navbar-right panel_toolbox">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i
                class="fa fa-ellipsis-h" style="font-size: 19px;"></i></a>
        <ul class="dropdown-menu" role="menu">
            @if (isset($view_modal))
                <li><a data-target-modal="{{ $view_modal->get('target') }}" data-id={{ $view_modal->get('id') }}
                        data-url="{{ $view_modal->get('action', 'javaqscrip:void(0)') }}"
                        href="{{ $view_modal->get('action', 'javaqscrip:void(0)') }}"><i
                            class="fa fa-eye"></i>&nbsp;&nbsp;{{ __('frontend.view') }}</a>
                </li>
            @endif

            @if (isset($permission))
                <li><a href="{{ $permission ?? 'javascrip:void(0)' }}"><i
                            class="fa fa-key"></i>&nbsp;&nbsp;{{ __('frontend.permissions') }}</a></li>
            @endif

            @if (isset($view))
                <li><a href="{{ $view ?? 'javascrip:void(0)' }}"><i
                            class="fa fa-eye"></i>&nbsp;&nbsp;{{ __('frontend.view') }}</a></li>
            @endif



            @if (isset($edit))
                <li class="{{ isset($edit_permission) && $edit_permission == '1' ? '' : 'hidden' }}"><a
                        href="{{ $edit ?? 'javascrip:void(0)' }}"><i
                            class="fa fa-edit"></i>&nbsp;&nbsp;{{ __('frontend.edit') }}</a></li>
            @endif

            @if (isset($download))
                <li class=""><a href="{{ $download ?? 'javascrip:void(0)' }}"><i
                            class="fa fa-download"></i>&nbsp;&nbsp;{{ __('frontend.download') }}</a>
                </li>
            @endif

            @if (isset($restore))
                <li class=""><a href="{{ $restore ?? 'javascrip:void(0)' }}"><i
                            class="fa fa-undo"></i>&nbsp;&nbsp;{{ __('frontend.restore') }}</a>
                </li>
            @endif


            @if (isset($print))
                <li class="divider"></li>
                <li><a target="_blank" href="{{ $print }}"><i
                            class="fa fa-print"></i>&nbsp;&nbsp;{{ __('frontend.print') }}</a></li>
            @endif
            @if (isset($email))
                <li><a href="#"><i class="fa fa-envelope "></i>&nbsp;&nbsp;{{ __('frontend.email_id') }}</a></li>
                <li class="divider"></li>
            @endif

            @if (isset($payment_recevie_modal))
                <li class="{{ isset($edit_permission) && $edit_permission == '1' ? '' : 'hidden' }}">
                    <a class="call-model " data-url="{{ $payment_recevie_modal->get('action', 'javaqscrip:void(0)') }}"
                        data-id={{ $payment_recevie_modal->get('id') }}
                        href="{{ $payment_recevie_modal->get('action', 'javaqscrip:void(0)') }}"
                        data-target-modal="{{ $payment_recevie_modal->get('target') }}"><i
                            class="fa fa-money"></i>&nbsp;&nbsp;
                        {{ __('frontend.payment_receive') }} </a>
                </li>
            @endif

            @if (isset($payment_histroy_modal))
                <li>
                    <a class="call-model" data-url="{{ $payment_histroy_modal->get('action', 'javaqscrip:void(0)') }}"
                        data-id={{ $payment_histroy_modal->get('id') }}
                        href="{{ $payment_histroy_modal->get('action', 'javaqscrip:void(0)') }}"
                        data-target-modal="{{ $payment_histroy_modal->get('target') }}"><i
                            class="fa fa-history"></i>&nbsp;&nbsp;
                        {{ __('frontend.payment_history') }}</a>
                </li>
            @endif

            @if (isset($next_date))
                <li class="divider"></li>
                <li class="{{ isset($edit_permission) && $edit_permission == '1' ? '' : 'hidden' }}">
                    <a class="call-model" data-url="{{ $next_date->get('action', 'javaqscrip:void(0)') }}"
                        data-id={{ $next_date->get('id') }}
                        href="{{ $next_date->get('action', 'javaqscrip:void(0)') }}"
                        data-target-modal="{{ $next_date->get('target') }}"><i
                            class="fa fa-calendar-plus-o"></i>&nbsp;&nbsp;
                        {{ __('frontend.next_date') }}</a>
                </li>
            @endif


            @if (isset($next_date_case))
                <li class="divider"></li>
                <li>

                    @php
                        $next = $next_date_case->get('id');
                    @endphp
                    <a class="call-model" onClick='nextDateAdd({{ $next }});'><i
                            class="fa fa-calendar-plus-o"></i>&nbsp;&nbsp; {{ __('frontend.next_date') }}</a>
                </li>
            @endif


            @if (isset($case_transfer))
                <li class="divider"></li>
                <li class="{{ isset($edit_permission) && $edit_permission == '1' ? '' : 'hidden' }}">

                    @php
                        $transfer_case = $case_transfer->get('id');
                    @endphp
                    <a class="call-model" onClick='transfer_case({{ $transfer_case }});'><i
                            class="fa fa-gavel"></i>&nbsp;&nbsp; {{ __('frontend.case_transfer') }}</a>
                </li>
            @endif

            <li>

                @if (isset($edit_modal))
                    <a class="dropdown-item f-14 call-model {{ isset($edit_permission) && $edit_permission == '1' ? '' : 'hidden' }}"
                        data-target-modal="{{ $edit_modal->get('target') }}" data-id={{ $edit_modal->get('id') }}
                        data-url="{{ $edit_modal->get('action', 'javaqscrip:void(0)') }}"
                        href="{{ $edit_modal->get('action', 'javaqscrip:void(0)') }}">
                        <i class="fa fa-edit"></i>&nbsp;<span class="">{{ __('frontend.edit') }}</span>
                    </a>
                @endif
                @if (isset($delete))
            <li class="{{ isset($delete_permission) && $delete_permission == '1' ? '' : 'hidden' }}"><a
                    class="delete-confrim " data-id={{ $delete->get('id') }}
                    href="{{ $delete->get('action', 'javaqscrip:void(0)') }}"><i
                        class="fa fa-trash "></i>&nbsp;&nbsp;{{ __('frontend.delete') }}</a>

            </li>
            @endif


            @if (isset($payment_made))
                <li class="divider"></li>
                <li class="{{ isset($edit_permission) && $edit_permission == '1' ? '' : 'hidden' }}">
                    <a class="call-model" data-url="{{ $payment_made->get('action', 'javaqscrip:void(0)') }}"
                        data-id={{ $payment_made->get('id') }}
                        href="{{ $payment_made->get('action', 'javaqscrip:void(0)') }}"
                        data-target-modal="{{ $payment_made->get('target') }}"><i class="fa fa-money"></i>&nbsp;&nbsp;
                        {{ __('frontend.payment_made') }}</a>
                </li>
            @endif
            @if (isset($payment_made_history))
                <li>
                    <a class="call-model" data-url="{{ $payment_made_history->get('action', 'javaqscrip:void(0)') }}"
                        data-id={{ $payment_made_history->get('id') }}
                        href="{{ $payment_made_history->get('action', 'javaqscrip:void(0)') }}"
                        data-target-modal="{{ $payment_made_history->get('target') }}"><i
                            class="fa fa-history"></i>&nbsp;&nbsp;
                        {{ __('frontend.payment_made_history') }}</a>
                </li>
            @endif


        </ul>
    </li>

</ul>
