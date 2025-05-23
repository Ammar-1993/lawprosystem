@extends('admin.layout.app')
@section('title', 'Client Edit')
@section('content')
    @component('component.heading', [
        'page_title' => __('frontend.client.edit_client'),
        'action' => route('clients.index'),
        'text' => __('frontend.back'),
    ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <form id="edit_client_form" name="edit_client_form" role="form" method="POST"
                    action="{{ route('clients.update', $client->id) }}">
                    <input type="hidden" id="id" value="{{ $client->id }}" name="id">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH">
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="f_name">{{ __('frontend.client.first_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="f_name" name="f_name"
                                    value="{{ $client->first_name ?? '' }}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="m_name">{{ __('frontend.client.middle_name') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="m_name" name="m_name"
                                    value="{{ $client->middle_name ?? '' }}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.last_name') }}  <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="l_name" name="l_name"
                                    value="{{ $client->last_name ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.gender') }} <span class="text-danger">*</span></label><br>

                                <input type="radio" name="gender" id="genderM" value="Male"
                                    {{ !empty($client->gender) && $client->gender == 'Male' ? 'checked' : '' }} />
                                &nbsp;&nbsp;{{ __('frontend.client.male') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" id="genderF" value="Female"
                                    {{ !empty($client->gender) && $client->gender == 'Female' ? 'checked' : '' }} />&nbsp;&nbsp; {{ __('frontend.client.female') }}
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.email') }}</label>
                                <input type="text" value="{{ $client->email ?? '' }}" placeholder="" class="form-control"
                                    id="email" name="email">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.mobile_no') }}  <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="mobile" name="mobile"
                                    value="{{ $client->mobile ?? '' }}" maxlength="10">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.alternate_no') }}</label>
                                <input type="text" value="{{ $client->alternate_no ?? '' }}" placeholder=""
                                    class="form-control" id="alternate_no" name="alternate_no" maxlength="10">
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.address') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" value="{{ $client->address ?? '' }}"
                                    class="form-control" id="address" name="address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.country') }} <span class="text-danger">*</span></label>
                                <select class="form-control select-change country-select2 selct2-width-100 " name="country"
                                    id="country" data-url="{{ route('get.country') }}" data-clear="#city_id,#state">
                                    <option value=""> {{ __('frontend.client.select_country') }}</option>
                                    @if ($client->country)
                                        <option value="{{ $client->country->id }}" selected>{{ $client->country->name }}
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.state') }} <span class="text-danger">*</span></label>
                                <select id="state" name="state" data-url="{{ route('get.state') }}"
                                    data-target="#country" data-clear="#city_id"
                                    class="form-control state-select2 select-change">
                                    <option value=""> {{ __('frontend.client.select_state') }}</option>
                                    @if ($client->state)
                                        <option value="{{ $client->state->id }}" selected>{{ $client->state->name }}
                                        </option>
                                    @endif

                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.city') }} <span class="text-danger">*</span></label>
                                <select id="city_id" name="city_id" data-url="{{ route('get.city') }}"
                                    data-target="#state" class="form-control city-select2">
                                    <option value=""> {{ __('frontend.client.select_city') }}</option>
                                    @if ($client->city)
                                        <option value="{{ $client->city->id }}" selected>{{ $client->city->name }}
                                        </option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.reference_name') }} </label>
                                <input type="text" placeholder="" class="form-control" id="reference_name"
                                    name="reference_name" value="{{ $client->reference_name ?? '' }}">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.client.reference_mobile') }}</label>
                                <input type="text" placeholder="" class="form-control" id="reference_mobile"
                                    name="reference_mobile" value="{{ $client->reference_mobile ?? '' }}">
                            </div>


                        </div>

                        {{-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <br>
                            <input type="checkbox" value="Yes" name="change_court_chk" id="change_court_chk"> Add
                            more
                            person
                            <br />

                        </div> --}}
                        <div id="change_court_div" class="hidden">

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="fullname">{{__('frontend.clientf')}}<span class="text-danger">*</span></label><br>
                                    <br>
                                    <input type="radio" name="type" id="test6" value="single"
                                        {{ !empty($client->client_type) && $client->client_type == 'single' ? 'checked' : '' }} />
                                    &nbsp;&nbsp;Single Advocate:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="type" id="test7" value="multiple"
                                        {{ !empty($client->client_type) && $client->client_type == 'multiple' ? 'checked' : '' }} />&nbsp;&nbsp;Multiple
                                    Advocate
                                </div>
                            </div>
                            <div class="repeater one">
                                <div data-repeater-list="group-a">
                                    @if (!empty($client_parties_invoive) && count($client_parties_invoive) > 0 && $client->client_type == 'single')
                                        @foreach ($client_parties_invoive as $key => $value)
                                            <div data-repeater-item>
                                                <div class="row border-addmore">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.first_name')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="firstname" name="firstname"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter first name.999"
                                                            class="form-control" value="{{ $value->party_firstname }}">
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.middle_name')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="middlename" name="middlename"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter middle name."
                                                            class="form-control" value="{{ $value->party_middlename }}">
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.last_name')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="lastname" name="lastname"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter last name."
                                                            class="form-control" value="{{ $value->party_lastname }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.mobile_no')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="mobile_client" name="mobile_client"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter mobile number."
                                                            data-rule-number="true"
                                                            data-msg-number="please enter digit 0-9."
                                                            data-rule-minlength="10"
                                                            data-msg-minlength="mobile must be 10 digit."
                                                            data-rule-maxlength="10"
                                                            data-msg-maxlength="mobile must be 10 digit."
                                                            class="form-control" value="{{ $value->party_mobile }}"
                                                            maxlength="10">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Address <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="address_client" name="address_client"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter address." class="form-control"
                                                            value="{{ $value->party_address }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                            class="btn btn-danger"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item>
                                            <div class="row border-addmore">
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.first_name')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="firstname" name="firstname"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter first name.101010"
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.middle_name')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="middlename" name="middlename"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter middle name."
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.last_name')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="lastname" name="lastname"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter last name." class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.mobile_no')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="mobile_client" name="mobile_client"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter mobile number."
                                                        data-rule-number="true" data-msg-number="please enter digit 0-9."
                                                        data-rule-minlength="10"
                                                        data-msg-minlength="mobile must be 10 digit."
                                                        data-rule-maxlength="10"
                                                        data-msg-maxlength="mobile must be 10 digit." class="form-control"
                                                        maxlength="10">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="address_client" name="address_client"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter address." class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <br>
                                                    <button type="button" data-repeater-delete type="button"
                                                        class="btn btn-danger"><i class="fa fa-trash-o"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <br>
                                    <button data-repeater-create type="button" value="Add New"
                                        class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                        type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="repeater two">
                                <div data-repeater-list="group-b">
                                    @if (!empty($client_parties_invoive) && count($client_parties_invoive) > 0 && $client->client_type == 'multiple')
                                        @foreach ($client_parties_invoive as $key => $value)
                                            <div data-repeater-item>
                                                <div class="row border-addmore">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.first_name')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="firstname" name="firstname"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter name." class="form-control"
                                                            value="{{ $value->party_firstname }}">
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.middle_name')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="middlename" name="middlename"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter name." class="form-control"
                                                            value="{{ $value->party_middlename }}">
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.last_name')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="lastname" name="lastname"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter name." class="form-control"
                                                            value="{{ $value->party_lastname }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.mobile_no')}}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="mobile_client" name="mobile_client"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter mobile number."
                                                            data-rule-number="true"
                                                            data-msg-number="please enter digit 0-9."
                                                            data-rule-minlength="10"
                                                            data-msg-minlength="mobile must be 10 digit."
                                                            data-rule-maxlength="10"
                                                            data-msg-maxlength="mobile must be 10 digit."
                                                            class="form-control" value="{{ $value->party_mobile }}"
                                                            maxlength="10">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.address')}} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="address_client" name="address_client"
                                                            data-rule-required="true"
                                                            data-msg-required="Please enter address." class="form-control"
                                                            value="{{ $value->party_address }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">{{__('frontend.advocate_name')}} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="advocate_name" name="advocate_name"
                                                            data-rule-required="true"
                                                            data-msg-required={{__('frontend.party_advocate')}}
                                                            class="form-control" value="{{ $value->party_advocate }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item>
                                            <div class="row border-addmore">
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.first_name')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="firstname" name="firstname"
                                                        data-rule-required="true" data-msg-required="Please enter name."
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.middle_name')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="middlename" name="middlename"
                                                        data-rule-required="true" data-msg-required="Please enter name."
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.last_name')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="lastname" name="lastname"
                                                        data-rule-required="true" data-msg-required="Please enter name."
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.mobile_no')}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="mobile_client" name="mobile_client"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter mobile number."
                                                        data-rule-number="true" data-msg-number="please enter digit 0-9."
                                                        data-rule-minlength="10"
                                                        data-msg-minlength="mobile must be 10 digit."
                                                        data-rule-maxlength="10"
                                                        data-msg-maxlength="mobile must be 10 digit." class="form-control"
                                                        maxlength="10">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.address')}} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="address_client" name="address_client"
                                                        data-rule-required="true"
                                                        data-msg-required="Please enter address." class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">{{__('frontend.advocate_name')}} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="advocate_name" name="advocate_name"
                                                        data-rule-required="true"
                                                        data-msg-required={{__('frontend.party_advocate')}}
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <br>
                                                    <button type="button" data-repeater-delete type="button"
                                                        class="btn btn-danger waves-effect waves-light"><i
                                                            class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </div>

                                            </div>

                                        </div>

                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <br>
                                    <button data-repeater-create type="button" value="{{ __('frontend.client.add_new') }}"
                                        class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                        type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a href="{{ route('clients.index') }}"
                                    class="btn btn-danger">{{ __('frontend.cancel') }}</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                        id="show_loader"></i>&nbsp;{{ __('frontend.save') }}
                                </button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/admin/js/selectjs.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/repeter/repeater.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/jquery-ui/jquery-ui.js') }}"></script>
    {{-- START: Added code to pass translations --}}
    <script>
        // Use the translations from 'backend.client' keys
        // Assumes keys are in resources/lang/*/backend.php
        var validationMessages = @json(__('backend.client'));
    </script>
    {{-- END: Added code --}}
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
    @if (
        (!empty($client_parties_invoive) && count($client_parties_invoive) > 0) ||
            (!empty($client_parties_invoive) && count($client_parties_invoive) > 0))
        <script type="text/javascript">
            'use strict';
            $('#change_court_div').removeClass('hidden');
            $('#change_court_chk').prop('checked', true);
        </script>
    @endif

@endpush
