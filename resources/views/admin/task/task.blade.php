@extends('admin.layout.app')
@section('title', 'Task')
@section('content')

    <x-table-shell title="{{ __('frontend.task.task_management') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['task_add']))
                <x-action-button variant="primary" href="{{ route('tasks.create') }}">
                    <i class="fa fa-plus me-1"></i>
                    {{ __('frontend.task.add_task') }}
                </x-action-button>
            @endif
        </x-slot>

        <!-- The ID clientDataTable is preserved here because task-datatable.js targets it -->
        <table id="clientDataTable" class="w-full text-start text-sm text-dark" data-url="{{ route('task.list') }}">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">{{ __('frontend.task.no') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.task_name') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.related_to') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.start_date') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.deadline') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.members') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.status') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.task.priority') }}</th>
                    <th data-orderable="false" class="px-4 py-3 text-center">{{ __('frontend.task.action') }}</th>
                </tr>
            </thead>
        </table>
    </x-table-shell>

@endsection

@push('js')
    <script src="{{ asset('assets/js/task/task-datatable.js') }}"></script>
@endpush
