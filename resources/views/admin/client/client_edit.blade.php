@extends('admin.layout.app')
@section('title', 'Client Edit')

@section('content')
    <div class="flex items-center justify-between mb-lg">
        <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.client.edit_client') }}</h3>
        <x-action-button variant="primary" href="{{ route('clients.index') }}">
            {{ __('frontend.back') }}
        </x-action-button>
    </div>

    @include('component.error')

    <form id="edit_client_form" name="edit_client_form" role="form" method="POST" action="{{ route('clients.update', $client->id) }}">
        <input type="hidden" id="id" value="{{ $client->id }}" name="id">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">

        @if (count($errors) > 0)
            <div class="bg-danger text-white p-md rounded-md mb-lg">
                <strong>{{ __('frontend.client.whoops') }}</strong> {{ __('frontend.client.there_were_some_problems') }}<br><br>
                <ul class="ms-md mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-form-card title="Personal Information">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="f_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.first_name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="f_name" name="f_name" value="{{ $client->first_name ?? '' }}">
                </div>
                <div>
                    <label for="m_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.middle_name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="m_name" name="m_name" value="{{ $client->middle_name ?? '' }}">
                </div>
                <div>
                    <label for="l_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.last_name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="l_name" name="l_name" value="{{ $client->last_name ?? '' }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.gender') }} <span class="text-danger">*</span></label>
                    <div class="flex items-center gap-md pt-xs">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" id="genderM" value="Male" {{ (!empty($client->gender) && $client->gender == 'Male') ? 'checked' : '' }} class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">{{ __('frontend.client.male') }}</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" id="genderF" value="Female" {{ (!empty($client->gender) && $client->gender == 'Female') ? 'checked' : '' }} class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">{{ __('frontend.client.female') }}</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.email') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="email" name="email" value="{{ $client->email ?? '' }}">
                </div>
                <div>
                    <label for="mobile" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.mobile_no') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="mobile" name="mobile" value="{{ $client->mobile ?? '' }}" maxlength="10">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-lg">
                <div class="md:col-span-1">
                    <label for="alternate_no" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.alternate_no') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="alternate_no" name="alternate_no" value="{{ $client->alternate_no ?? '' }}" maxlength="10">
                </div>
                <div class="md:col-span-3">
                    <label for="address" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.address') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="address" name="address" value="{{ $client->address ?? '' }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="country" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.country') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent select-change country-select2" name="country" id="country" data-url="{{ route('get.country') }}" data-clear="#city_id,#state">
                        <option value="">{{ __('frontend.client.select_country') }}</option>
                        @if ($client->country)
                            <option value="{{ $client->country->id }}" selected>{{ $client->country->name }}</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label for="state" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.state') }} <span class="text-danger">*</span></label>
                    <select id="state" name="state" data-url="{{ route('get.state') }}" data-target="#country" data-clear="#city_id" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent state-select2 select-change">
                        <option value="">{{ __('frontend.client.select_state') }}</option>
                        @if ($client->state)
                            <option value="{{ $client->state->id }}" selected>{{ $client->state->name }}</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label for="city_id" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.city') }} <span class="text-danger">*</span></label>
                    <select id="city_id" name="city_id" data-url="{{ route('get.city') }}" data-target="#state" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent city-select2">
                        <option value="">{{ __('frontend.client.select_city') }}</option>
                        @if ($client->city)
                            <option value="{{ $client->city->id }}" selected>{{ $client->city->name }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg">
                <div>
                    <label for="reference_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.reference_name') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="reference_name" name="reference_name" value="{{ $client->reference_name ?? '' }}">
                </div>
                <div>
                    <label for="reference_mobile" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.reference_mobile') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="reference_mobile" name="reference_mobile" value="{{ $client->reference_mobile ?? '' }}">
                </div>
            </div>
            
            <div id="change_court_div" class="hidden mt-md">
                <div class="mb-md">
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.clientf') }} <span class="text-danger">*</span></label>
                    <div class="flex items-center gap-md pt-xs">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="type" id="test6" value="single" {{ (!empty($client->client_type) && $client->client_type == 'single') ? 'checked' : '' }} class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">Single Advocate</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="type" id="test7" value="multiple" {{ (!empty($client->client_type) && $client->client_type == 'multiple') ? 'checked' : '' }} class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">Multiple Advocate</span>
                        </label>
                    </div>
                </div>

                <!-- Single Advocate Repeater -->
                <div class="repeater one bg-gray-50 p-md rounded-md mb-md border border-gray-light">
                    <div data-repeater-list="group-a">
                        @if (!empty($client_parties_invoive) && count($client_parties_invoive) > 0 && $client->client_type == 'single')
                            @foreach ($client_parties_invoive as $key => $value)
                                <div data-repeater-item class="grid grid-cols-1 md:grid-cols-12 gap-md mb-md pb-md border-b border-gray-light last:border-0">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.first_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="firstname" name="firstname" data-rule-required="true" data-msg-required="Please enter first name.999" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_firstname }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.middle_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="middlename" name="middlename" data-rule-required="true" data-msg-required="Please enter middle name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_middlename }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.last_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="lastname" name="lastname" data-rule-required="true" data-msg-required="Please enter last name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_lastname }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.mobile_no')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="mobile_client" name="mobile_client" data-rule-required="true" data-msg-required="Please enter mobile number." data-rule-number="true" data-msg-number="please enter digit 0-9." data-rule-minlength="10" data-msg-minlength="mobile must be 10 digit." data-rule-maxlength="10" data-msg-maxlength="mobile must be 10 digit." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_mobile }}" maxlength="10">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">Address <span class="text-danger">*</span></label>
                                        <input type="text" id="address_client" name="address_client" data-rule-required="true" data-msg-required="Please enter address." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_address }}">
                                    </div>
                                    <div class="md:col-span-1 flex items-end">
                                        <x-action-button variant="danger" data-repeater-delete type="button" class="w-full py-2">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </x-action-button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div data-repeater-item class="grid grid-cols-1 md:grid-cols-12 gap-md mb-md pb-md border-b border-gray-light last:border-0">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.first_name')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="firstname" name="firstname" data-rule-required="true" data-msg-required="Please enter first name.101010" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.middle_name')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="middlename" name="middlename" data-rule-required="true" data-msg-required="Please enter middle name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.last_name')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="lastname" name="lastname" data-rule-required="true" data-msg-required="Please enter last name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.mobile_no')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="mobile_client" name="mobile_client" data-rule-required="true" data-msg-required="Please enter mobile number." data-rule-number="true" data-msg-number="please enter digit 0-9." data-rule-minlength="10" data-msg-minlength="mobile must be 10 digit." data-rule-maxlength="10" data-msg-maxlength="mobile must be 10 digit." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" maxlength="10">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">Address <span class="text-danger">*</span></label>
                                    <input type="text" id="address_client" name="address_client" data-rule-required="true" data-msg-required="Please enter address." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-1 flex items-end">
                                    <x-action-button variant="danger" data-repeater-delete type="button" class="w-full py-2">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </x-action-button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <x-action-button variant="success" data-repeater-create type="button">
                        <i class="fa fa-plus me-1" aria-hidden="true"></i> {{ __('frontend.client.add_new') }}
                    </x-action-button>
                </div>

                <!-- Multiple Advocate Repeater -->
                <div class="repeater two bg-gray-50 p-md rounded-md mb-md border border-gray-light">
                    <div data-repeater-list="group-b">
                        @if (!empty($client_parties_invoive) && count($client_parties_invoive) > 0 && $client->client_type == 'multiple')
                            @foreach ($client_parties_invoive as $key => $value)
                                <div data-repeater-item class="grid grid-cols-1 md:grid-cols-12 gap-md mb-md pb-md border-b border-gray-light last:border-0">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.first_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="firstname" name="firstname" data-rule-required="true" data-msg-required="Please enter name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_firstname }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.middle_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="middlename" name="middlename" data-rule-required="true" data-msg-required="Please enter name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_middlename }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.last_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="lastname" name="lastname" data-rule-required="true" data-msg-required="Please enter name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_lastname }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.mobile_no')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="mobile_client" name="mobile_client" data-rule-required="true" data-msg-required="Please enter mobile number." data-rule-number="true" data-msg-number="please enter digit 0-9." data-rule-minlength="10" data-msg-minlength="mobile must be 10 digit." data-rule-maxlength="10" data-msg-maxlength="mobile must be 10 digit." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_mobile }}" maxlength="10">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.address')}} <span class="text-danger">*</span></label>
                                        <input type="text" id="address_client" name="address_client" data-rule-required="true" data-msg-required="Please enter address." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_address }}">
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.advocate_name')}} <span class="text-danger">*</span></label>
                                        <input type="text" id="advocate_name" name="advocate_name" data-rule-required="true" data-msg-required={{__('frontend.party_advocate')}} class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" value="{{ $value->party_advocate }}">
                                    </div>
                                    <div class="md:col-span-1 flex items-end">
                                        <x-action-button variant="danger" data-repeater-delete type="button" class="w-full py-2">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </x-action-button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div data-repeater-item class="grid grid-cols-1 md:grid-cols-12 gap-md mb-md pb-md border-b border-gray-light last:border-0">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.first_name')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="firstname" name="firstname" data-rule-required="true" data-msg-required="Please enter name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.middle_name')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="middlename" name="middlename" data-rule-required="true" data-msg-required="Please enter name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.last_name')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="lastname" name="lastname" data-rule-required="true" data-msg-required="Please enter name." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.mobile_no')}}<span class="text-danger">*</span></label>
                                    <input type="text" id="mobile_client" name="mobile_client" data-rule-required="true" data-msg-required="Please enter mobile number." data-rule-number="true" data-msg-number="please enter digit 0-9." data-rule-minlength="10" data-msg-minlength="mobile must be 10 digit." data-rule-maxlength="10" data-msg-maxlength="mobile must be 10 digit." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" maxlength="10">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.address')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="address_client" name="address_client" data-rule-required="true" data-msg-required="Please enter address." class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{__('frontend.advocate_name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="advocate_name" name="advocate_name" data-rule-required="true" data-msg-required={{__('frontend.party_advocate')}} class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                                </div>
                                <div class="md:col-span-1 flex items-end">
                                    <x-action-button variant="danger" data-repeater-delete type="button" class="w-full py-2">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </x-action-button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <x-action-button variant="success" data-repeater-create type="button">
                        <i class="fa fa-plus me-1" aria-hidden="true"></i> {{ __('frontend.client.add_new') }}
                    </x-action-button>
                </div>
            </div>

            <x-slot name="footer">
                <x-action-button variant="danger" href="{{ route('clients.index') }}">
                    {{ __('frontend.cancel') }}
                </x-action-button>
                <x-action-button variant="success" type="submit">
                    <i class="fa fa-save me-1" id="show_loader"></i> {{ __('frontend.save') }}
                </x-action-button>
            </x-slot>
        </x-form-card>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/selectjs.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/repeter/repeater.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script>
        var validationMessages = @json(__('backend.client'));
    </script>
    <script src="{{ asset('assets/js/client/edit-client-validation.js') }}"></script>
    
    @if (!empty($client->client_type) && $client->client_type == 'single')
        <script type="text/javascript">
            'use strict';
            $('.two').css('display', 'none');
        </script>
    @endif
    @if (!empty($client->client_type) && $client->client_type == 'multiple')
        <script type="text/javascript">
            'use strict';
            $('.one').css('display', 'none');
        </script>
    @endif
    @if ( (!empty($client_parties_invoive) && count($client_parties_invoive) > 0) )
        <script type="text/javascript">
            'use strict';
            $('#change_court_div').removeClass('hidden');
            $('#change_court_chk').prop('checked', true);
        </script>
    @endif
@endpush
