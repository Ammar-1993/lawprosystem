@extends('admin.layout.app')
@section('title','Expense')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>{{__('frontend.manage_expense')}}</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">

                @if($adminHasPermition->can(['expense_add']))
                    <a href="{{ url('admin/expense-create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('frontend.add_expense')}}</a>
                @endif


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">

                    <table id="ExpenseDatatable" class="table" >
                        <thead>
                        <tr>

                            <th width="3%;">{{__('frontend.no')}}</th>
                            <th width="15%">{{__('frontend.invoice_no')}}</th>
                            <th width="30%">{{__('frontend.vendor1')}}</th>
                            <th width="10%">{{__('frontend.total')}}</th>
                            <th width="10%">{{__('frontend.paid')}}</th>
                            <th width="15%">{{__('frontend.due')}}</th>
                            <th width="5%">{{__('frontend.status')}}</th>
                            <th width="5%;">{{__('frontend.action')}}</th>

                        </tr>
                        </thead>


                    </table>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>

    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">

    <input type="hidden" name="expense-list"
           id="expense-list"
           value="{{ url('admin/expense-list') }}">

@endsection

@push('js')
    <script src="{{asset('assets/js/expense/expense-datatable.js')}}"></script>
@endpush

