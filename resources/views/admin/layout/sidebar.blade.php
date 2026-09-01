<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu" role="menubar">

            @if ($adminHasPermition->can(['dashboard_list']) == '1')
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}" role="none">
                    <a href="{{ url('admin/dashboard') }}"
                       role="menuitem"
                       aria-current="{{ Request::is('admin/dashboard') ? 'page' : 'false' }}"
                       title="{{ __('frontend.sidebar.dashboard') }}">
                        <i class="fa fa-tachometer" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.dashboard') }}
                    </a>
                </li>
            @endif

            @if ($adminHasPermition->can(['client_list']) == '1')
                <li class="{{ Request::is('admin/clients*') ? 'active' : '' }}" role="none">
                    <a href="{{ route('clients.index') }}"
                       role="menuitem"
                       aria-current="{{ Request::is('admin/clients*') ? 'page' : 'false' }}"
                       title="{{ __('frontend.sidebar.manage_client') }}">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_client') }}
                    </a>
                </li>
            @endif

            @if ($adminHasPermition->can(['case_list']) == '1')
                <li class="{{ Request::is('admin/case*') ? 'active' : '' }}" role="none">
                    <a href="{{ route('case-running.index') }}"
                       role="menuitem"
                       aria-current="{{ Request::is('admin/case*') ? 'page' : 'false' }}"
                       title="{{ __('frontend.sidebar.manage_cases') }}">
                        <i class="fa fa-gavel" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_cases') }}
                    </a>
                </li>
            @endif

            @if ($adminHasPermition->can(['task_list']) == '1')
                <li class="{{ Request::is('admin/tasks*') ? 'active' : '' }}" role="none">
                    <a href="{{ route('tasks.index') }}"
                       role="menuitem"
                       aria-current="{{ Request::is('admin/tasks*') ? 'page' : 'false' }}"
                       title="{{ __('frontend.sidebar.manage_tasks') }}">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_tasks') }}
                    </a>
                </li>
            @endif

            @if ($adminHasPermition->can(['appointment_list']) == '1')
                <li class="{{ Request::is('admin/appointment*') ? 'active' : '' }}" role="none">
                    <a href="{{ route('appointment.index') }}"
                       role="menuitem"
                       aria-current="{{ Request::is('admin/appointment*') ? 'page' : 'false' }}"
                       title="{{ __('frontend.sidebar.manage_appoint') }}">
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_appoint') }}
                    </a>
                </li>
            @endif

            @if ($adminHasPermition->can(['vendor_list']) == '1')
                <li class="{{ Request::is('admin/vendor*') ? 'active' : '' }}" role="none">
                    <a href="{{ route('vendor.index') }}"
                       role="menuitem"
                       aria-current="{{ Request::is('admin/vendor*') ? 'page' : 'false' }}"
                       title="{{ __('frontend.sidebar.manage_vendors') }}">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_vendors') }}
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->user_type == 'Admin')
                <li role="none">
                    <a role="menuitem" title="{{ __('frontend.sidebar.manage_members') }}">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_members') }}
                        <span class="fa fa-chevron-down" aria-hidden="true"></span>
                    </a>
                    <ul class="nav child_menu" role="menu">
                        <li role="none"><a href="{{ route('role.index') }}" role="menuitem">{{ __('frontend.sidebar.role') }}</a></li>
                        <li role="none"><a href="{{ url('admin/client_user') }}" role="menuitem">{{ __('frontend.sidebar.member') }}</a></li>
                    </ul>
                </li>
            @endif

            @if ($adminHasPermition->can(['service_list']) == '1' || $adminHasPermition->can(['invoice_list']) == '1')
                <li class="{{ Request::is('admin/service*') || Request::is('admin/invoice*') ? 'active' : '' }}" role="none">
                    <a role="menuitem" title="{{ __('frontend.sidebar.manage_income') }}">
                        <i class="fa fa-money" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_income') }}
                        <span class="fa fa-chevron-down" aria-hidden="true"></span>
                    </a>
                    <ul class="nav child_menu" role="menu">
                        @if ($adminHasPermition->can(['service_list']) == '1')
                            <li role="none"><a href="{{ url('admin/service') }}" role="menuitem">{{ __('frontend.sidebar.service') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['invoice_list']) == '1')
                            <li role="none"><a href="{{ url('admin/invoice') }}" role="menuitem">{{ __('frontend.sidebar.invoice') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if ($adminHasPermition->can(['expense_type_list']) == '1' || $adminHasPermition->can(['expense_list']) == '1')
                <li class="{{ Request::is('admin/expense*') ? 'active' : '' }}" role="none">
                    <a role="menuitem" title="{{ __('frontend.sidebar.manage_expense') }}">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.manage_expense') }}
                        <span class="fa fa-chevron-down" aria-hidden="true"></span>
                    </a>
                    <ul class="nav child_menu" role="menu">
                        @if ($adminHasPermition->can(['expense_type_list']) == '1')
                            <li role="none"><a href="{{ url('admin/expense-type') }}" role="menuitem">{{ __('frontend.sidebar.expense_type') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['expense_list']) == '1')
                            <li role="none"><a href="{{ url('admin/expense') }}" role="menuitem">{{ __('frontend.sidebar.expense') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (
                $adminHasPermition->can(['case_type_list'])      == '1' ||
                $adminHasPermition->can(['court_type_list'])     == '1' ||
                $adminHasPermition->can(['court_list'])          == '1' ||
                $adminHasPermition->can(['case_status_list'])    == '1' ||
                $adminHasPermition->can(['judge_list'])          == '1' ||
                $adminHasPermition->can(['tax_list'])            == '1' ||
                $adminHasPermition->can(['general_setting_edit']) == '1')
                <li class="{{ Request::is('admin/court*') || Request::is('admin/case-type*') || Request::is('admin/case-status*') || Request::is('admin/judge*') || Request::is('admin/tax*') || Request::is('admin/general-setting*') ? 'active' : '' }}" role="none">
                    <a role="menuitem" title="{{ __('frontend.sidebar.basic_settings') }}">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        {{ __('frontend.sidebar.basic_settings') }}
                        <span class="fa fa-chevron-down" aria-hidden="true"></span>
                    </a>
                    <ul class="nav child_menu" role="menu">
                        @if ($adminHasPermition->can(['court_type_list']) == '1')
                            <li role="none"><a href="{{ url('admin/court-type') }}" role="menuitem">{{ __('frontend.sidebar.manage_court_types') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['court_list']) == '1')
                            <li role="none"><a href="{{ url('admin/court') }}" role="menuitem">{{ __('frontend.sidebar.manage_courts') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['judge_list']) == '1')
                            <li role="none"><a href="{{ url('admin/judge') }}" role="menuitem">{{ __('frontend.sidebar.manage_judges') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['case_type_list']) == '1')
                            <li role="none"><a href="{{ url('admin/case-type') }}" role="menuitem">{{ __('frontend.sidebar.manage_case_types') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['case_status_list']) == '1')
                            <li role="none"><a href="{{ url('admin/case-status') }}" role="menuitem">{{ __('frontend.sidebar.manage_case_statuses') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['tax_list']) == '1')
                            <li role="none"><a href="{{ url('admin/tax') }}" role="menuitem">{{ __('frontend.sidebar.manage_tax') }}</a></li>
                        @endif
                        @if ($adminHasPermition->can(['general_setting_edit']) == '1')
                            <li role="none"><a href="{{ url('admin/general-setting') }}" role="menuitem">{{ __('frontend.sidebar.general_settings') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

        </ul>
    </div>
</div>

