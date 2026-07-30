<!DOCTYPE html>
<html lang="{{ $current_locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $image_logo->company_name ?? 'Law Pro' }} | Login</title>
    
    @if ($image_logo->favicon_img != '')
        <link rel="shortcut icon" href="{{ URL::asset(config('constants.FAVICON_FOLDER_PATH') . '/' . $image_logo->favicon_img) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if($dir == 'rtl')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @endif

    <!-- Font Awesome (Retained for icons) -->
    <link href="{{ URL::asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Law Pro Theme + Tailwind CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Alpine.js + App JS -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="bg-bg flex items-center justify-center min-h-screen font-sans text-dark">
    
    <div class="w-full max-w-md p-lg bg-white rounded-lg shadow-card mx-4">
        
        <!-- Language Switcher -->
        <div class="text-end mb-md">
            @if ($current_locale == 'ar')
                <a href="{{ route('language.switch', 'en') }}" class="text-sm text-secondary hover:text-primary transition-colors inline-flex items-center gap-2">
                    <i class="fa fa-globe"></i> English
                </a>
            @else
                <a href="{{ route('language.switch', 'ar') }}" class="text-sm text-secondary hover:text-primary transition-colors inline-flex items-center gap-2">
                    <i class="fa fa-globe"></i> العربية
                </a>
            @endif
        </div>

        <!-- Logo & Header -->
        <div class="text-center mb-xl">
            @if ($image_logo->logo_img != '')
                <i class="fa fa-balance-scale text-primary mb-sm" style="font-size: 60px;"></i>
            @endif
            <h1 class="text-2xl font-bold text-primary mb-xs">{{ __('frontend.login.login') }}</h1>
            <p class="text-gray-dark text-sm">{{ __('frontend.login.login_your_account') }}</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}

            <!-- Email Field -->
            <div class="mb-md">
                <label for="email" class="block text-sm font-semibold text-gray-dark mb-xs text-start">{{ __('frontend.login.email') }}</label>
                <input id="email" type="email" class="w-full px-4 py-2 border {{ $errors->has('email') ? 'border-danger' : 'border-gray-light' }} rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent text-start transition-colors" name="email" value="{{ old('email') }}" autofocus placeholder="{{ __('frontend.login.email') }}">
                
                @if ($errors->has('email'))
                    <span class="text-sm text-danger mt-1 block text-start">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Password Field -->
            <div class="mb-xl" x-data="{ showPassword: false }">
                <label for="password" class="block text-sm font-semibold text-gray-dark mb-xs text-start">{{ __('frontend.login.password') }}</label>
                <div class="relative">
                    <input id="password" :type="showPassword ? 'text' : 'password'" class="w-full px-4 py-2 border {{ $errors->has('password') ? 'border-danger' : 'border-gray-light' }} rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent pe-10 text-start transition-colors" name="password" autocomplete="off" placeholder="{{ __('frontend.login.password') }}">
                    
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 end-0 px-3 flex items-center text-gray hover:text-gray-dark transition-colors">
                        <i class="fa" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" aria-hidden="true"></i>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <span class="text-sm text-danger mt-1 block text-start">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mb-lg">
                <a class="text-sm text-secondary hover:text-primary transition-colors" href="{{ url('/admin/password/reset') }}">
                    {{ __('frontend.login.forgot_password') }}
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-6 rounded-md transition-colors shadow-sm">
                    {{ __('frontend.login.login_button') }}
                </button>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-light pt-md mt-md text-center">
                <p class="text-gray text-sm font-medium">{{ __('frontend.login.project_name') }}</p>
            </div>
        </form>
    </div>

</body>
</html>
