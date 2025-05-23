@if(count($errors) > 0)
    <div class="col-12">
        <div class="form-group">
            <div class="alert alert-info alert-dismissible fade in" role="alert">
                @foreach ($errors->all() as $error)

                    <strong class="mb-1">{{ $error }}<br></strong>
                @endforeach
            </div>
        </div>
    </div>
@endif
