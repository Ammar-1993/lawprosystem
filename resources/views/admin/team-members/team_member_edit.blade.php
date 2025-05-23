@extends('admin.layout.app')
@section('title','Member Edit')
@push('style')
    <link href="{{ asset('assets/admin/Image-preview/dist/css/bootstrap-imageupload.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/jcropper/css/cropper.min.css') }}" rel="stylesheet">
@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>{{__('frontend.edit_member')}}</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ url('admin/client_user') }}" class="btn btn-primary">{{__('frontend.back')}}</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_user" name="add_user" role="form" method="POST" enctype="multipart/form-data"
                          action="{{route('client_user.update',$users->id)}}">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" id="id" name="id" value="{{ $users->id}}">
                        <input type="hidden" id="imagebase64" name="imagebase64">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">


                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="imageupload">
                                            <div class="file-tab">
                                                @if($users->profile_img!='')
                                                    <img id="crop_image"
                                                         src='{{asset('public/'.config('constants.CLIENT_FOLDER_PATH') .'/'. $users->profile_img)}}'
                                                         width='100px' height='100px'
                                                         class="crop_image_img"
                                                    >
                                                    <br>
                                                    <label id="remove_crop">
                                                        <input type="checkbox" value="Yes" name="is_remove_image"
                                                               id="is_remove_image">&nbsp;{{__('frontend.remove_feature_image')}}</label>
                                                @else
                                                    <img id="demo_profile" src="{{asset('public/upload/profile.png')}}"
                                                         width='100px' height='100px'
                                                         class="demo_profile"
                                                    >
                                                @endif
                                                <div id="upload-demo" class="upload-demo-img"></div>


                                                <br>

                                                <label class="btn btn-link btn-file">
                                        <span class="fa fa-upload text-center font-15"><span
                                                class="set-profile-picture"> &nbsp; {{__('frontend.set_profile_picture')}}</span>
                                        </span>
                                                    <!-- The file is stored here. -->
                                                    <input type="file" id="upload" name="image" data-src="">

                                                </label>
                                                <button type="button" class="btn btn-default" id="cancel_img">{{__('frontend.cancel')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="f_name">{{__('frontend.first_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="f_name" name="f_name" placeholder="" class="form-control"
                                               value="{{ $users->first_name}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name">{{__('frontend.last_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="l_name" name="l_name" class="form-control"
                                               value="{{ $users->last_name}}">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="email">{{__('frontend.email_id')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" class="form-control"
                                               value="{{ $users->email}}" readonly="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile">{{__('frontend.mobile_no')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="mobile" name="mobile" class="form-control" maxlength="10"
                                               value="{{ $users->mobile}}" readonly="">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-9">
                                        <label for="address">{{__('frontend.address')}} <span class="text-danger">*</span></label>
                                        <input type="text" id="address" name="address" class="form-control"
                                               value="{{ $users->address}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="zipcode">{{__('frontend.zip_code')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="zip_code" name="zip_code" class="form-control"
                                               maxlength="" value="{{ $users->zipcode}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="country">{{__('frontend.country')}}<span class="text-danger">*</span></label>
                                        <select class="form-control select-change country-select2 selct2-width-100"
                                                name="country" id="country"
                                                data-url="{{ route('get.country') }}"
                                                data-clear="#city_id,#state"
                                        >
                                            <option value="">{{__('frontend.select_country')}}</option>
                                            @if ($users->country)
                                                <option value="{{ $users->country->id }}"
                                                        selected>{{ $users->country->name }}</option>
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="state">{{__('frontend.state')}}<span class="text-danger">*</span></label>
                                        <select id="state" name="state"

                                                data-url="{{ route('get.state') }}"
                                                data-target="#country"
                                                data-clear="#city_id"
                                                class="form-control state-select2 select-change">
                                            <option value="">{{__('frontend.select_state')}}</option>
                                            @if ($users->state)
                                                <option value="{{ $users->state->id }}"
                                                        selected>{{ $users->state->name }}</option>
                                            @endif


                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city">{{__('frontend.city')}}<span class="text-danger">*</span></label>
                                        <select id="city_id" name="city_id"
                                                data-url="{{ route('get.city') }}"
                                                data-target="#state"

                                                class="form-control city-select2">
                                            <option value="">{{__('frontend.select_city')}}</option>
                                            @if($users->city)
                                                <option value="{{ $users->city->id }}"
                                                        selected>{{ $users->city->name }}</option>
                                            @endif


                                        </select>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="Role">{{__('frontend.role')}}<span class="text-danger">*</span></label>
                                        <select id="role" name="role" required class="form-control select2">
                                            <option value="">{{__('frontend.select_role')}}</option>
                                            @foreach($roles as $roal)
                                                <option
                                                    value="{{ $roal->id}}" {{ ($users->roles->contains($roal->id) ) ? 'selected=""' : '' }}>{{$roal->slug}}</option>

                                            @endforeach


                                        </select>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <input type="checkbox" id="chk_pass" name="chk_pass" value="yes">{{__('frontend.change_password')}} 
                                    </div>
                                </div>
                                <div class="row form-group chk">

                                    <div class="col-md-6">
                                        <label for="password">{{__('frontend.password')}}  <span class="text-danger">*</span></label>
                                        <input type="password" id="password" name="password" class="form-control"
                                               autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cnm_password">{{__('frontend.confirm_password')}}<span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="cnm_password" name="cnm_password"
                                               class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a class="btn btn-danger" href="{{ url('admin/client_user') }}">{{__('frontend.cancel')}}</a>
                                    <button type="submit" class="btn btn-success" id="upload-result"><i
                                            class="fa fa-save" id="show_loader"></i>&nbsp;{{__('frontend.save')}}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">
    <input type="hidden" name="check_user_email_exits"
           id="check_user_email_exits"
           value="{{ url('admin/check_user_email_exits') }}">
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{ asset('assets/admin/jcropper/js/cropper.min.js') }}"></script>
    <script src="{{ asset('assets/js/profile/image-crop.js') }}"></script>
    {{-- START: Added code to pass translations --}}
    <script>
        // Use translations from 'backend.member' keys
        var memberValidationMessages = @json(__('backend.member'));
        // If you created member.php, use: @json(__('member'))

        // Make sure common JS translations are also available if not globally included
        // You might already have this in your main layout
        if (typeof commonJsLang === 'undefined') {
            var commonJsLang = @json(__('backend.common_js'));
        }
    </script>
    {{-- END: Added code --}}
    <script src="{{asset('assets/js/team_member/member-validation_edit.js')}}"></script>

@endpush
