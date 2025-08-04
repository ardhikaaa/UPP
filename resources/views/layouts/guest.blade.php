<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UKS Login</title>
    @vite('resources/css/app.css') <!-- Tailwind -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-no-repeat bg-center bg-[length:1000px] flex items-center justify-center"
      style="background-image: url('{{ asset('images/illustration-login.png') }}')">
    
    {{ $slot }}

</body>
</html>
