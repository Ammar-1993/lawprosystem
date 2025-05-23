@extends('admin.layout.app')
@section('title', 'Mail Setup')
@push('style')
@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>{{__('frontend.mail_setup')}}</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">

            </div>
        </div>
    </div>
    <form id="mail_setup" name="mail_setup" role="form" method="POST"
        action="{{ route('mail-setup.update', $mailsetup->id) }}" enctype="multipart/form-data" autocomplete="off">
        @csrf()
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="{{ $mailsetup->id }}">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        @include('admin.settings.setting-header')

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="mail_host">{{__('frontend.mail_host')}} <span class="text-danger">*</span></label>
                                <input type="text" required placeholder="" data-msg-required="Please enter mail host"
                                    class="form-control" id="mail_host" name="mail_host"
                                    value="{{ $mailsetup->mail_host }}">
                            </div>


                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="smtp_port">{{__('frontend.mail_port')}} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" data-msg-required="Please enter mail port"
                                    class="form-control" id="smtp_port" name="smtp_port" required
                                    value="{{ $mailsetup->mail_port }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="smtp_username">{{__('frontend.mail_username')}} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" data-msg-required="Please enter mail username"
                                    class="form-control" id="smtp_username" name="smtp_username" required
                                    value="{{ $mailsetup->mail_username }}">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="smtp_password">{{__('frontend.mail_password')}}<span class="text-danger">*</span></label>

                                <input type="text" placeholder="" class="form-control"
                                    data-msg-required="Please enter mail password" id="smtp_password" name="smtp_password"
                                    required value="{{ $mailsetup->mail_password }}">


                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="mail_driver">{{__('frontend.mail_driver')}}<span class="text-danger">*</span></label>
                                <input type="text" placeholder="" data-msg-required="Please enter mail deriver"
                                    class="form-control" id="mail_driver" name="mail_driver" required
                                    value="{{ $mailsetup->mail_driver }}">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="mail_encryption">{{__('frontend.mail_encryption')}}<span class="text-danger">*</span></label>
                                <input type="text" data-msg-required="Please enter mail encryption" placeholder=""
                                    class="form-control" id="mail_encryption" name="mail_encryption" required
                                    value="{{ $mailsetup->mail_encryption }}">
                            </div>

                        </div>


                    </div>


                    <div class="form-group pull-right">
                        <div class="col-md-12 col-sm-6 col-xs-12">

                            <button type="submit" class="btn btn-success" name="btn_add_smtp"><i class="fa fa-save"
                                    id="show_loader"></i>&nbsp;{{__('frontend.save')}}
                            </button>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        </div>
    </form>

@endsection
@push('js')
    <script src="{{ asset('assets/admin/js/selectjs.js') }}"></script>
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
    <script src="{{ asset('assets/js/settings/mail-setup-validation.js') }}"></script>
@endpush
