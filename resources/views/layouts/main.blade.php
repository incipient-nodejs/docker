<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitkabir</title>
    <link rel="icon" type="image/png" href="{{ asset('dashboard/images/mdb-icon.PNG') }}" sizes="16x16">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="dark:bg-slate-800">
    <main>
        @yield('content')
    </main>
</body>

</html>
