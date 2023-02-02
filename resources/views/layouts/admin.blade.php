<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.meta')

        @stack('before-style')
        @include('includes.style')
        @stack('after-style')

        <title>@yield('title')</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="w-full bg-gray-50">
        {{-- @include('includes.header') --}}
        {{-- <div class="flex"> --}}
            @include('includes.sidebar')
            {{ $slot }}
        {{-- </div> --}}
        <!-- Scripts -->
        {{-- @stack('modals') --}}
        @stack('before-script')
        @include('includes.script')
        @stack('after-script')
        @livewireScripts
        <script>
            window.addEventListener('store-success', event => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    background: '#a5dc86',
                    color: 'white',
                    iconColor: 'white',
                    title: 'Data has been saved!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            })
        </script>
        <script>
            window.addEventListener('delete-success', event => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    background: '#f27474',
                    color: 'white',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    title: 'Delete success!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            })
        </script>
        <script>
            window.addEventListener('update-success', event => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    background: '#a5dc86',
                    color: 'white',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    title: 'Data has been updated!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            })
        </script>
    </body>
</html>
