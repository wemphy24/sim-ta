<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.meta')

        @stack('before-style')
        @include('includes.style')
        @stack('after-style')

        <title>Login</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @yield('content')
        @stack('before-script')
        @include('includes.script')
        @stack('after-script')
    </body>
</html>
