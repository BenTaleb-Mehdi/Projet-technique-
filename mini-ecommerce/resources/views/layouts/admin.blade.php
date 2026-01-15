<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Ecommerce</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
       @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/actions.js'])
</head>
<body>


<ul class="list-disc space-x-6 p-5">
  <li class="inline-block"><a class="inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-blue-600 hover:text-blue-70 focus:outline-hidden focus:text-blue-700" href="#">
      <a href="{{ route('products.index') }}" class="text-blue-800 " >All Products</a>
    </a></li>
</ul>

<div class="flex items-center  p-20">
    @yield('content')
</div>

</body>
</html>
