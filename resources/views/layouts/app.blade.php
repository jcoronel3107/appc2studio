@"
<!DOCTYPE html>
<html lang=\"{{ str_replace('_', '-', app()->getLocale()) }}\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel=\"preconnect\" href=\"https://fonts.bunny.net\">
    <link href=\"https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap\" rel=\"stylesheet\" />
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>.hidden { display: none; }</style>
</head>
<body class=\"font-sans antialiased\">
    <div class=\"min-h-screen bg-gray-100\">
        @include('layouts.navigation')
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
