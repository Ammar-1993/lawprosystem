@extends('admin.layout.app')
@section('title', 'Task Edit')
@section('content')
    @component('component.heading', [
        'page_title' => __('frontend.task.edit_task'),
        'action' => route('tasks.index'),
        'text' => __('frontend.back'),
    ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope"
                    action="{{ route('tasks.update', $task->id) }}">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH">
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.subject') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="task_subject"
                                    name="task_subject" value="{{ $task->task_subject ?? '' }}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.start_date') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="" readonly="" class="form-control dateFrom"
                                    id="start_date" name="start_date"
                                    value="{{ date(LogActivity::commonDateFromatType(), strtotime($task->start_date)) }}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.deadline') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="" readonly="" class="form-control dateTo"
                                    id="end_date" name="end_date"
                                    value="{{ date(LogActivity::commonDateFromatType(), strtotime($task->end_date)) }}">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.status') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="project_status_id" name="project_status_id">
                                    <option value="">{{ __('frontend.task.select_status') }}</option>
                                    @foreach (LogActivity::getTaskStatusList() as $key => $val)
                                        <option value="{{ $key }}"
                                            @if (isset($task) && $task->project_status == $key) selected="" @endif>{{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.priority') }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="">{{ __('frontend.task.select_priority') }}</option>
                                    @foreach (LogActivity::getTaskPriorityList() as $key => $val)
                                        <option value="{{ $key }}"
                                            @if (isset($task) && $task->priority == $key) selected="" @endif>{{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.assign_to') }}<span
                                        class="text-danger">*</span></label>

                                <select multiple class="form-control" id="assigned_to" name="assigned_to[]">
                                    <option value="">{{ __('frontend.task.select_user') }}</option>
                                    @foreach ($users as $key => $val)
                                        <option value="{{ $val->id }}"
                                            @if (in_array($val->id, $user_ids)) selected="" @endif>
                                            {{ $val->first_name . ' ' . $val->last_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.related_to') }}</label>
                                <select class="form-control selct2-width-100" id="related" name="related">
                                    <option value="">{{ __('frontend.task.nothing_selected') }}</option>
                                    <option value="case" @if (isset($task) && $task->rel_type == 'case') selected="" @endif>
                                        {{ __('frontend.task.case') }}
                                    </option>

                                    <option value="other" @if (isset($task) && $task->rel_type == 'other') selected="" @endif>
                                        {{ __('frontend.task.other') }}
                                    </option>
                                </select>
                            </div>


                            @php
                                $style = $task->rel_type == 'case' ? '' : 'hide';

                            @endphp


                            <div class="col-md-4 col-sm-12 col-xs-12 form-group task_selection {{ $style }}">
                                <label for="fullname">{{ __('frontend.task.case') }}</label>
                                <select class="form-control selct2-width-100" id="related_id" name="related_id">
                                    <option value="">{{ __('frontend.task.select_user') }}</option>
                                    @foreach ($cases as $key => $val)
                                        <option value="{{ $val->id }}"
                                            @if (isset($task) && $task->rel_id == $val->id) selected="" @endif>
                                            <strong>{{ $val->first_name . ' ' . $val->middle_name . ' ' . $val->last_name }}</strong><br>
                                            <div>{{ 'No- ' . $val->case_number }}</div>
                                        </option>
                                    @endforeach
                                </select>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.task.description') }}</label>
                                <textarea class="form-control" id="task_description" name="task_description">{{ $task->description ?? '' }}</textarea>
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

    <script src="{{ asset('assets/admin/js/selectjs.js') }}"></script>
    <input type="hidden" name="select2Case" id="select2Case" value="{{ route('select2Case') }}">
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
    <script src="{{ asset('assets/js/task/task-validation.js') }}"></script>
@endpush
