{{-- header.blade.php --}}
<div class="top_nav">
    <div class="nav_menu">
        <nav style="display:flex;align-items:stretch;width:100%;">
            {{-- Hamburger toggle --}}
            <div class="nav toggle">
                <a id="menu_toggle" aria-label="Toggle sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            {{-- Breadcrumb Navigation --}}
            <nav class="lp-breadcrumb-bar" aria-label="Breadcrumb">
                <ol class="lp-breadcrumb">
                    <li>
                        <a href="{{ url('admin/dashboard') }}" title="{{ __('frontend.sidebar.dashboard') }}">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                        @foreach($breadcrumbs as $label => $url)
                            <li @if($loop->last) class="active" @endif>
                                @if(!$loop->last && $url)
                                    <a href="{{ $url }}">{{ $label }}</a>
                                @else
                                    {{ $label }}
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
            </nav>

            <ul class="nav navbar-nav navbar-right">

                <li class=""> {{-- User Profile Dropdown --}}
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        {{-- User image --}}
                        @if (Auth::guard('admin')->user())
                            @if (Auth::guard('admin')->user()->profile_img != '')
                                <img
                                    src='{{ asset('public/' . config('constants.CLIENT_FOLDER_PATH') . '/' . Auth::guard('admin')->user()->profile_img) }}'
                                    alt="{{ __('frontend.my_account') }}">
                            @else
                                <img src="{{ asset('public/upload/user-icon-placeholder.png') }}"
                                    alt="{{ __('frontend.my_account') }}">
                            @endif
                        @endif
                        {{-- User name --}}
                        {{ Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        {{-- Dropdown items --}}
                        <li><a href="{{ url('admin/admin-profile') }}">
                                <i class="fa fa-user"></i>&nbsp;&nbsp;{{ __('frontend.my_account') }}</a></li>
                        <li><a href="{{ url('/admin/logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa fa-sign-out"></i> {{ __('frontend.logout') }}</a>
                            <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>

                {{-- ===== START: Improved Language Switcher ===== --}}
                <li class="language-switcher-item-simple">
                    @if ($current_locale == 'ar')
                        <a href="{{ route('language.switch', 'en') }}">
                            <i class="fa fa-globe"></i>&nbsp; English
                        </a>
                    @else
                        <a href="{{ route('language.switch', 'ar') }}">
                            <i class="fa fa-globe"></i>&nbsp; العربية
                        </a>
                    @endif
                </li>
                {{-- ===== END: Improved Language Switcher ===== --}}


                @if ($adminHasPermition->can(['case_list']) == '1')
                    {{-- It's better practice to wrap these in <li> elements too if they are siblings --}}
                    {!! App\Helpers\LogActivity::generateTasks() !!}
                    {!! App\Helpers\LogActivity::getNotifications() !!}
                @endif

            </ul>
        </nav>
    </div>
</div>
