@extends('admin.layout.app')
@section('title', 'Change Password')

@section('content')
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('frontend.my_account') }}</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('component.error')
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('frontend.update_password') }}</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_content">

                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation"
                                            class="@if (request()->segment(2) == 'admin-profile') active @else @endif"><a
                                                href="{{ url('admin/admin-profile') }}">{{ __('frontend.profile') }}</a>
                                        </li>

                                        <li role="presentation"
                                            class="@if (request()->segment(3) == 'password') active @else @endif"><a
                                                href="{{ url('admin/change/password') }}"> {{ __('frontend.password') }}</a>

                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">


                                        <form id="change_password" name="change_password" role="form" method="POST"
                                            action="{{ url('admin/changed-password') }}">
                                            @csrf
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="current_password">{{ __('frontend.current_password') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="password" id="old" name="old"
                                                        class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="new_password">{{ __('frontend.new_password') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="password" id="new" name="new"
                                                        class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="confirm_password">{{ __('frontend.confirm_password') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="password" id="confirm" name="confirm"
                                                        class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group pull-right">
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <br>

                                                    <button type="submit" name="btn_add_change" class="btn btn-success">
                                                        <i class="fa fa-save"
                                                            id="show_loader"></i>&nbsp;{{ __('frontend.update') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- START: Added code to pass change password translations --}}
    <script>
        // Use translations from 'backend.change_password' keys
        // This makes the object available as 'changePasswordValidationMessages' in JS
        var changePasswordValidationMessages = @json(__('backend.change_password'));

        // Optionally pass the current language if needed elsewhere (not used in this specific JS)
        var currentLang = '{{ app()->getLocale() }}';
    </script>
    {{-- END: Added code --}}
    <script src="{{ asset('assets/js/change-pass/change-pass-validation.js') }}"></script>
@endpush
