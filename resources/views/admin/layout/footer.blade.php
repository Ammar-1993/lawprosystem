{{-- footer.blade.php --}}
<footer class="lp-footer" role="contentinfo">
    <div class="lp-footer__inner">

        {{-- Start: branding & copyright --}}
        <div class="lp-footer__brand">
            <i class="fa fa-balance-scale lp-footer__icon" aria-hidden="true"></i>
            <span class="lp-footer__name">{{ __('frontend.footer.footer_text') }}</span>
            <span class="lp-footer__copy">&copy; {{ date('Y') }}</span>
            <span class="lp-footer__dot" aria-hidden="true">&middot;</span>
            <span class="lp-footer__rights">{{ __('frontend.footer.all_rights_reserved') }}</span>
        </div>

        {{-- End: system version badge --}}
        <div class="lp-footer__meta">
            <span class="lp-footer__status-dot" aria-hidden="true" title="System Online"></span>
            <span class="lp-footer__version">v1.0.0</span>
        </div>

    </div>
</footer>
