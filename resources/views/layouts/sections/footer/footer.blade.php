@php
$containerFooter =
isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
? 'container-xxl'
: 'container-fluid';

$footerCopyright = \App\Models\Pengaturan::get('footer_copyright', '© ' . date('Y'));
$footerMadeBy = \App\Models\Pengaturan::get('footer_made_by', config('variables.creatorName'));
$footerMadeByUrl = \App\Models\Pengaturan::get('footer_made_by_url', config('variables.creatorUrl'));
$footerShowLinks = \App\Models\Pengaturan::get('footer_show_links', '1') === '1';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="text-body">
        {!! $footerCopyright !!}
        , made with ❤️ by <a href="{{ !empty($footerMadeByUrl) ? $footerMadeByUrl : '#' }}" target="_blank" class="footer-link">{{ $footerMadeBy }}</a>
      </div>
      @if($footerShowLinks)
      <div class="d-none d-lg-inline-block">
        <a href="{{ config('variables.licenseUrl') ? config('variables.licenseUrl') : '#' }}" class="footer-link me-4" target="_blank">License</a>
        <a href="{{ config('variables.moreThemes') ? config('variables.moreThemes') : '#' }}" target="_blank" class="footer-link me-4">More Themes</a>
        <a href="{{ config('variables.documentation') ? config('variables.documentation') . '/laravel-introduction.html' : '#' }}" target="_blank" class="footer-link me-4">Documentation</a>
        <a href="{{ config('variables.support') ? config('variables.support') : '#' }}" target="_blank" class="footer-link">Support</a>
      </div>
      @endif
    </div>
  </div>
</footer>
<!-- / Footer -->
