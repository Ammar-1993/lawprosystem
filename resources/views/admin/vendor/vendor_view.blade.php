@extends('admin.layout.app')
@section('title','Vendor Detail')
@section('content')
  <div class="">

    <div class="page-title">
      <div class="title_left">
        <h3>{{ __('frontend.vendor_name') }} : <span>{{$name}}</span></h3>
      </div>


    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                <li role="presentation" class="{{ request()->is('admin/vendor/*') ? 'active' : '' }}"><a href="{{route('vendor.show',$client->id)}}">{{__('frontend.vendor_detail')}}</a>
                </li>

                  @if($adminHasPermition->can(['expense_list']))
                <li role="presentation" class="{{ request()->is('admin/expense-account-list/*') ? 'active' : '' }}"><a href="{{url('admin/expense-account-list/'.$client->id)}}">{{__('frontend.accounts')}}</a>
                </li>
                @endif
              </ul><br><br>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                  <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{__('frontend.name')}}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: @if($client->first_name!=null)  {{ $client->first_name.' '. $client->last_name }} @else {{'N/A'}}@endif </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{__('frontend.mobile')}}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>:  {{ $client->mobile ?? 'N/A' }} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{ __('frontend.GSM') }}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->gst ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{__('frontend.country')}}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->country->name}} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{__('frontend.state')}}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->state->name }} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{__('frontend.city')}}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->city->name }} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{ __('frontend.company_name') }}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->company_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{__('frontend.email_id')}}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->email ?? 'N/A' }} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{ __('frontend.alternate_no') }}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>:{{ $client->alternate_no ?? 'N/A' }} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{ __('frontend.PAN') }}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>:  {{ $client->pan ?? 'N/A' }} </p>
                        </div>
                    </div>
                    <li class="divider"></li>
                    <div class="row">
                        <div class="col-md-5">
                            <p><b>{{ __('frontend.address') }}</b></p>
                        </div>
                        <div class="col-md-7 part">
                            <p>: {{ $client->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <li class="divider"></li>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>

  @include('admin.vendor.payment_made');
  @include('admin.vendor.payment_made_history');
@endsection
