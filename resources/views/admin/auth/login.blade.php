<!DOCTYPE html>
<html lang="{{ $current_locale }}" dir="{{ $dir }}">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $image_logo->company_name ?? 'Law Pro' }} | Login </title>
    @if ($image_logo->favicon_img != '')
        <link rel="shortcut icon"
            href="{{ URL::asset(config('constants.FAVICON_FOLDER_PATH') . '/' . $image_logo->favicon_img) }}">
    @endif
    <!-- Bootstrap -->
    <link href="{{ URL::asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ URL::asset('assets/admin/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style type="text/css">
        .login_content_btn a:hover {
            text-decoration: none;
        }
    </style>
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
                        {{ csrf_field() }}


                        {{-- Language switcher as a simple list item --}}
                        <li class="language-switcher-item-simple">
                            @if ($current_locale == 'ar')
                                <a href="{{ route('language.switch', 'en') }}">
                                    <i class="fa fa-globe"></i> English
                                </a>
                            @else
                                <a href="{{ route('language.switch', 'ar') }}">
                                    <i class="fa fa-globe"></i> العربية
                                </a>
                            @endif
                        </li>

                        <h1>{{ __('frontend.login.login') }}</h1>

                        @if ($image_logo->logo_img != '')
                            <i class="fa fa-balance-scale" aria-hidden="true"
                                style="margin-left: 5px; margin-right: 5px; font-size: 60px;"></i>
                        @endif
                        <h2> {{ __('frontend.login.login_your_account') }} </h2>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email"
                                value="{{ old('email') }}" autofocus placeholder="{{ __('frontend.login.email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block text-left">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password"
                                    autocomplete="off" placeholder="{{ __('frontend.login.password') }}">

                                <span class="input-group-addon" style="cursor: pointer;">
                                    <i class="fa fa-eye" aria-hidden="true" id="togglePassword"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block text-left" style="display: block;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div>
                            <button style="background-color: #daa520; color:aliceblue" type="submit"
                                class="btn btn-default">
                                {{ __('frontend.login.login_button') }}
                            </button>
                            <a style="font-size: 16px" class="reset_pass"
                                href="{{ url('/admin/password/reset') }}">{{ __('frontend.login.forgot_password') }}</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">

                            <div class="clearfix"></div>
                            <br />

                            <div>

                                <p style="font-size: 18px">{{ __('frontend.login.project_name') }}</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            "use strict";

            $(".fill-login").click(function() {
                $("#email").val($(this).data("email"));
                $("#password").val($(this).data("password"));
            });

            $("#togglePassword").click(function() {
                var passwordInput = $("#password");
                var icon = $(this);

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });


        });
    </script>
</body>

</html>
