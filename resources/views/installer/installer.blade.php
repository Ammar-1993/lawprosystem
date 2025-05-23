@extends('installer.app')
@section('title','DB Information')
@push('css')
    <link href="{{asset('assets/css/install.css') }}" rel="stylesheet">
@endpush
@section('content')
    <section class="login_content">
        <form class="form-horizontal" id="installerForm" role="form" method="POST"
              action="{{ route('run.installer') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 style="float: none;">System Information </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            @if (session('status'))
                                <div class="alert alert-danger">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <span class="section pull-left">Application Information</span>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">App Name
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="app_name" name="app_name" class="form-control ">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="app_url">App URL <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="app_url" name="app_url" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <span class="section pull-left">Database Information</span>
                            <!-- <div class="item form-group">
                               <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Upload SQL File <span class="required">*</span>
                               </label>
                               <div class="col-md-6 col-sm-6 ">
                               <input type="text" id="first-name" required="required" class="form-control ">
                               </div>
                               </div>
                                -->
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="db_host">Database
                                    Hostname <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="db_host" name="db_host" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="db_port">Database Port
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="db_port" name="db_port" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="db_database">Database
                                    Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="db_database" name="db_database" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="db_username">Database
                                    Username <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="db_username" name="db_username" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="db_password">Database
                                    Password <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="db_password" name="db_password" class="form-control">
                                </div>
                            </div>
                            <span class="section pull-left">Admin Information</span>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_name">{{__('frontend.name')}}<span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="user_name" name="user_name" required="required"
                                           class="form-control ">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_email">{{__('frontend.email_id')}}<span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="user_email" name="user_email" required="required"
                                           class="form-control ">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_pwd">{{__('frontend.password')}}
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="password" id="user_pwd" name="user_pwd" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_cpwd">{{__('frontend.confirm_password')}} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="password" id="user_cpwd" name="user_cpwd" required="required"
                                           class="form-control">
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-default pull-right" id="show_loader">
                                    Run Installer
                                </button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <!--  <p class="change_link">New to site?
                                   <a href="#signup" class="to_register"> Create Account </a>
                                   </p> -->
                                <div class="clearfix"></div>
                                <br/>
                                <div style="text-align: center;">
                                    <p>©2025 Law Pro</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@push('js')
    <script src="{{asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/install-validation.js') }}"></script>
@endpush