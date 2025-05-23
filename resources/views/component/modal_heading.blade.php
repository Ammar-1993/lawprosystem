

<div class="page-title">

    @if (isset($action) && isset($model_title))
        <div class="title_left">
            <h3>{{ $page_title }}</h3>
        </div>
    @endif
    <div class="title_right">
        <div class="form-group pull-right top_search">

            @if ($action !="")
                <a  href="javascript:;" 
                   data-url='{{$action}}'
                   data-target-modal="{{$modal_id}}"
                   class="btn btn-primary call-model {{ isset($permission) &&  $permission=="1" ? '':'hidden' }}"><i
                        class="fa fa-plus" ></i> 
                    {{ " ".$model_title }}
                </a>
            @endif

        </div>
    </div>
</div>






