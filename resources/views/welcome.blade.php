<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/js/app.ts')
        <script src="http://localhost:8098"></script>
    </head>
    <body class="h-screen overflow-hidden font-sans antialiased bg-stone-50">
        <div id="app"></div>
    </body>
</html>
