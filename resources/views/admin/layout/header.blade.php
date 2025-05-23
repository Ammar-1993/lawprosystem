{{-- header.blade.php --}}
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">

                <li class=""> {{-- User Profile Dropdown --}}
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        {{-- User image logic --}}
                        @if (Auth::guard('admin')->user())
                            @if (Auth::guard('admin')->user()->profile_img != '')
                                <img
                                    src='{{ asset('public/' . config('constants.CLIENT_FOLDER_PATH') . '/' . Auth::guard('admin')->user()->profile_img) }}'>
                            @else
                                {{-- Consider setting width/height via CSS instead of attributes --}}
                                <img src="{{ asset('public/upload/user-icon-placeholder.png') }}"
                                    alt="User Profile Image"
                                    style="width: 29px; height: 29px; border-radius: 50%; margin-right: 5px;">
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
