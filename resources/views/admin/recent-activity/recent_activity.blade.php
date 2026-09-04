@extends('admin.layout.app')
@section('title', 'Activity Logs')
@section('content')
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3><i class="fa fa-history"></i>&nbsp;&nbsp;Activity Logs</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel lp-card">

                    <div class="x_content">

                        <table id="datatable" class="table lp-table">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user"></i>&nbsp;&nbsp;Login Username</th>
                                    <th><i class="fa fa-bolt"></i>&nbsp;&nbsp;Activity</th>
                                    <th><i class="fa fa-calendar"></i>&nbsp;&nbsp;{{ __('frontend.date') }}</th>
                                    <th><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('frontend.time') }}</th>
                                    <th width="10%" style="text-align: center;"><i class="fa fa-cog"></i>&nbsp;&nbsp;{{ __('frontend.action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-active">Login</span></td>
                                    <td>26-09-2025</td>
                                    <td>10:18:51</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-active">Login</span></td>
                                    <td>25-09-2025</td>
                                    <td>10:11:31</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-active">Login</span></td>
                                    <td>24-09-2025</td>
                                    <td>13:35:02</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-inactive">Logged out</span></td>
                                    <td>09-03-2025</td>
                                    <td>14:14:04</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-active">Login</span></td>
                                    <td>09-03-2025</td>
                                    <td>14:10:53</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-active">Login</span></td>
                                    <td>04-03-2025</td>
                                    <td>16:42:41</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Hasmukh Gondaliya</strong></td>
                                    <td><span class="badge-lp badge-inactive">Logged out</span></td>
                                    <td>04-03-2025</td>
                                    <td>16:12:40</td>
                                    <td style="text-align: center;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle lp-btn lp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a href="javascript:void(0);"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
