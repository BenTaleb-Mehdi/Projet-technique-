<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Ecommerce</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

       @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/main.js'])
</head>
<body>




<div class="flex items-center  p-20">
    @yield('content')
</div>

</body>
</html>
