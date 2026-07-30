@extends('admin.layout.app')
@section('title', 'Client Create')

@section('content')
    <div class="flex items-center justify-between mb-lg">
        <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.client.add_client') }}</h3>
        <x-action-button variant="primary" href="{{ route('clients.index') }}">
            {{ __('frontend.back') }}
        </x-action-button>
    </div>

    @include('component.error')

    <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope" action="{{ route('clients.store') }}">
        {{ csrf_field() }}

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
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="f_name" name="f_name">
                </div>
                <div>
                    <label for="m_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.middle_name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="m_name" name="m_name">
                </div>
                <div>
                    <label for="l_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.last_name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="l_name" name="l_name">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.gender') }} <span class="text-danger">*</span></label>
                    <div class="flex items-center gap-md pt-xs">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" id="genderM" value="Male" checked required class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">{{ __('frontend.client.male') }}</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" id="genderF" value="Female" class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">{{ __('frontend.client.female') }}</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.email') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="email" name="email">
                </div>
                <div>
                    <label for="mobile" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.mobile_no') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="mobile" maxlength="10" name="mobile">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-lg">
                <div class="md:col-span-1">
                    <label for="alternate_no" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.alternate_no') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="alternate_no" name="alternate_no" maxlength="10">
                </div>
                <div class="md:col-span-3">
                    <label for="address" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.address') }} <span class="text-danger">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="address" name="address">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="country" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.country') }} <span class="text-danger">*</span></label>
                    <!-- IMPORTANT: select-change and country-select2 and data attrs MUST stay -->
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent select-change country-select2" name="country" id="country" data-url="{{ route('get.country') }}" data-clear="#city_id,#state">
                        <option value="">{{ __('frontend.client.select_country') }}</option>
                    </select>
                </div>
                <div>
                    <label for="state" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.state') }} <span class="text-danger">*</span></label>
                    <select id="state" name="state" data-url="{{ route('get.state') }}" data-target="#country" data-clear="#city_id" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent state-select2 select-change">
                        <option value="">{{ __('frontend.client.select_state') }}</option>
                    </select>
                </div>
                <div>
                    <label for="city_id" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.city') }} <span class="text-danger">*</span></label>
                    <select id="city_id" name="city_id" data-url="{{ route('get.city') }}" data-target="#state" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent city-select2">
                        <option value="">{{ __('frontend.client.select_city') }}</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg">
                <div>
                    <label for="reference_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.reference_name') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="reference_name" name="reference_name">
                </div>
                <div>
                    <label for="reference_mobile" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.reference_mobile') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="reference_mobile" name="reference_mobile">
                </div>
            </div>

            <div class="mt-lg pt-md border-t border-gray-light">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="Yes" name="change_court_chk" id="change_court_chk" class="text-primary focus:ring-primary border-gray-light rounded">
                    <span class="ms-2 font-semibold text-dark">{{ __('frontend.client.add_more_person') }}</span>
                </label>
            </div>
            
            <div id="change_court_div" class="hidden mt-md">
                <div class="mb-md">
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.client') }} <span class="text-danger">*</span></label>
                    <div class="flex items-center gap-md pt-xs">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="type" id="test6" value="single" checked required class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">{{ __('frontend.client.single_client') }}</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="type" id="test7" value="multiple" class="text-primary focus:ring-primary border-gray-light">
                            <span class="ms-2 text-sm text-dark">{{ __('frontend.client.multiple_client') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Single Advocate Repeater -->
                <div class="repeater one bg-gray-50 p-md rounded-md mb-md border border-gray-light">
                    <div data-repeater-list="group-a">
                        <div data-repeater-item class="grid grid-cols-1 md:grid-cols-12 gap-md mb-md pb-md border-b border-gray-light last:border-0">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.first_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="firstname" name="firstname" data-rule-required="true" data-msg-required="{{ __('backend.client.f_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.middle_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="middlename" name="middlename" data-rule-required="true" data-msg-required="{{ __('backend.client.m_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.last_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="lastname" name="lastname" data-rule-required="true" data-msg-required="{{ __('backend.client.l_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.mobile_no') }} <span class="text-danger">*</span></label>
                                <input type="text" id="mobile_client" name="mobile_client" data-rule-required="true" data-msg-required="{{ __('backend.client.mobile.required') }}" data-rule-number="true" data-msg-number="{{ __('backend.client.mobile.minlength') }}" data-rule-minlength="10" data-msg-minlength="{{ __('backend.client.mobile.maxlength') }}" data-rule-maxlength="10" data-msg-maxlength="{{ __('backend.client.mobile.number') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" maxlength="10">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.address') }} <span class="text-danger">*</span></label>
                                <input type="text" id="address_client" name="address_client" data-rule-required="true" data-msg-required="{{ __('backend.client.address') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-1 flex items-end">
                                <x-action-button variant="danger" data-repeater-delete type="button" class="w-full py-2">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </x-action-button>
                            </div>
                        </div>
                    </div>
                    <x-action-button variant="success" data-repeater-create type="button">
                        <i class="fa fa-plus me-1" aria-hidden="true"></i> {{ __('frontend.client.add_new') }}
                    </x-action-button>
                </div>

                <!-- Multiple Advocate Repeater -->
                <div class="repeater two bg-gray-50 p-md rounded-md mb-md border border-gray-light">
                    <div data-repeater-list="group-b">
                        <div data-repeater-item class="grid grid-cols-1 md:grid-cols-12 gap-md mb-md pb-md border-b border-gray-light last:border-0">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.first_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="firstname" name="firstname" data-rule-required="true" data-msg-required="{{ __('backend.client.f_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.middle_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="middlename" name="middlename" data-rule-required="true" data-msg-required="{{ __('backend.client.m_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.last_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="lastname" name="lastname" data-rule-required="true" data-msg-required="{{ __('backend.client.l_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.mobile_no') }} <span class="text-danger">*</span></label>
                                <input type="text" id="mobile_client" name="mobile_client" data-rule-required="true" data-msg-required="{{ __('backend.client.mobile.required') }}" data-rule-number="true" data-msg-number="{{ __('backend.client.mobile.minlength') }}" data-rule-minlength="10" data-msg-minlength="{{ __('backend.client.mobile.maxlength') }}" data-rule-maxlength="10" data-msg-maxlength="{{ __('backend.client.mobile.number') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" maxlength="10">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.address') }} <span class="text-danger">*</span></label>
                                <input type="text" id="address_client" name="address_client" data-rule-required="true" data-msg-required="{{ __('backend.client.address') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.client.advocate_name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="advocate_name" name="advocate_name" data-rule-required="true" data-msg-required="{{ __('frontend.client.advocate_name') }}" class="w-full px-3 py-2 text-sm border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent">
                            </div>
                            <div class="md:col-span-1 flex items-end">
                                <x-action-button variant="danger" data-repeater-delete type="button" class="w-full py-2">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </x-action-button>
                            </div>
                        </div>
                    </div>
                    <x-action-button variant="success" data-repeater-create type="button">
                        <i class="fa fa-plus me-1" aria-hidden="true"></i> {{ __('frontend.client.add_new') }}
                    </x-action-button>
                </div>
            </div>

            <x-slot name="footer">
                <input type="hidden" name="route-exist-check" id="route-exist-check" value="{{ url('admin/check_client_email_exits') }}">
                <input type="hidden" name="token-value" id="token-value" value="{{ csrf_token() }}">
                
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
    <script src="{{ asset('assets/js/client/add-client-validation.js') }}"></script>
@endpush
