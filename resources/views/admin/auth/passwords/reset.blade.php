<!DOCTYPE html>
<html lang="{{ $current_locale }}" dir="{{ $dir }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $image_logo->company_name ?? 'Law Pro' }} | Reset Password</title>
    @if ($image_logo->favicon_img != '')
        <link rel="shortcut icon"
            href="{{ URL::asset(config('constants.FAVICON_FOLDER_PATH') . '/' . $image_logo->favicon_img) }}">
    @endif
    
    <!-- Old Theme Assets -->
    <link href="{{ URL::asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if($dir == 'rtl')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @endif

    <!-- Law Pro Design System -->
    <link href="{{ mix('css/lawpro-theme.css') }}" rel="stylesheet">

    <script>
        window.Laravel = @json([
            'csrfToken' => csrf_token(),
        ])
    </script>
</head>

<body>
    <div class="lp-auth-wrapper">
        <div class="lp-auth-container">
            <div class="lp-card">
                
                {{-- Language Switcher --}}
                <div style="text-align: {{ $dir == 'rtl' ? 'left' : 'right' }}; margin-bottom: 15px;">
                    <div class="language-switcher-item-simple" style="display: inline-block;">
                        @if ($current_locale == 'ar')
                            <a href="{{ route('language.switch', 'en') }}">
                                <i class="fa fa-globe"></i> English
                            </a>
                        @else
                            <a href="{{ route('language.switch', 'ar') }}">
                                <i class="fa fa-globe"></i> العربية
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Header / Logo --}}
                <div class="lp-auth-header">
                    @if ($image_logo->logo_img != '')
                        <i class="fa fa-balance-scale" aria-hidden="true"></i>
                    @endif
                    <h1>{{ __('frontend.email.reset_your_account') }}</h1>
                </div>

                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email --}}
                    <div class="lp-form-group">
                        <label for="email">{{ __('frontend.login.email') ?? 'Email' }}</label>
                        <input id="email" type="email" class="lp-input form-control" name="email"
                            value="{{ $email ?? old('email') }}" autofocus placeholder="{{ __('frontend.email.enter_email') }}">
                        @if ($errors->has('email'))
                            <div class="lp-error-feedback">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>{{ $errors->first('email') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="lp-form-group">
                        <label for="password">{{ __('frontend.login.password') ?? 'Password' }}</label>
                        <div class="lp-password-wrapper">
                            <input id="password" type="password" class="lp-input form-control" name="password"
                                autocomplete="off" placeholder="{{ __('frontend.login.password') ?? 'Password' }}">
                            <span class="fa fa-eye toggle-icon" aria-hidden="true" id="togglePassword"></span>
                        </div>
                        @if ($errors->has('password'))
                            <div class="lp-error-feedback">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>{{ $errors->first('password') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Confirm Password --}}
                    <div class="lp-form-group">
                        <label for="password-confirm">{{ __('frontend.login.confirm_password') ?? 'Confirm Password' }}</label>
                        <div class="lp-password-wrapper">
                            <input id="password-confirm" type="password" class="lp-input form-control" name="password_confirmation"
                                autocomplete="off" placeholder="{{ __('frontend.login.confirm_password') ?? 'Confirm Password' }}">
                            <span class="fa fa-eye toggle-icon" aria-hidden="true" id="togglePasswordConfirm"></span>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <div class="lp-error-feedback">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>{{ $errors->first('password_confirmation') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <div style="margin-top: 24px; text-align: center;">
                        <button type="submit" class="lp-btn lp-btn-primary" style="width: 100%; justify-content: center; margin-bottom: 16px; padding: 10px 16px; font-size: 14px;">
                            {{ __('frontend.email.reset_your_account') }}
                        </button>
                    </div>

                    {{-- Footer --}}
                    <div class="lp-auth-footer">
                        <p>{{ __('frontend.email.project_name') }}</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            "use strict";

            function togglePasswordVisibility(inputId, iconId) {
                var passwordInput = $("#" + inputId);
                var icon = $("#" + iconId);

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    passwordInput.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            }

            $("#togglePassword").click(function() {
                togglePasswordVisibility("password", "togglePassword");
            });

            $("#togglePasswordConfirm").click(function() {
                togglePasswordVisibility("password-confirm", "togglePasswordConfirm");
            });
        });
    </script>
</body>
</html>
