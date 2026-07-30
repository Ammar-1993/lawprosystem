@extends('admin.layout.app')
@section('title', 'Task Create')
@section('content')

    <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope" action="{{ route('tasks.store') }}">
        {{ csrf_field() }}
        
        <div class="flex items-center justify-between mb-lg">
            <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.task.add_task') }}</h3>
            <x-action-button variant="primary" href="{{ route('tasks.index') }}">
                {{ __('frontend.back') }}
            </x-action-button>
        </div>

        @include('component.error')

        <x-form-card title="{{ __('frontend.task.add_task') }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <!-- Subject -->
                <div>
                    <label for="task_subject" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.subject') }} <span class="text-danger">*</span></label>
                    <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="task_subject" name="task_subject">
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.start_date') }} <span class="text-danger">*</span></label>
                    <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent dateFrom" id="start_date" name="start_date" readonly="">
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.deadline') }} <span class="text-danger">*</span></label>
                    <input type="text" placeholder="" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent dateTo" id="end_date" name="end_date" readonly="">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <!-- Status -->
                <div>
                    <label for="project_status_id" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.status') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="project_status_id" name="project_status_id">
                        <option value="">{{ __('frontend.task.priority') }}</option>
                        @foreach (LogActivity::getTaskStatusList() as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.select_status') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="priority" name="priority">
                        <option value="">{{ __('frontend.task.select_priority') }}</option>
                        @foreach (LogActivity::getTaskPriorityList() as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Assign To -->
                <div>
                    <label for="assigned_to" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.assign_to') }} <span class="text-danger">*</span></label>
                    <select multiple class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="assigned_to" name="assigned_to[]">
                        <option value="">{{ __('frontend.task.select_user') }}</option>
                        @foreach ($users as $key => $val)
                            <option value="{{ $val->id }}">{{ $val->first_name . ' ' . $val->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <!-- Related To -->
                <div>
                    <label for="related" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.related_to') }}</label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent selct2-width-100" id="related" name="related">
                        <option value="">{{ __('frontend.task.nothing_selected') }}</option>
                        <option value="case">{{ __('frontend.task.case') }}</option>
                        <option value="other">{{ __('frontend.task.other') }}</option>
                    </select>
                </div>

                <!-- Case Selection (Shown/Hidden by JS) -->
                <div class="task_selection hide">
                    <label for="related_id" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.case') }}</label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent selct2-width-100" id="related_id" name="related_id">
                        <option value="">{{ __('frontend.task.select_user') }}</option>
                    </select>
                </div>
            </div>

            <div class="mb-lg">
                <label for="task_description" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.task.description') }}</label>
                <textarea class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent" id="task_description" name="task_description" rows="4"></textarea>
            </div>

            <x-slot name="footer">
                <x-action-button variant="danger" href="{{ route('tasks.index') }}">
                    {{ __('frontend.cancel') }}
                </x-action-button>
                <x-action-button variant="success" type="submit">
                    <i class="fa fa-save me-1" id="show_loader"></i> {{ __('frontend.save') }}
                </x-action-button>
            </x-slot>
        </x-form-card>
    </form>

    <input type="hidden" name="select2Case" id="select2Case" value="{{ route('select2Case') }}">
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">

@endsection

@push('js')
    <script>
        var taskValidationMessages = @json(__('backend.task'));
        var currentLang = '{{ app()->getLocale() }}';
    </script>
    <script src="{{ asset('assets/js/task/task-validation.js') }}"></script>
@endpush
