<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            margin: auto;
            width: 95%;
        }

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            text-align: center;
        }

        .remove-border {
            border: none !important;
            border-left: none !important;
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;

        }

        .heading1 {
            font-size: 20px;
            font-style: bold;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }

        .heading2 {
            font-size: 17px;
            font-style: bold;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }

        .heading3 {
            font-size: 12px;
            font-style: bold;

        }
    </style>
    <title>Case Board</title>
</head>
<body>
<div class="container">

    <h1 class="heading1" style="text-align: center;"><b>{{$setting->company_name ?? ''}}</b></h1>

    <center>{{$setting->address.',' ?? ''}} {{$setting->citys->name }} {{" - ".$setting->pincode.',' ?? ''}}  {{$setting->states->name.',' ?? '' }}  {{$setting->countrys->name ?? '' }}  </center>
    <hr>


    <table width="100%" border="0" style="border-style:none">
        <tr>
            <td class="remove-border heading2" width="50%" style="text-align: left;">Cases Listed
                on {!! date(LogActivity::commonDateFromatType(),strtotime($date)) !!}</td>
            <td class="remove-border heading2" width="50%" style="text-align: right;">{{__(frontend.total_cases)}}
                : {{ $totalCaseCount }}</td>
        </tr>

    </table>
    <br/>
    <br/>
    @if($totalCaseCount>0)
        @if(count($case_dashbord) && !empty($case_dashbord))
            @foreach($case_dashbord as $court)
                <br/>
                <table width="100%" border="0" style="border-style:none">
                    <tr>
                        <td class="remove-border heading2" width="50%"
                            style="text-align: left;">{!! $court['judge_name'] !!}</td>
                        <td class="remove-border heading2" width="50%" style="text-align: right;">{{__('frontend.cases')}}
                            : {!! $court['caseCourt'] !!}</td>
                    </tr>
                </table>
                <table width="100%" style="margin-top:12px; border-style: solid;">
                    <tr>
                        <td class="heading3" width="5%" style="text-align:center !important;"><b>Sr No </b></td>
                        <td class="heading3" width="20%" style="text-align:center !important;"><b>{{__('frontend.cases')}} </b></td>
                        <td class="heading3" width="40%" style="text-align:center !important;"><b> Petitioner vs
                                Respondent </b></td>
                        <td class="heading3" width="25%" style="text-align: center;"><b>{{__('frontend.stage_of_case')}}</b></td>
                        <td class="heading3" width="10%" style="text-align: center;"><b>{{__('frontend.next_date')}}</b></td>
                    </tr>

                    @if(!empty($court['cases']) && count($court['cases'])>0)
                        @foreach($court['cases'] as $key=>$value)
                            @php
                                $class = ( $value->priority=='High')?'<b>**</b>':(( $value->priority=='Medium')?'<b>*</b>':'');
                            @endphp
                            @if($value->client_position=='Petitioner')
                                @php
                                    $first = $value->first_name.' '.$value->last_name;
                                    $second = $value->party_name;
                                @endphp
                            @else
                                @php
                                    $first = $value->party_name;
                                    $second = $value->first_name.' '.$value->last_name;
                                @endphp
                            @endif

                            <tr>
                                <td class="heading3 " width="2%"
                                    style="text-align:center !important;">{!!$class!!}{{$key+1}}</td>
                                <td class="heading3 " width="20%" style="text-align:left !important;">&nbsp;<span
                                        class="text-primary">{{ $value->registration_number }}</span><br/><small>&nbsp;{{ ($value->caseSubType!='')?$value->caseSubType.'-'.$value->caseType:$value->caseType }}</small>
                                </td>
                                <td class="heading3 " width="35%" style="text-align:left !important;">
                                    &nbsp;{!! $first !!} <br/><b>&nbsp;VS</b><br/> {!! $second !!}</td>
                                <td class="heading3" width="28%" style="text-align: left;">
                                    &nbsp;{{ $value->case_status_name }}</td>
                                <td class="heading3" width="15%" style="text-align: left;">
                                    &nbsp; @if($value->hearing_date!='')
                                        {{date(LogActivity::commonDateFromatType(),strtotime($value->hearing_date))}}
                                    @else

                                    @endif</td>
                            </tr>

                        @endforeach

                    @endif
                </table>
            @endforeach
        @endif
        <br/><br/>
        <table width="100%" border="0" style="border-style:none">
            <tr>
                <td class="remove-border heading3" width="50%" style="text-align: left;">** Represents important
                    cases.<br/>* Represents medium cases.
                </td>
            </tr>
        </table>
    @endif
</div>
</body>
</html>
