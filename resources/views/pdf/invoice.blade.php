<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice#{{ $invoice_no ?? ''}} | Advocate Diary</title>
    <style type="text/css">
        @media print {
            body {
                margin: 3mm 8mm 5mm 5mm;
            }
        }

        @page {
            margin: 3mm 8mm 5mm 5mm;
        }
    </style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">

    <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="25%">
                        @if($setting->logo_img !='')
                      
                            <img src="{{ asset('public/upload/lawlogo.png') }}">
                        @endif
                    </td>
                    <td width="75%" valign="top">
                        <h1 class="heading1" style="text-align: center;"><b>{{$setting->company_name ?? ''}}</b></h1>

                        <center>{{$setting->address.',' ?? ''}} {{$setting->citys->name }} {{" - ".$setting->pincode.',' ?? ''}}  {{$setting->states->name.',' ?? '' }}  {{$setting->countrys->name ?? '' }}  </center>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<hr>
<br>

<table border="1" cellpadding="0" cellspacing="0" width="100%"
       style="border-collapse:collapse;font-size: 13px;border: 1px solid #000;">

    <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="64%">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%">
                            <tr>
                                <td width="96%" style="font-size: 12px;">
                                    <b> {{__('frontend.billed_to')}}</b>
                                    <br>
                                    {{$advocate_client->first_name." ".$advocate_client->middle_name." ".$advocate_client->last_name }}
                                    <br>
                                    <strong>Address:- </strong>{{$advocate_client->address}}
                                    {{$city}}
                                    <br>
                                    <strong>{{__('frontend.mobile')}}:- </strong> {{$advocate_client->mobile}}
                                    <br/>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="36%" valign="top">
                        <table width="100%" border="0" cellpadding="4" cellspacing="0"
                               style="border-left:1px solid black;">
                            <tr>
                                <td width="50%"><strong>{{__('frontend.invoice_no')}}</strong></td>
                                <td width="50%">: {{ $invoice_no ?? ''}}</td>
                            </tr>
                            <tr>
                                <td style=""><strong>{{__('frontend.invoice_date')}}</strong></td>
                                <td style="">: {{ $inv_date ?? ''}}</td>
                            </tr>
                            <tr>
                                <td style="border-bottom:0px solid black;"><strong>{{__('frontend.invoice_due_date')}}</strong></td>
                                <td style="border-bottom:0px solid black;">: {{ $due_date ?? ''}}</td>
                            </tr>
                            <tr>
                                <td style="border-bottom:0px solid black;" colspan="2"></td>
                                <td style="border-bottom:0px solid black;" colspan="2"></td>
                            </tr>
                            <tr>
                                <td style="border-bottom:0px solid black;" colspan="2"></td>
                                <td style="border-bottom:0px solid black;" colspan="2"></td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <tr>
        <td height="0" style="border: 0px solid #fff;" border="0" valign="top">
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="3%" align="center"
                        style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">
                        <strong>Sr.</strong></td>
                    <td width="25%" align="left"
                        style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;"><strong>{{__('frontend.service')}}</strong>
                    </td>
                    <td width="50%" align="left"
                        style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;"><strong>{{__('frontend.description')}}</strong>
                    </td>

                    <td width="9%" align="center"
                        style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;"><strong>{{__('frontend.quantity')}}</strong>
                    </td>
                    <td width="7%" align="center"
                        style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">
                        <strong>{{__('frontend.rate')}}</strong></td>

                    <td width="15%" align="center" style="border-bottom: 1px solid #000;font-size: 9pt;"><strong>Net
                            <br>{{__('frontend.amount')}}</strong></td>
                </tr>


                @php $i=1; @endphp
                @if(!empty($iteam) && count($iteam)>0)
                    @foreach($iteam as $key=>$value)
                        <tr>
                            <td align="center"
                                style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">{{$i}}</td>
                            <td align="left"
                                style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">{{ $value['service_name'] ?? '' }}</td>
                            <td align="left"
                                style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">{{ $value['custom_items_name'] }}</td>
                            <td align="center"
                                style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">{{ $value['custom_items_qty'] }}</td>
                            <td align="right"
                                style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">{{ $value['item_rate'] }}</td>

                            <td align="center"
                                style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size: 9pt;">{!! App\Helpers\LogActivity::moneyFormatIndia(round($value['custom_items_amount'])) !!}</td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach

                @endif
                <tr>
                    <td style="border-right: 1px solid #000;font-size: 9pt;"></td>
                    <td align="center" style="border-right: 1px solid #000;font-size: 9pt;"><strong>{{__('frontend.total')}}</strong></td>
                    <td align="center" style="border-right: 1px solid #000;font-size: 9pt;"></td>
                    <td align="right" style="border-right: 1px solid #000;font-size: 9pt;"></td>

                    <td align="center" style="border-right: 1px solid #000;font-size: 9pt;"></td>
                    <td align="center" style="border-right: 1px solid #000;font-size: 9pt;"></td>
                </tr>
            </table>
        </td>
    </tr>


    <tr>
        <td>
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td width="72%" valign="top"><strong>{{ ucfirst($total_amount_world) }} </strong></br></br>
                    </td>
                    <td width="28%" border="0" style="border-left:1px solid black;">
                        <table width="100%" border="0">
                            <tr>
                                <td width="75%" style="font-weight: bolder;">{{__('frontend.subtotal')}}</td>
                                <td width="25%" style="font-weight: bolder;" align="right">{{$subTotal}}</td>
                            </tr>

                            <tr>
                                <td width="75%" style="font-weight: bolder;">{{__('frontend.tax')}}</td>
                                <td width="25%" style="font-weight: bolder;" align="right">{{$tax_amount}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bolder;">{{__('frontend.total')}}</td>
                                <td style="font-weight: bolder;" align="right">{{ $total_amount }}</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td style="font-size: 11px;"><strong style="font-size:13px;">Terms & Conditions :</strong> <br/>
                        <ul>
                            @if(!empty($myTerm))
                                @foreach($myTerm as $t)
                                    <li> {{ $t}}</li>
                                @endforeach
                            @endif
                        </ul>
                        <strong style="font-size:15px;">{{__('frontend.gstin_no')}}</strong></td>
                    <td style="border-left: 1px solid #000;" valign="top" width="33%">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <strong style="font-size:13px;">{{__('frontend.remarks')}} :</strong> <br/>
                                    {{$invoice->remarks}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
