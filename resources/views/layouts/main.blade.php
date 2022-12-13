<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Classification Goat</title>
    @vite('resources/css/app.css')
    @livewireStyles
    @stack('styles')
</head>
<body class="antialiased bg-gray-900 px-5 py-10">

    @yield('content')

    @vite('resources/js/app.js')
    @livewireScripts
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @method('scripts')
</body>
</html>
