<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/basic/basic_style.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('additional-css')

        <title>@yield('title', 'Home Page')</title>
    </head>
    <body>
        @include('partials.header')

        <main>
            @yield('main')
        </main>

        @include('partials.footer')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @yield('scripts')
    </body>

</html>
