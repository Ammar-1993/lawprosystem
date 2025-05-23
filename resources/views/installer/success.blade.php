@extends('installer.app')
@section('title','Success')
@section('content')

    <section class="login_content">

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="float: none;">Success</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- <h1>Advocate Diary</h1> -->
                        <h2> System install successfully. </h2>
                        <p class="text-left">Now your system is install successfully on your server.now click on below login button with your credentials</p>
                        <div>
                            <a href="{{url('/')}}" class="btn btn-default pull-right">Login Now</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">

                            <div class="clearfix"></div>
                            <br/>

                            <div>

                                <p>©2025 Law Pro</p>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection