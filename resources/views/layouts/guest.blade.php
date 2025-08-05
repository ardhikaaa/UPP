<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UKS Login</title>
    @vite('resources/css/app.css') <!-- Tailwind -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    {{-- Illustration --}}
    <div class="w-1/2 hidden md:block ml-20">
        <img src="{{ asset('images/illustration-login.png') }}" alt="Login Illustration"
            class="w-full h-full object-cover">
    </div>

    {{-- Login Card --}}
    <div class="w-full md:w-1/2 p-8 items-center justify-center">
        {{ $slot }}
    </div>
</body>

</html>
