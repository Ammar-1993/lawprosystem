<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">

        <ul class="nav side-menu">
            @if ($adminHasPermition->can(['dashboard_list']) == '1')
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-tachometer"></i>
                        {{ __('frontend.sidebar.dashboard') }} </a></li>
            @endif

            @if ($adminHasPermition->can(['client_list']) == '1')
                <li><a href="{{ route('clients.index') }}"><i class="fa fa-user-plus"></i>
                        {{ __('frontend.sidebar.manage_client') }} </a></li>
            @endif

            @if ($adminHasPermition->can(['case_list']) == '1')
                <li><a href="{{ route('case-running.index') }}"><i
                            class="fa fa-gavel"></i>{{ __('frontend.sidebar.manage_cases') }} </a></li>
            @endif
            @if ($adminHasPermition->can(['task_list']) == '1')
                <li><a href="{{ route('tasks.index') }}"><i class="fa fa-tasks"></i>
                        {{ __('frontend.sidebar.manage_tasks') }} </a></li>
            @endif


            @if ($adminHasPermition->can(['appointment_list']) == '1')
                <li><a href="{{ route('appointment.index') }}"><i class="fa fa-calendar-plus-o"></i>
                        {{ __('frontend.sidebar.manage_appoint') }} </a>
                </li>
            @endif

            @if ($adminHasPermition->can(['vendor_list']) == '1')
                <li><a href="{{ route('vendor.index') }}"><i class="fa fa-user-plus"></i>
                        {{ __('frontend.sidebar.manage_vendors') }} </a></li>
            @endif

            @if (Auth::guard('admin')->user()->user_type == 'Admin')
                <li><a><i class="fa fa-users"></i> {{ __('frontend.sidebar.manage_members') }} <span
                            class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('role.index') }}">{{ __('frontend.sidebar.role') }}</a></li>
                        <li><a href="{{ url('admin/client_user') }}"> {{ __('frontend.sidebar.member') }}</a></li>

                    </ul>
                </li>
            @endif
            @if ($adminHasPermition->can(['service_list']) == '1' || $adminHasPermition->can(['invoice_list']) == '1')
                <li><a><i class="fa fa-money"></i>{{ __('frontend.sidebar.manage_income') }} <span
                            class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        @if ($adminHasPermition->can(['service_list']) == '1')
                            <li><a href="{{ url('admin/service') }}">{{ __('frontend.sidebar.service') }} </a></li>
                        @endif

                        @if ($adminHasPermition->can(['invoice_list']) == '1')
                            <li><a href="{{ url('admin/invoice') }}">{{ __('frontend.sidebar.invoice') }} </a>
                        @endif


                    </ul>
                </li>
            @endif


            @if ($adminHasPermition->can(['expense_type_list']) == '1' || $adminHasPermition->can(['expense_list']) == '1')
                <li><a><i class="fa fa-money"></i> {{ __('frontend.sidebar.manage_expense') }} <span
                            class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                        @if ($adminHasPermition->can(['expense_type_list']) == '1')
                            <li><a
                                    href="{{ url('admin/expense-type') }}">{{ __('frontend.sidebar.expense_type') }}</a>
                            </li>
                        @endif


                        @if ($adminHasPermition->can(['expense_list']) == '1')
                            <li><a href="{{ url('admin/expense') }}">{{ __('frontend.sidebar.expense') }}</a></li>
                        @endif

                    </ul>
                </li>

            @endif


            @if (
                $adminHasPermition->can(['case_type_list']) == '1' ||
                    $adminHasPermition->can(['court_type_list']) == '1' ||
                    $adminHasPermition->can(['court_list']) == '1' ||
                    $adminHasPermition->can(['case_status_list']) == '1' ||
                    $adminHasPermition->can(['judge_list']) == '1' ||
                    $adminHasPermition->can(['tax_list']) == '1' ||
                    $adminHasPermition->can(['general_setting_edit']) == '1')
                <li><a><i class="fa fa-gear"></i> {{ __('frontend.sidebar.basic_settings') }} <span
                            class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">



                        @if ($adminHasPermition->can(['court_type_list']) == '1')
                            <li><a
                                    href="{{ url('admin/court-type') }}">{{ __('frontend.sidebar.manage_court_types') }}</a>
                            </li>
                        @endif

                        @if ($adminHasPermition->can(['court_list']) == '1')
                            <li><a href="{{ url('admin/court') }}">{{ __('frontend.sidebar.manage_courts') }} </a>
                            </li>
                        @endif

                        @if ($adminHasPermition->can(['judge_list']) == '1')
                            <li><a href="{{ url('admin/judge') }}">{{ __('frontend.sidebar.manage_judges') }}</a></li>
                        @endif

                        @if ($adminHasPermition->can(['case_type_list']) == '1')
                            <li><a
                                    href="{{ url('admin/case-type') }}">{{ __('frontend.sidebar.manage_case_types') }}</a>
                            </li>
                        @endif

                        @if ($adminHasPermition->can(['case_status_list']) == '1')
                            <li><a
                                    href="{{ url('admin/case-status') }}">{{ __('frontend.sidebar.manage_case_statuses') }}</a>
                            </li>
                        @endif

                        @if ($adminHasPermition->can(['tax_list']) == '1')
                            <li><a href="{{ url('admin/tax') }}">{{ __('frontend.sidebar.manage_tax') }}</a></li>
                        @endif


                        @if ($adminHasPermition->can(['general_setting_edit']) == '1')
                            <li><a
                                    href="{{ url('admin/general-setting') }}">{{ __('frontend.sidebar.general_settings') }}</a>
                            </li>
                        @endif
                        {{-- @if (Auth::guard('admin')->user()->user_type == 'Admin')
                            <li><a href="{{ url('admin/database-backup') }}">Database Backup</a></li>
                        @endif --}}

                    </ul>
                </li>
            @endif

        </ul>
    </div>
</div>
