@php
    $pageIcon = $icon ?? null;
    if (!$pageIcon) {
        $seg = Request::segment(2);
        $iconMap = [
            'clients'           => 'fa fa-user-plus',
            'client_user'       => 'fa fa-user',
            'case'              => 'fa fa-gavel',
            'case-running'      => 'fa fa-gavel',
            'case-important'    => 'fa fa-star',
            'case-archived'     => 'fa fa-archive',
            'tasks'             => 'fa fa-check-square-o',
            'appointment'       => 'fa fa-calendar-check-o',
            'vendor'            => 'fa fa-truck',
            'role'              => 'fa fa-shield',
            'service'           => 'fa fa-wrench',
            'invoice'           => 'fa fa-file-text-o',
            'expense'           => 'fa fa-credit-card',
            'expense-type'      => 'fa fa-tags',
            'court-type'        => 'fa fa-building-o',
            'court'             => 'fa fa-university',
            'judge'             => 'fa fa-balance-scale',
            'case-type'         => 'fa fa-folder-open-o',
            'case-status'       => 'fa fa-info-circle',
            'tax'               => 'fa fa-percent',
            'general-setting'   => 'fa fa-sliders',
            'date-timezone'     => 'fa fa-clock-o',
            'mail-setup'        => 'fa fa-envelope-o',
            'invoice-setting'   => 'fa fa-file-text-o',
            'database-backup'   => 'fa fa-database',
            'team-members'      => 'fa fa-users',
            'recent-activity'   => 'fa fa-history',
            'profile'           => 'fa fa-user',
            'change-password'   => 'fa fa-key',
        ];
        $pageIcon = $iconMap[$seg] ?? null;
    }
@endphp

<div class="page-title">
    @if (isset($page_title))
        <div class="title_left">
            <h3>
                @if($pageIcon)
                    <i class="{{ $pageIcon }}"></i>&nbsp;&nbsp;
                @endif
                {{ $page_title }}
            </h3>
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
