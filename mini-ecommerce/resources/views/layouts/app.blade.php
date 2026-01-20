<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('views.app_name') }}</title>

       @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>


@include('products.partials.navbar')

<div class="flex items-center  px-20 py-8">
    @yield('content')
</div>

</body>
</html>
