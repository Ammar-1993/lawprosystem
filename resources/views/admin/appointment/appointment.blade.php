@extends('admin.layout.app')
@section('title', 'Appointment')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/jquery-confirm-master/css/jquery-confirm.css') }}">
@endpush
@section('content')
    <div class="">

        @component('component.heading', [
            'page_title' => __('frontend.appointment.appointment_management'),
            'action' => route('appointment.create'),
            'text' => __('frontend.appointment.add_appointment'),
            'permission' => $adminHasPermition->can(['appointment_add']),
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel lp-panel">

                    <div class="x_title">
                        <div class="row lp-filter-row">
                            <div class="col-md-3 col-sm-6 col-xs-12 form-group lp-form-group">
                                <label for="date_from">{{ __('frontend.appointment.from_date') }}</label>
                                <input type="text" class="form-control lp-input dateFrom" id="date_from" autocomplete="off" readonly="">
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12 form-group lp-form-group">
                                <label for="date_to">{{ __('frontend.appointment.to_date') }}</label>
                                <input type="text" class="form-control lp-input dateTo" id="date_to" autocomplete="off" readonly="">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group lp-form-group lp-filter-actions">
                                <button type="submit" id="search" class="btn btn-success lp-btn lp-btn-primary">
                                    <i class="fa fa-search"></i>&nbsp;{{ __('frontend.appointment.search') }}
                                </button>
                                <button class="btn btn-danger lp-btn lp-btn-danger" type="button" id="btn_clear" name="btn_clear">
                                    {{ __('frontend.appointment.clear') }}
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <div class="table-responsive">
                            <table id="Appointmentdatatable" class="table lp-table appointment_table"
                                data-url="{{ route('appointment.list') }}" width="100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">{{ __('frontend.appointment.no') }}</th>
                                        <th width="26%">{{ __('frontend.appointment.client_name') }}</th>
                                        <th width="15%">{{ __('frontend.appointment.mobile') }}</th>
                                        <th width="13%">{{ __('frontend.appointment.date') }}</th>
                                        <th width="12%">{{ __('frontend.appointment.time') }}</th>
                                        <th width="16%" data-orderable="false">{{ __('frontend.appointment.status') }}</th>
                                        <th width="12%" data-orderable="false" class="text-center">{{ __('frontend.appointment.action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" name="token-value" id="token-value" value="{{ csrf_token() }}">
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
    <input type="hidden" name="common_change_state" id="common_change_state" value="{{ url('common_change_state') }}">

@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('assets/admin/jquery-confirm-master/js/jquery-confirm.js') }}"></script>
    <script src="{{ asset('assets/js/appointment/appointment-datatable.js') }}"></script>
@endpush
