@extends('admin.layout.app')
@section('title','Client')
@section('content')
  <div class="">

    <div class="page-title">
      <div class="title_left">
        <h3>Activity Logs</h3>
      </div>
    </div>

    <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">

            <div class="x_content">

              <table id="datatable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Login Username</th>
                    <th>Activity</th>
                    <th>{{__('frontend.date')}}</th>
                    <th>{{__('frontend.time')}}</th>
                    <th>{{__('frontend.action')}}</th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Login</td>
                    <td>26-09-2025</td>
                    <td>10:18:51</td>
                    <td >
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Login</td>
                    <td>25-09-2025</td>
                    <td>10:11:31</td>
                    <td >
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Login</td>
                    <td>24-09-2025</td>
                    <td>13:35:02</td>
                    <td >
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                           <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Logged out</td>
                    <td>09-03-2025</td>
                    <td>14:14:04</td>
                    <td>
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                           <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Login</td>
                    <td>09-03-2025</td>
                    <td>14:10:53</td>
                    <td >
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Login</td>
                    <td>04-03-2025</td>
                    <td>16:42:41</td>
                    <td>
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>Hasmukh Gondaliya</td>
                    <td>Logged out</td>
                    <td>04-03-2025</td>
                    <td>16:12:40</td>
                    <td>
                      <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                           </ul>
                        </li>
                      </ul>
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
