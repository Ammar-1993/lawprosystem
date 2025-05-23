<div class="page-title">
    @if (isset($page_title))
        <div class="title_left">
            <h3>{{ $page_title }}</h3>
        </div>
    @endif
    <div class="title_right">
        <div class="form-group pull-right top_search">
            @if (isset($action) )

                <a href="{{ $action }}"
                   class="btn btn-primary {{ isset($permission) &&  $permission=="1" ? '':'hidden' }}"><i
                        class="fa fa-plus"></i> {{ $text }}</a>
            @endif


        </div>
    </div>
</div>
