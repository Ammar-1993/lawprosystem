<br>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li class="{{ Request::segment(2)=='general-setting' ? 'active' :'' }}" role="presentation"><a
                href="{{ url('admin/general-setting') }}">{{__('frontend.company_details')}}</a>
        </li>
        <li class="{{ Request::segment(2)=='date-timezone' ? 'active' :'' }}"
            role="presentation" class=""><a href="{{ url('admin/date-timezone') }}">{{__('frontend.date_time_zone')}}</a>

        </li>

        <li class="{{ Request::segment(2)=='mail-setup' ? 'active' :'' }}"
            role="presentation" class=""><a href="{{ url('admin/mail-setup') }}">{{__('frontend.mail_setup')}}</a>
        </li>

        <li class="{{ Request::segment(2)=='invoice-setting' ? 'active' :'' }}" role="presentation" class=""><a
                href="{{ url('admin/invoice-setting') }}">{{__('frontend.invoice_setting')}}</a>
        </li>
    </ul>

</div>
