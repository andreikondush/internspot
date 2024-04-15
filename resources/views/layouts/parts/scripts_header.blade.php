<!-- Jquery -->
{{ HTML::script('https://code.jquery.com/jquery-3.7.1.min.js') }}

<!-- Jquery UI -->
{{ HTML::script('https://code.jquery.com/ui/1.13.1/jquery-ui.min.js', ['integrity' => 'sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=', 'crossorigin' => 'anonymous']) }}

<!-- Sweetalert2 -->
{{ HTML::script('https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js') }}

<!-- Main Quill library -->
{{ HTML::script('/vendor/quill/dist/quill.min.js') }}
{{ HTML::script('/vendor/quill/modules/image-drop.min.js') }}
{{ HTML::script('/vendor/quill/modules/image-resize.min.js') }}
{{ HTML::script('/vendor/quill/modules/video-resize.min.js') }}
{{ HTML::script('/vendor/quill/modules/QuillDeltaToHtmlConverter.bundle.js') }}

<!-- Tagify -->
{{ HTML::script('https://cdn.jsdelivr.net/npm/@yaireo/tagify') }}

<!-- Fontawesome -->
{{ HTML::script('https://kit.fontawesome.com/56654edfb4.js', ['crossorigin' => 'anonymous']) }}

@stack('scripts_header')
