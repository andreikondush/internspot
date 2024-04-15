<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.parts.head')
</head>
<body>

    {{-- START Content --}}
    @yield('content')
    {{-- END Content --}}

    {{-- START Scripts footer --}}
    @include('layouts.parts.scripts_footer')
    {{-- END Scripts footer --}}

</body>
</html>
