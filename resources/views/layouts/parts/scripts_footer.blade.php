{{-- Preloader --}}
{{ HTML::script('/assets/js/preloader.js') }}

{{-- App --}}
{{ HTML::script('/assets/js/app.js?v=2', ['type' => 'module']) }}

@stack('scripts_footer')
