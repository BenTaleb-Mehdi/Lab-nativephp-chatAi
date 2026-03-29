<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Ai chat with Mehdi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

 


</head>

<body class="h-full font-sans antialiased" style="color:#e0e0e0">

@yield('content')



</body>
</html>