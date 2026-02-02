<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('views.app_name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
       @vite(['resources/css/app.css', 'resources/js/actions.js', 'resources/js/app.js'])
       
</head>
<body>
    <div id="admin-layout" x-data="productManager({ indexUrl: '{{ route('admin.partials.index') }}' })">


@include('admin.partials.navbar')

<div class="flex items-center  p-20">
    @yield('content')
</div>

</div>
</body>
</html>
