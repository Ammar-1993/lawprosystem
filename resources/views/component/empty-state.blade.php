{{-- 
  Component: Empty State
  Usage: @include('component.empty-state', ['icon' => 'fa-folder-open', 'title' => 'No Cases Found', 'desc' => 'You have not added any cases yet.'])
--}}
<div class="lp-empty-state">
    <i class="fa {{ $icon ?? 'fa-inbox' }} lp-empty-state__icon"></i>
    <h4 class="lp-empty-state__title">{{ $title ?? __('frontend.no_data_found') }}</h4>
    @if(isset($desc))
        <p class="lp-empty-state__desc">{{ $desc }}</p>
    @endif
    @if(isset($action_url) && isset($action_text))
        <a href="{{ $action_url }}" class="lp-btn lp-btn-primary">
            <i class="fa fa-plus"></i> {{ $action_text }}
        </a>
    @endif
</div>
