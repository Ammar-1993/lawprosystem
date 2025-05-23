@extends('admin.layout.app')
@section('title', 'Task Create')
@section('content')
    @component('component.heading', [
        'page_title' => __('frontend.task.add_task'),
        'action' => route('tasks.index'),
        'text' => __('frontend.back'),
    ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope"
                    action="{{ route('tasks.store') }}">
                    {{ csrf_field() }}
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.subject') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="task_subject"
                                    name="task_subject">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.start_date') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control dateFrom" id="start_date"
                                    name="start_date" readonly="">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.deadline') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control dateTo" id="end_date"
                                    name="end_date" readonly="">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.status') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="project_status_id" name="project_status_id">
                                    <option value="">{{ __('frontend.task.priority') }}</option>
                                    @foreach (LogActivity::getTaskStatusList() as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.select_status') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="">{{ __('frontend.task.select_priority') }}</option>
                                    @foreach (LogActivity::getTaskPriorityList() as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.assign_to') }}<span
                                        class="text-danger">*</span></label>

                                <select multiple class="form-control" id="assigned_to" name="assigned_to[]">
                                    <option value="">{{ __('frontend.task.select_user') }}</option>
                                    @foreach ($users as $key => $val)
                                        <option value="{{ $val->id }}">{{ $val->first_name . ' ' . $val->last_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.related_to') }}</label>
                                <select class="form-control selct2-width-100" id="related" name="related">
                                    <option value="">{{ __('frontend.task.nothing_selected') }}</option>
                                    <option value="case">{{ __('frontend.task.case') }}</option>
                                    <option value="other">{{ __('frontend.task.other') }}</option>
                                </select>
                            </div>


                            <div class="col-md-4 col-sm-12 col-xs-12 form-group task_selection hide">
                                <label for="fullname">{{ __('frontend.task.case') }}</label>
                                <select class="form-control selct2-width-100" id="related_id" name="related_id">
                                    <option value="">{{ __('frontend.task.select_user') }}</option>

                                </select>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.description') }}</label>
                                <textarea class="form-control" id="task_description" name="task_description"></textarea>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a class="btn btn-danger"
                                    href="{{ route('tasks.index') }}">{{ __('frontend.cancel') }}</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                        id="show_loader"></i>&nbsp;{{ __('frontend.save') }}
                                </button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@push('js')
    {{-- START: Added code to pass task translations --}}
    <script>
        // Use translations from 'backend.task' keys
        // This makes the object available as 'taskValidationMessages' in JS
        var taskValidationMessages = @json(__('backend.task'));

        // If you created task.php, use: var taskValidationMessages = @json(__('task'));

        // Optionally pass the current language if needed for datepicker/select2 JS logic
        var currentLang = '{{ app()->getLocale() }}';
    </script>
    {{-- END: Added code --}}

    <input type="hidden" name="select2Case" id="select2Case" value="{{ route('select2Case') }}">

    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">

    {{-- START: Added code to pass translations --}}
    <script>
        // Create a JS object with translated messages from the 'backend.task' keys
        var taskValidationMessages = @json(__('backend.task'));
    </script>
    {{-- END: Added code --}}

    {{-- Include your validation script AFTER defining the messages --}}
    <script src="{{ asset('assets/js/task/task-validation.js') }}"></script>
@endpush
