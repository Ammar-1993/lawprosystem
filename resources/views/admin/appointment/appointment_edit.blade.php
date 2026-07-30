@extends('admin.layout.app')
@section('title', 'Appointment Edit')
@section('content')

    <form id="add_appointment" name="add_appointment" role="form" method="POST" action="{{ route('appointment.update', $appointment->id) }}" autocomplete="off">
        <input name="_method" type="hidden" value="PATCH">
        {{ csrf_field() }}

        <div class="flex items-center justify-between mb-lg">
            <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.edit_appointment') }}</h3>
            <x-action-button variant="primary" href="{{ route('appointment.index') }}">
                {{ __('frontend.back') }}
            </x-action-button>
        </div>

        @include('component.error')

        <x-form-card title="{{ __('frontend.edit_appointment') }}">
            
            @if (count($errors) > 0)
                <div class="bg-danger text-white p-md rounded-md mb-lg">
                    <strong>{{ __('frontend.whoops') }}</strong>{{ __('frontend.there_were_some_problems') }}<br><br>
                    <ul class="ms-md mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Type Selection -->
            <div class="flex items-center gap-xl mb-lg pb-md border-b border-gray-light">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="radio" id="test5" value="new" name="type" class="text-primary focus:ring-primary border-gray-light" @if ($appointment->type == 'new') checked @endif>
                    <span class="ms-2 font-bold text-dark">{{ __('frontend.new_client') }}</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="radio" id="test4" value="exists" name="type" class="text-primary focus:ring-primary border-gray-light" @if ($appointment->type == 'exists') checked @endif>
                    <span class="ms-2 font-bold text-dark">{{ __('frontend.existing_client') }}</span>
                </label>
            </div>

            <!-- Existing Client Dropdown (Shown/Hidden by JS) -->
            <div class="row exists mb-md">
                <div class="col-md-12">
                    <div class="form-group">
                        @if (count($client_list) > 0)
                            <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.select_client') }} <span class="text-danger rest">*</span></label>
                            <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent selct2-width-100" name="exists_client" id="exists_client" onchange="getMobileno(this.value);">
                                <option value="">{{ __('frontend.select_client') }}</option>
                                @foreach ($client_list as $list)
                                    <option value="{{ $list->id }}" @if (!empty($appointment->client_id) && $appointment->client_id == $list->id) selected @endif>
                                        {{ $list->full_name }}
                                    </option>
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
                    <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="new_client" name="new_client" autocomplete="off" value="{{ $appointment->name ?? '' }}">
                </div>
            </div>

            <!-- Detail Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-lg">
                <div class="md:col-span-2">
                    <label for="mobile" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.mobile_no') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="mobile" name="mobile" autocomplete="off" maxlength="10" value="{{ $appointment->mobile }}">
                </div>
                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.date') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="date" name="date" value="{{ date($date_format_laravel, strtotime($appointment->date)) }}">
                </div>
                <div>
                    <label for="time" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.time') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="time" name="time" value="{{ $appointment->time }}">
                </div>
            </div>

            <div class="mb-lg">
                <label for="note" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.note') }}</label>
                <textarea class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="note" name="note" rows="3">{{ $appointment->note ?? '' }}</textarea>
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
    <input type="hidden" name="type_chk" id="type_chk" value="{{ $appointment->type }}">

@endsection

@push('js')
    <script>
        var appointmentValidationMessages = @json(__('backend.appointment'));
    </script>
    <script src="{{ asset('assets/admin/appointment/appointment.js') }}"></script>
    <script src="{{ asset('assets/js/appointment/appointment-validation_edit.js') }}"></script>
@endpush
