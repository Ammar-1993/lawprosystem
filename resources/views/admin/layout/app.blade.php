<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"> --}}
<html lang="{{ $current_locale }}" dir="{{ $dir }}">
{{-- dir="{{ $dir ?? 'ltr' }}" --}}

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if ($image_logo->favicon_img != '')
        <link rel="shortcut icon"
            href="{{ asset(config('constants.FAVICON_FOLDER_PATH') . '/' . $image_logo->favicon_img) }}">
    @endif
    <title>{{ $image_logo->company_name ?? '' }} | @yield('title')</title>
    <!-- Bootstrap -->
    <link href="{{ asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <script>
        window.Laravel = @json([
            'csrfToken' => csrf_token(),
        ])
    </script>
    {{-- <link href="{{ asset('assets/admin/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}"
        rel="stylesheet"> --}}
    <!-- Font Awesome -->
    <link href="{{ asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    @stack('style')
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('assets/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}"
        rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/admin/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}"
        rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ app()->getLocale() == 'ar' ? asset('css/app.rtl.css') : asset('css/app.css') }}"> --}}
    {{-- @if ($current_locale == 'ar')
        <link rel="stylesheet" href="{{ asset('assets/css/rtl.css') }}">
        <link href="{{ asset('assets/admin/vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    @endif --}}


    @if ($dir == 'rtl')
        {{-- <link href="{{ asset('assets/css/style-rtl.css') }}" rel="stylesheet"> --}}

        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
        {{-- <link href="{{ asset('assets/admin/vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') }}" rel="stylesheet"> --}}

        <link href="{{ asset('assets/admin/vendors/bootstrap/dist/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/build/css/custom-rtl.min.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('css/app.rtl.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker.ar.css') }}"
        rel="stylesheet"> --}}
    @endif


</head>

<body class="nav-md {{ $dir == 'rtl' ? 'rtl' : '' }}">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title app-border">
                        <a href="{{ url('') }}" class="site_title">


                            <i class="fa fa-balance-scale" aria-hidden="true"
                                style="margin-left: 5px; margin-right: 5px; font-size: 25px;"></i>


                            <span>{{ $image_logo->company_name ?? 'Law Pro' }}</span>

                        </a>
                    </div>



                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            @if (Auth::guard('admin')->user())
                                @if (Auth::guard('admin')->user()->profile_img != '')
                                    <img alt="" class="img-circle profile_img"
                                        src='{{ asset('public/' . config('constants.CLIENT_FOLDER_PATH') . '/' . Auth::guard('admin')->user()->profile_img) }}'>
                                @else
                                    <img src="{{ asset('public/upload/user-icon-placeholder.png') }}"
                                        class="img-circle profile_img" alt="">
                                @endif
                            @endif
                        </div>
                        <div class="profile_info">
                            <span>{{ __('frontend.welcome') }}</span>
                            <h2> {{ Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name }}
                            </h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    @include('admin.layout.sidebar')
                    <!-- /sidebar menu -->

                </div>
            </div>

            <!-- top navigation -->
            @include('admin.layout.header')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
            <!-- /page content -->

            <!-- footer content -->
            @include('admin.layout.footer')
            <!-- /footer content -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/admin/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('assets/admin/vendors/nprogress/nprogress.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('assets/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('assets/admin/vendors/DateJS/build/date.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/admin/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/sweetalert2.all.min.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('assets/admin/build/js/custom.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}">
    </script>
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>


    {{-- <script src="{{ asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.ar.min.js') }}"></script> --}}



    {{-- START: Added code to pass common JS translations --}}
    <script>
        // Use 'backend.common_js' if keys are in backend.php
        var commonJsLang = @json(__('backend.common_js'));
    </script>
    {{-- END: Added code --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>


    {{-- Modified Script Block for Session Messages --}}
    <script>
        @if (Session::has('error'))
            message.fire({
                type: 'error',
                title: commonJsLang.error_title || 'Error', // Use translation, fallback to English
                text: "{!! session('error') !!}"
            });
            {{-- Optional: If using flash correctly, forget might not be needed
        @php session()->forget('error') @endphp
        --}}
        @endif

        @if (Session::has('success'))
            message.fire({
                type: 'success',
                title: commonJsLang.success_title || 'Success', // Use translation, fallback to English
                text: "{!! session('success') !!}"
            });
            {{-- Optional: If using flash correctly, forget might not be needed
         @php session()->forget('success'); /* Corrected typo */ @endphp
         --}}
        @endif
    </script>

    @stack('js')
</body>

</html>
