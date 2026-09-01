{{-- footer.blade.php --}}
<footer class="lp-footer" role="contentinfo">
    <div class="lp-footer__inner">

        {{-- Left / Start: branding --}}
        <div class="lp-footer__brand">
            <i class="fa fa-balance-scale" aria-hidden="true"></i>
            <span>{{ __('frontend.footer.footer_text') }}</span>
        </div>

        {{-- Right / End: version pill --}}
        <div class="lp-footer__meta">
            <span class="lp-footer__version">v1.0</span>
            <span class="lp-footer__dot" aria-hidden="true">·</span>
            <span>{{ date('Y') }}</span>
        </div>

    </div>
</footer>
