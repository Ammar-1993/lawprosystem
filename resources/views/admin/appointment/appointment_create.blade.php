@extends('admin.layout.app')
@section('title', 'Appointment Add')
@section('content')

    <form id="add_appointment" name="add_appointment" role="form" method="POST" action="{{ route('appointment.store') }}" enctype="multipart/form-data" autocomplete="off">
        {{ csrf_field() }}

        <div class="flex items-center justify-between mb-lg">
            <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.appointment.add_appointment') }}</h3>
            <x-action-button variant="primary" href="{{ route('appointment.index') }}">
                {{ __('frontend.back') }}
            </x-action-button>
        </div>

        @include('component.error')

        <x-form-card title="{{ __('frontend.appointment.add_appointment') }}">
            
            <!-- Type Selection -->
            <div class="flex items-center gap-xl mb-lg pb-md border-b border-gray-light">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="radio" id="test5" value="new" name="type" checked class="text-primary focus:ring-primary border-gray-light">
                    <span class="ms-2 font-bold text-dark">{{ __('frontend.new_client') }}</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="radio" id="test4" value="exists" name="type" class="text-primary focus:ring-primary border-gray-light">
                    <span class="ms-2 font-bold text-dark">{{ __('frontend.existing_client') }}</span>
                </label>
            </div>

            <!-- Existing Client Dropdown (Shown/Hidden by JS) -->
            <div class="row exists mb-md">
                <div class="col-md-12">
                    <div class="form-group">
                        @if (!empty($client_list) && count($client_list) > 0)
                            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.select_client') }} <span class="text-danger rest">*</span></label>
                            <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent selct2-width-100" name="exists_client" id="exists_client" onchange="getMobileno(this.value);">
                                <option value="">{{ __('frontend.select_client') }}</option>
                                @foreach ($client_list as $list)
                                    <option value="{{ $list->id }}">{{ $list->full_name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            </div>

            <!-- New Client Input (Shown/Hidden by JS) -->
            <div class="row new mb-md">
                <div class="col-md-12 form-group">
                    <label for="new_client" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.new_client_name') }} <span class="text-danger">*</span></label>
                    <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="new_client" name="new_client" autocomplete="off">
                </div>
            </div>

            <!-- Detail Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-lg">
                <div class="md:col-span-2">
                    <label for="mobile" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.mobile_no') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="mobile" name="mobile" autocomplete="off" maxlength="10">
                </div>
                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.date') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="date" name="date">
                </div>
                <div>
                    <label for="time" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.time') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="time" name="time">
                </div>
            </div>

            <div class="mb-lg">
                <label for="note" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.note') }}</label>
                <textarea class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="note" name="note" rows="3"></textarea>
            </div>

            <x-slot name="footer">
                <x-action-button variant="danger" href="{{ route('appointment.index') }}">
                    {{ __('frontend.cancel') }}
                </x-action-button>
                <x-action-button variant="success" type="submit">
                    <i class="fa fa-save me-1" id="show_loader"></i> {{ __('frontend.save') }}
                </x-action-button>
            </x-slot>
        </x-form-card>
    </form>

    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
    <input type="hidden" name="getMobileno" id="getMobileno" value="{{ route('getMobileno') }}">

@endsection

@push('js')
    <script>
        var appointmentValidationMessages = @json(__('backend.appointment'));
    </script>
    <script src="{{ asset('assets/admin/appointment/appointment.js') }}"></script>
    <script src="{{ asset('assets/js/appointment/appointment-validation.js') }}"></script>
@endpush
