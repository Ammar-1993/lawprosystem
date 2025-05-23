@extends('admin.layout.app')
@section('title', 'Task')
@section('content')

    <div class="">
        @component('component.heading', [
            'page_title' => __('frontend.task.task_management'),
            'action' => route('tasks.create'),
            'text' => __('frontend.task.add_task'),
            'permission' => $adminHasPermition->can(['task_add']),
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="clientDataTable" class="table" data-url="{{ route('task.list') }}">
                            <thead>
                                <tr>
                                    <th>{{ __('frontend.task.no') }}</th>
                                    <th>{{ __('frontend.task.task_name') }}</th>
                                    <th>{{ __('frontend.task.related_to') }}</th>
                                    <th>{{ __('frontend.task.start_date') }}</th>
                                    <th>{{ __('frontend.task.deadline') }}</th>
                                    <th>{{ __('frontend.task.members') }}</th>
                                    <th>{{ __('frontend.task.status') }}</th>
                                    <th>{{ __('frontend.task.priority') }}</th>
                                    <th data-orderable="false" class="text-center">{{ __('frontend.task.action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/task/task-datatable.js') }}"></script>
@endpush
