@extends('admin.layout.app')
@section('title','Client View')
@section('content')
    <div class="row">
        <!-- Section Right Part Start -->
        <!-- Col-md-6 Start -->
        <div class="col-md-12">
            <div class="x_panel">
                <div class="right-part-bg-all">
                    <div class="ctzn-usrs">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a href="" title="Print invoice"><i class="fa fa-print fa-2x pull-right"
                                                                    aria-hidden="true"></i></a>
                                <a href=""><i class="fa fa-envelope-o fa-2x pull-right" aria-hidden="true"></i></a>
                                <div class="clearfix">
                                </div>
                            </div>
                        </div>
                        <h1 class="invoice-center">{{ __('frontend.client.invoice') }}</h1>
                        <div class="row">
                            <div class="col-xs-12">

                                <div class="invoice-title">
                                    <h3 class="pull-right">{{ __('frontend.client.invoice_no') }}: INV-000015</h3>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <address>
                                            <div>

                                                <div class="discount_text">


                                                    <strong>{{__('frontend.billed_to')}}</strong>
                                                    Hasmukh December G

                                                    <br> <strong>{{__('frontend.address')}}</strong>Rajkot ,Rajkot

                                                    <br> <strong>{{__('frontend.mobile')}}: </strong> 0789456132
                                                </div>
                                            </div>
                                        </address>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <address>
                                            <strong>{{__('frontend.invoice_date')}}</strong> 01-01-2019<br>

                                            <strong>{{__('frontend.invoice_due_date')}}</strong> 30-01-2019<br>
                                            <strong> Tax Type:</strong> Out Of Tax<br>

                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">

                                    </div>
                                    <div class="col-xs-6 text-right">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                            <tr>
                                                <td class="text-center"><strong>{{__('frontend.no')}}</strong></td>
                                                <td class="text-left"><strong>{{__('frontend.description')}}</strong></td>
                                                <td class="text-center" width="10%"><strong>HSN/SAC</strong></td>
                                                <td class="text-center" width="10%"><strong>{{__('frontend.quantity')}}</strong></td>
                                                <td class="text-center" width="10%"><strong>Rate</strong></td>
                                                <td class="text-center" width="10%"><strong>{{__('frontend.amount')}}</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-left">Test</td>
                                                <td class="text-center"></td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">88.39</td>
                                                <td class="text-center">88.39</td>
                                            </tr>


                                            </tbody>
                                        </table>


                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-7 col-md-7">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">{{__('frontend.note')}}
                                    </label>
                                    <p>Testing only remarks</p>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right col-md-4">

                            <table class="table row-border dataTable no-footer" id="tab_logic_total">

                                <tbody>
                                <tr>
                                    <td width="75%" align="right"><b class="invoce-font">{{__('frontend.subtotal')}}</b></td>
                                    <td width="25%" align="right"><b class="invoce-font">88.39</b></td>
                                </tr>


                                <tr>
                                    <td align="right"><b class="invoce-font">{{__('frontend.total')}}</b></td>
                                    <td align="right"><b class="invoce-font">88</b></td>
                                </tr>


                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
